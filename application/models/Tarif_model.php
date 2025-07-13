<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'tarif';
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('daya', 'ASC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function get_by_daya($daya) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('daya', $daya);
        return $this->db->get()->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function get_active_tarif() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('daya', 'ASC');
        return $this->db->get()->result();
    }
} 