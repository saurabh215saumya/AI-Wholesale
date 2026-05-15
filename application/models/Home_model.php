<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function getPageData($identifier) {
        return $this->db->where('identifire', $identifier)->where('is_deleted', 0)->get('tbl_staticpages')->row_array();
    }

    public function getHomeBanners() {
        return $this->db->where('is_deleted', '0')->where('status', '1')->order_by('id', 'ASC')->get('tbl_banners')->result_array();
    }

    public function saveEnquiry($data) {
        return $this->db->insert('tbl_enquiry', $data);
    }
}
