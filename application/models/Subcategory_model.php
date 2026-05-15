<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategory_model extends CI_Model {

    protected $table = 'tbl_sub_category';

    public function allSubcategories() {
        return $this->db->select('tbl_sub_category.*, tbl_category.category_name')
            ->from($this->table)
            ->join('tbl_category', 'tbl_category.id = tbl_sub_category.category_id', 'left')
            ->where('tbl_sub_category.is_deleted', '0')
            ->order_by('tbl_sub_category.id', 'DESC')
            ->get()->result_array();
    }

    public function subcategoryDetails($id) {
        return $this->db->where('id', $id)->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function changeStatus($id, $val) {
        return $this->db->where('id', $id)->update($this->table, array('status' => $val));
    }

    public function deleteRecord($id) {
        return $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
    }
}
