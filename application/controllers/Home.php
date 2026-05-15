<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->model('Product_model');
        $this->load->model('Testimonial_model');
        $this->load->model('Staticpage_model');
    }

    public function index() {
        $data['allBanners']        = $this->Home_model->getHomeBanners();
        $data['featuredProducts']   = $this->Product_model->getAllProducts(12, 0);
        $data['allTestimonials']    = $this->Testimonial_model->getActiveTestimonials();
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('template/front/home_banner', $data);
        $this->load->view('template/front/home_page_bar', $data);
        $this->load->view('template/front/home_banner_container');
        $this->load->view('home/index', $data);
        $this->load->view('template/front/product_explore_section');
        $this->load->view('template/front/customer_review_section', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function about_us() {
        $data['pageData']           = $this->Home_model->getPageData('about_us');
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('home/content_page', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function privacy_policy() {
        $data['pageData']           = $this->Home_model->getPageData('privacy_policy');
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('home/content_page', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function terms_conditions() {
        $data['pageData']           = $this->Home_model->getPageData('terms_and_condition');
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('home/content_page', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function contact_us() {
        $data['isActiveCategories'] = getAllCategory();
        if ($this->input->post()) {
            $this->Home_model->saveEnquiry(array(
                'name'    => $this->input->post('name'),
                'email'   => $this->input->post('email'),
                'phone'   => $this->input->post('phone'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'addedOn' => date('Y-m-d H:i:s'),
            ));
            $this->session->set_flashdata('success', 'Your message has been sent successfully.');
            redirect('contact-us');
        }
        $data['pageData'] = $this->Home_model->getPageData('contact_us');
        $this->load->view('template/front/header', $data);
        $this->load->view('home/contact_us', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function static_page($identifier) {
        $data['pageData']           = $this->Staticpage_model->getPageByIdentifier($identifier);
        $data['isActiveCategories'] = getAllCategory();
        $this->load->view('template/front/header', $data);
        $this->load->view('home/content_page', $data);
        $this->load->view('template/front/footer', $data);
    }
}
