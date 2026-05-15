<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    protected $table = 'tbl_category';

    public function allCategories() {
        return $this->db->where('is_deleted', '0')->order_by('id', 'DESC')->get($this->table)->result_array();
    }

    public function categoryDetails($id) {
        return $this->db->where('id', $id)->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function changeStatus($id, $val) {
        return $this->db->where('id', $id)->update($this->table, array('status' => $val));
    }

    public function deleteRecord($id) {
        return $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
    }
}
