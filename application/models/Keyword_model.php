<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keyword_model extends CI_Model {

    protected $table = 'tbl_keywords';

    public function all() {
        return $this->db->where('is_deleted', 0)->order_by('id', 'DESC')->get($this->table)->result_array();
    }

    public function find($id) {
        return $this->db->where('id', $id)->where('is_deleted', 0)->get($this->table)->row_array();
    }
}
