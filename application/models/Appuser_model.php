<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appuser_model extends CI_Model {

    protected $table = 'tbl_users';

    public function allUsers() {
        return $this->db->where('is_deleted', '0')->order_by('id', 'DESC')->get($this->table)->result_array();
    }

    public function userDetails($id) {
        return $this->db->where('id', $id)->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function getUserByEmail($email) {
        return $this->db->where('email', $email)->where('is_deleted', '0')->get($this->table)->row_array();
    }

    public function changeStatus($id, $val) {
        return $this->db->where('id', $id)->update($this->table, array('status' => $val));
    }

    public function deleteRecord($id) {
        return $this->db->where('id', $id)->update($this->table, array('is_deleted' => 1));
    }

    public function updateUser($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function getUserOrders($user_id) {
        return $this->db->where('user_id', $user_id)->order_by('id', 'DESC')->get('tbl_order')->result_array();
    }
}
