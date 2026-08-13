<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_banner_model extends CI_Model {

    private $table = 'tbl_promo_banners';

    public function getAll() {
        return $this->db->order_by('sort_order', 'ASC')->get($this->table)->result_array();
    }

    public function getActive() {
        return $this->db->where('status', 1)->order_by('sort_order', 'ASC')->get($this->table)->result_array();
    }

    public function getById($id) {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete($this->table);
    }

    public function changeStatus($id, $val) {
        $this->db->where('id', $id)->update($this->table, ['status' => $val]);
    }
}
