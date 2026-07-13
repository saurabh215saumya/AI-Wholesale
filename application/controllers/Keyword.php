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
        $perPage = 20;
        $page    = max(1, (int)($this->input->get('page') ?: 1));
        $offset  = ($page - 1) * $perPage;
        $total   = $this->Keyword_model->total();

        $this->load->library('pagination');
        $this->pagination->initialize(array(
            'base_url'           => base_url('keyword') . '?page=',
            'total_rows'         => $total,
            'per_page'           => $perPage,
            'cur_page'           => $page,
            'use_page_numbers'   => TRUE,
            'reuse_query_string' => FALSE,
            'full_tag_open'      => '<ul class="pagination pagination-sm no-margin">',
            'full_tag_close'     => '</ul>',
            'first_tag_open'     => '<li>', 'first_tag_close'  => '</li>',
            'last_tag_open'      => '<li>', 'last_tag_close'   => '</li>',
            'next_tag_open'      => '<li>', 'next_tag_close'   => '</li>',
            'prev_tag_open'      => '<li>', 'prev_tag_close'   => '</li>',
            'cur_tag_open'       => '<li class="active"><a href="#">', 'cur_tag_close' => '</a></li>',
            'num_tag_open'       => '<li>', 'num_tag_close'    => '</li>',
        ));

        $data['allKeywords'] = $this->Keyword_model->paginate($perPage, $offset);
        $data['pagination']  = $this->pagination->create_links();
        $data['offset']      = $offset;
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
                'location'   => $this->input->post('location'),
                'page_slug'  => $this->input->post('page_slug'),
                'page_title' => $this->input->post('page_title'),
                'page_url'   => $this->input->post('page_url'),
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
                'location'   => $this->input->post('location'),
                'page_slug'  => $this->input->post('page_slug'),
                'page_title' => $this->input->post('page_title'),
                'page_url'   => $this->input->post('page_url'),
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
        $fields = ['meta_title','meta_description','meta_keywords','meta_heading','h1_tag','h2_tag','h3_tag',
            'img_alt_1','img_alt_2','img_alt_3','img_alt_4','img_alt_5','robots','revisit_after',
            'canonical','og_locale','og_type','og_image','og_tag','og_title','og_url',
            'og_description','og_site_name','geo_region','geo_place_name','geo_position','icbm',
            'geography','author','subject','owner','coverage','language','distribution','country',
            'cache_control','instagram','facebook','youtube','twitter_site','twitter_description'];
        $data = array();
        foreach ($fields as $f) $data[$f] = $this->input->post($f);
        return $data;
    }

    public function location($location) {
        $location = urldecode($location);
        $data['location']  = $location;
        $data['keywords']  = $this->db->where('location', $location)->where('status', 1)->where('is_deleted', 0)->order_by('keyword', 'ASC')->get($this->table)->result_array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('keyword/location_keywords', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function keyword_page($slug) {
        $row = $this->db->where('page_slug', $slug)->where('status', 1)->where('is_deleted', 0)->get($this->table)->row_array();
        if (empty($row)) show_404();
        $data['kw'] = $row;
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('keyword/keyword_page', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function import_csv() {
        $this->_auth();
        if (empty($_FILES['csv_file']['tmp_name']) || !is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Please select a CSV file.</div>');
            redirect($this->controller . '/upload_csv');
        }
        if (strtolower(pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION)) !== 'csv') {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Only CSV files allowed.</div>');
            redirect($this->controller . '/upload_csv');
        }

        // Parse CSV manually to support both tab and comma delimiters
        $handle = fopen($_FILES['csv_file']['tmp_name'], 'r');
        if (!$handle) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Could not read CSV file.</div>');
            redirect($this->controller . '/upload_csv');
        }

        // Read first line to detect delimiter and strip BOM
        $firstLine = fgets($handle);
        $firstLine = ltrim($firstLine, "\xEF\xBB\xBF"); // strip UTF-8 BOM
        rewind($handle);
        // Re-read without BOM by writing clean content to temp
        $tmpClean = tmpfile();
        fwrite($tmpClean, $firstLine);
        while (!feof($handle)) { fwrite($tmpClean, fgets($handle)); }
        fclose($handle);
        rewind($tmpClean);

        // Detect delimiter: tab or comma
        $delim = (substr_count($firstLine, "\t") > substr_count($firstLine, ',')) ? "\t" : ',';

        // Read headers
        $headers = fgetcsv($tmpClean, 0, $delim);
        if (empty($headers)) {
            fclose($tmpClean);
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV file is empty or unreadable.</div>');
            redirect($this->controller . '/upload_csv');
        }
        // Trim all header names
        $headers = array_map('trim', $headers);

        // Build lookup: lowercase-trimmed header => original index
        $hMap = array();
        foreach ($headers as $i => $h) { $hMap[strtolower(trim($h))] = $i; }

        // Helper: get value by header name (case-insensitive, trimmed)
        $col = function($row, $name) use ($hMap) {
            $key = strtolower(trim($name));
            return isset($hMap[$key]) && isset($row[$hMap[$key]]) ? trim($row[$hMap[$key]]) : '';
        };

        // Check required column exists
        if (!isset($hMap['keyword_name']) && !isset($hMap['keyword'])) {
            fclose($tmpClean);
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV must have a <strong>Keyword_name</strong> column.</div>');
            redirect($this->controller . '/upload_csv');
        }

        // Known header values to skip (in case CSV header row appears in data)
        $headerValues = array('keyword_name', 'keyword', 'keyword name');

        $inserted = 0; $updated = 0; $skipped = 0;
        while (($row = fgetcsv($tmpClean, 0, $delim)) !== FALSE) {
            $kw = $col($row, 'Keyword_name') ?: $col($row, 'Keyword');
            if ($kw === '' || in_array(strtolower($kw), $headerValues)) { $skipped++; continue; }

            $data = array(
                'keyword'             => $kw,
                'location'            => $col($row, 'Location'),
                'page_slug'           => $col($row, 'page_slug'),
                'page_title'          => $col($row, 'page_title'),
                'page_url'            => $col($row, 'page_url'),
                'status'              => 1,
                'meta_title'          => $col($row, 'meta_title'),
                'meta_description'    => $col($row, 'meta_description'),
                'meta_keywords'       => $col($row, 'meta_keywords'),
                'meta_heading'        => $col($row, 'meta_heading'),
                'h1_tag'              => $col($row, 'h1_tag'),
                'h2_tag'              => $col($row, 'h2_tag'),
                'h3_tag'              => $col($row, 'h3_tag'),
                'img_alt_1'           => $col($row, 'image_alt_1'),
                'img_alt_2'           => $col($row, 'image_alt_2'),
                'img_alt_3'           => $col($row, 'image_alt_3'),
                'robots'              => $col($row, 'robots'),
                'revisit_after'       => $col($row, 'revisit after'),
                'canonical'           => $col($row, 'canonical'),
                'og_title'            => $col($row, 'og_title'),
                'og_description'      => $col($row, 'og_description'),
                'og_image'            => $col($row, 'og_image'),
                'og_url'              => $col($row, 'og_url'),
                'og_site_name'        => $col($row, 'og_site_name'),
                'og_locale'           => $col($row, 'og_local') ?: $col($row, 'og_locale'),
                'og_type'             => $col($row, 'og_type'),
                'og_tag'              => $col($row, 'og_tag'),
                'author'              => $col($row, 'author'),
                'geo_region'          => $col($row, 'geo_region'),
                'geo_place_name'      => $col($row, 'geo_place_name'),
                'geo_position'        => $col($row, 'geo_position'),
                'icbm'                => $col($row, 'icbm'),
                'subject'             => $col($row, 'subject'),
                'owner'               => $col($row, 'owner'),
                'coverage'            => $col($row, 'coverage'),
                'language'            => $col($row, 'language'),
                'distribution'        => $col($row, 'distribution'),
                'country'             => $col($row, 'country'),
                'geography'           => $col($row, 'geography'),
                'cache_control'       => $col($row, 'cache-control'),
                'instagram'           => $col($row, 'instagram'),
                'facebook'            => $col($row, 'facebook'),
                'youtube'             => $col($row, 'youtube'),
                'twitter_site'        => $col($row, 'tik-tok'),
                'twitter_description' => $col($row, 'ai chatbot'),
            );

            $existing = $this->db->where('keyword', $kw)->where('location', $data['location'])->where('is_deleted', 0)->get($this->table)->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update($this->table, array_merge($data, ['updatedOn' => date('Y-m-d H:i:s')]));
                $updated++;
            } else {
                $data['addedOn'] = date('Y-m-d H:i:s');
                $this->db->insert($this->table, $data);
                $inserted++;
            }
        }
        fclose($tmpClean);

        $msg = 'Import complete. Inserted: ' . $inserted . ', Updated: ' . $updated;
        if ($skipped) $msg .= ', Skipped: ' . $skipped;
        $this->session->set_flashdata('response', '<div class="alert alert-success">' . $msg . '</div>');
        redirect($this->controller);
    }
}
