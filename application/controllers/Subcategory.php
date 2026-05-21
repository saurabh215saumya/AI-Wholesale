<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('category');
    }

    public function _remap($method, $params = array()) {
        redirect('category');
    }
}
