<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_category';
        $this->load->model('Category_model');
        $this->load->model('Product_model');
        $this->load->model('Home_model');
        $this->controller = $this->router->fetch_class();
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['allcategories'] = $this->Category_model->allCategories();
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('category/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function addcategory() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('category/add_category', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_newcategory() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->addcategory();
        } else {
            $name = $this->input->post('category_name');
            $insert = array(
                'category_name'  => $name,
                'category_slug'  => url_title(strtolower($name), '-'),
                'description'    => $this->input->post('description'),
                'status'         => $this->input->post('status'),
                'addedOn'        => date('Y-m-d H:i:s'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/categories';
            $img = upload_image('image_file', $uploads_dir);
            if ($img) $insert['image'] = $img;
            $banner = upload_image('banner_image_file', $uploads_dir, 1350, 530);
            if ($banner) $insert['banner_image'] = $banner;
            $this->db->insert($this->table, $insert);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Category added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details'] = $this->Category_model->categoryDetails($id);
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('category/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_category() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('category_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $name = $this->input->post('category_name');
            $update = array(
                'category_name'      => $name,
                'category_slug'      => url_title(strtolower($name), '-'),
                'description'        => $this->input->post('description'),
                'status'             => $this->input->post('status'),
                'meta_title'         => $this->input->post('meta_title'),
                'meta_description'   => $this->input->post('meta_description'),
                'meta_keywords'      => $this->input->post('meta_keywords'),
                'h1_tag'             => $this->input->post('h1_tag'),
                'h2_tag'             => $this->input->post('h2_tag'),
                'h3_tag'             => $this->input->post('h3_tag'),
                'img_alt_1'          => $this->input->post('img_alt_1'),
                'img_alt_2'          => $this->input->post('img_alt_2'),
                'img_alt_3'          => $this->input->post('img_alt_3'),
                'img_alt_4'          => $this->input->post('img_alt_4'),
                'img_alt_5'          => $this->input->post('img_alt_5'),
                'robots'             => $this->input->post('robots'),
                'revisit_after'      => $this->input->post('revisit_after'),
                'og_locale'          => $this->input->post('og_locale'),
                'og_type'            => $this->input->post('og_type'),
                'og_image'           => $this->input->post('og_image'),
                'og_tag'             => $this->input->post('og_tag'),
                'og_title'           => $this->input->post('og_title'),
                'og_url'             => $this->input->post('og_url'),
                'og_description'     => $this->input->post('og_description'),
                'og_site_name'       => $this->input->post('og_site_name'),
                'author'             => $this->input->post('author'),
                'canonical'          => $this->input->post('canonical'),
                'geo_region'         => $this->input->post('geo_region'),
                'geo_place_name'     => $this->input->post('geo_place_name'),
                'geo_position'       => $this->input->post('geo_position'),
                'icbm'               => $this->input->post('icbm'),
                'subject'            => $this->input->post('subject'),
                'owner'              => $this->input->post('owner'),
                'coverage'           => $this->input->post('coverage'),
                'language'           => $this->input->post('language'),
                'distribution'       => $this->input->post('distribution'),
                'country'            => $this->input->post('country'),
                'geography'          => $this->input->post('geography'),
                'cache_control'      => $this->input->post('cache_control'),
                'instagram'          => $this->input->post('instagram'),
                'twitter_description'=> $this->input->post('twitter_description'),
                'facebook'           => $this->input->post('facebook'),
                'twitter_site'       => $this->input->post('twitter_site'),
                'youtube'            => $this->input->post('youtube'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/categories';
            $old = $this->input->post('image_file_name');
            $img = upload_image('image_file', $uploads_dir);
            if ($img) { $update['image'] = $img; delete_file($uploads_dir . '/' . $old); }
            $old_banner = $this->input->post('banner_image_file_name');
            $banner = upload_image('banner_image_file', $uploads_dir, 1350, 530);
            if ($banner) { $update['banner_image'] = $banner; delete_file($uploads_dir . '/' . $old_banner); }
            $this->db->where('id', $id)->update($this->table, $update);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Category updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function changestatus() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id  = $this->input->post('statusid');
        $val = $this->input->post('statusvalue') ? 0 : 1;
        $cn  = $this->input->post('controllername');
        $this->Category_model->changeStatus($id, $val);
        $color = $val ? '#00a65a' : '#ff0000';
        $title = $val ? 'Active' : 'In Active';
        $icon  = $val ? 'fa-check' : 'fa-ban';
        echo "<span statusid=$id statusvalue=$val controllername=$cn style='color:$color;cursor:pointer;' title='$title'><i class='fa fa-2x $icon'></i></span>";
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Category_model->deleteRecord($id);
        redirect($this->controller);
    }

    public function getSubcategoriesByCategory() {
        $cat_id = $this->input->post('category_id');
        $subs = getAllSubCategory($cat_id);
        $html = '<option value="">Select Sub Category</option>';
        foreach ($subs as $s) {
            $html .= '<option value="' . $s->id . '">' . $s->sub_category_name . '</option>';
        }
        echo $html;
    }

    public function category_list($slug) {
        $pageSlug = $this->uri->segment(1);
        $limit  = PER_PAGE_DATA;
        $pageNo = $this->input->get('page') ?: 0;
        $offset = $limit * $pageNo;
        if ($pageSlug === 'categories') {
            $catId = getCategoryIdByCatSlug($slug);
            $data['allProducts'] = $this->Product_model->getProductsByCategory($catId, $limit, $offset);
            $data['totalCount']  = $this->Product_model->countByCategory($catId);
            $data['pageTitle']   = getCategoryName($catId);
        } else {
            $subId = getSubCategoryIdBySubCatSlug($slug);
            $data['allProducts'] = $this->Product_model->getProductsBySubCategory($subId, $limit, $offset);
            $data['totalCount']  = $this->Product_model->countBySubCategory($subId);
            $data['pageTitle']   = getSubCategoryName($subId);
        }
        $data['pageCount']         = ceil($data['totalCount'] / $limit);
        $data['currentPage']       = $pageNo;
        $data['baseUrl']           = base_url($pageSlug . '/' . $slug);
        $data['isActiveCategories'] = getAllCategory();
        $data['allBanners']        = $this->Home_model->getHomeBanners();
        $this->load->view('template/front/header', $data);
        $this->load->view('category/category_list', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function subcategory_list($slug) {
        $this->category_list($slug);
    }
}
