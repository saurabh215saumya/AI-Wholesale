<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_model extends CI_Model {

    public function getActiveTiers() {
        return $this->db->where('status', 1)->order_by('sort_order', 'ASC')->get('tbl_wholesale_pricing')->result_array();
    }

    public function getAllTiers() {
        return $this->db->order_by('sort_order', 'ASC')->get('tbl_wholesale_pricing')->result_array();
    }

    public function getTierById($id) {
        return $this->db->where('id', $id)->get('tbl_wholesale_pricing')->row_array();
    }

    public function addTier($data) {
        $this->db->insert('tbl_wholesale_pricing', $data);
        return $this->db->insert_id();
    }

    public function updateTier($id, $data) {
        $this->db->where('id', $id)->update('tbl_wholesale_pricing', $data);
    }

    public function deleteTier($id) {
        $this->db->where('id', $id)->delete('tbl_wholesale_pricing');
    }
}
