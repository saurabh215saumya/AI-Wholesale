<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keyword extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_keywords';
        $this->load->model('Keyword_model');
        $this->load->library('Csvimport');
        $this->controller = $this->router->fetch_class();
    }

    private function _auth() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
    }

    public function index() {
        $this->_auth();
        $data['allKeywords'] = $this->Keyword_model->all();
        $data['controller']  = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('keyword/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function add() {
        $this->_auth();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('keyword/add', $data);
        $this->load->view('template/admin_footer');
    }

    public function save() {
        $this->_auth();
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $this->db->insert($this->table, array_merge($this->_seo_post(), array(
                'keyword'    => $this->input->post('keyword'),
                'status'     => $this->input->post('status'),
                'addedOn'    => date('Y-m-d H:i:s'),
            )));
            $this->session->set_flashdata('response', '<div class="alert alert-success">Keyword added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        $this->_auth();
        $data['details']    = $this->Keyword_model->find($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('keyword/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update() {
        $this->_auth();
        $id = $this->input->post('keyword_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $this->db->where('id', $id)->update($this->table, array_merge($this->_seo_post(), array(
                'keyword'    => $this->input->post('keyword'),
                'status'     => $this->input->post('status'),
                'updatedOn'  => date('Y-m-d H:i:s'),
            )));
            $this->session->set_flashdata('response', '<div class="alert alert-success">Keyword updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function delete($id) {
        $this->_auth();
        $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
        redirect($this->controller);
    }

    public function sample_csv() {
        $this->_auth();
        $file = FCPATH . 'assets/sample_keywords.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample_keywords.csv"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    public function upload_csv() {
        $this->_auth();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('keyword/upload_csv', $data);
        $this->load->view('template/admin_footer');
    }

    private function _seo_post() {
        $fields = ['meta_title','meta_description','meta_keywords','h1_tag','h2_tag','h3_tag',
            'img_alt_1','img_alt_2','img_alt_3','img_alt_4','img_alt_5','robots','revisit_after',
            'canonical','og_locale','og_type','og_image','og_tag','og_title','og_url',
            'og_description','og_site_name','geo_region','geo_place_name','geo_position','icbm',
            'geography','author','subject','owner','coverage','language','distribution','country',
            'cache_control','instagram','facebook','youtube','twitter_site','twitter_description'];
        $data = array();
        foreach ($fields as $f) $data[$f] = $this->input->post($f);
        return $data;
    }

    public function import_csv() {
        $this->_auth();
        if (!is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Please select a CSV file.</div>');
            redirect($this->controller . '/upload_csv');
        }
        if (strtolower(pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION)) !== 'csv') {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Only CSV files allowed.</div>');
            redirect($this->controller . '/upload_csv');
        }
        $csvData = $this->csvimport->get_array($_FILES['csv_file']['tmp_name']);
        if (empty($csvData)) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV file is empty.</div>');
            redirect($this->controller . '/upload_csv');
        }
        // Strip BOM
        $firstKey = array_keys($csvData[0])[0];
        if (substr($firstKey, 0, 3) === "\xEF\xBB\xBF") {
            foreach ($csvData as &$r) { $r['Keyword'] = $r[$firstKey]; unset($r[$firstKey]); }
            unset($r);
        }
        if (!array_key_exists('Keyword', $csvData[0])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV must have a <strong>Keyword</strong> column.</div>');
            redirect($this->controller . '/upload_csv');
        }
        $inserted = 0; $updated = 0; $skipped = 0;
        foreach ($csvData as $row) {
            $kw = trim($row['Keyword'] ?? '');
            if ($kw === '') { $skipped++; continue; }
            $data = array(
                'keyword'             => $kw,
                'status'              => 1,
                'meta_title'          => trim($row['MetaTitle'] ?? ''),
                'meta_description'    => trim($row['MetaDescription'] ?? ''),
                'meta_keywords'       => trim($row['MetaKeywords'] ?? ''),
                'h1_tag'              => trim($row['H1Tag'] ?? ''),
                'h2_tag'              => trim($row['H2Tag'] ?? ''),
                'h3_tag'              => trim($row['H3Tag'] ?? ''),
                'robots'              => trim($row['Robots'] ?? ''),
                'canonical'           => trim($row['Canonical'] ?? ''),
                'og_title'            => trim($row['OgTitle'] ?? ''),
                'og_description'      => trim($row['OgDescription'] ?? ''),
                'og_image'            => trim($row['OgImage'] ?? ''),
                'og_url'              => trim($row['OgUrl'] ?? ''),
                'og_site_name'        => trim($row['OgSiteName'] ?? ''),
                'og_locale'           => trim($row['OgLocale'] ?? ''),
                'og_type'             => trim($row['OgType'] ?? ''),
                'og_tag'              => trim($row['OgTag'] ?? ''),
                'author'              => trim($row['Author'] ?? ''),
                'twitter_site'        => trim($row['TwitterSite'] ?? ''),
                'twitter_description' => trim($row['TwitterDescription'] ?? ''),
                'facebook'            => trim($row['Facebook'] ?? ''),
                'instagram'           => trim($row['Instagram'] ?? ''),
                'youtube'             => trim($row['Youtube'] ?? ''),
            );
            $existing = $this->db->where('keyword', $kw)->where('is_deleted', 0)->get($this->table)->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update($this->table, array_merge($data, ['updatedOn' => date('Y-m-d H:i:s')]));
                $updated++;
            } else {
                $data['addedOn'] = date('Y-m-d H:i:s');
                $this->db->insert($this->table, $data);
                $inserted++;
            }
        }
        $msg = 'Import complete. Inserted: ' . $inserted . ', Updated: ' . $updated;
        if ($skipped) $msg .= ', Skipped: ' . $skipped;
        $this->session->set_flashdata('response', '<div class="alert alert-success">' . $msg . '</div>');
        redirect($this->controller);
    }
}
