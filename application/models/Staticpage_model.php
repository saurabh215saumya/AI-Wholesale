<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staticpage_model extends CI_Model {

    protected $table = 'tbl_staticpages';

    public function allPages() {
        return $this->db->where('is_deleted', 0)->order_by('id', 'ASC')->get($this->table)->result_array();
    }

    public function pageDetails($id) {
        return $this->db->where('id', $id)->where('is_deleted', 0)->get($this->table)->row_array();
    }

    public function getPageByIdentifier($identifier) {
        return $this->db->where('identifire', $identifier)->where('is_deleted', 0)->get($this->table)->row_array();
    }

    public function deleteRecord($id) {
        return $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
    }
}
