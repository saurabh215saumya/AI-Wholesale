<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function getAdminByUsername($username) {
        return $this->db->where('username', $username)->where('is_deleted', 0)->get('tbl_admin')->row_array();
    }

    public function getAdminById($id) {
        return $this->db->where('id', $id)->get('tbl_admin')->row_array();
    }

    public function updateAdmin($id, $data) {
        return $this->db->where('id', $id)->update('tbl_admin', $data);
    }

    public function getDashboardCounts() {
        return array(
            'total_products'    => $this->db->where('is_deleted', 0)->count_all_results('tbl_products'),
            'total_categories'  => $this->db->where('is_deleted', 0)->count_all_results('tbl_category'),
            'total_users'       => $this->db->where('is_deleted', '0')->count_all_results('tbl_users'),
            'total_orders'      => $this->db->count_all_results('tbl_order'),
        );
    }
}
