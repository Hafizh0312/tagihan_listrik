<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all customers
     */
    public function get_all_pelanggan() {
        $this->db->select('pelanggan.*, users.username, users.nama as nama_user, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        return $this->db->get()->result();
    }

    /**
     * Get customer by ID
     */
    public function get_pelanggan_by_id($pelanggan_id) {
        $this->db->select('pelanggan.*, users.username, users.nama as nama_user, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('pelanggan.pelanggan_id', $pelanggan_id);
        return $this->db->get()->row();
    }

    /**
     * Get customer by user ID
     */
    public function get_pelanggan_by_user_id($user_id) {
        $this->db->select('pelanggan.*, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('pelanggan.user_id', $user_id);
        return $this->db->get()->row();
    }

    /**
     * Create new customer
     */
    public function create_pelanggan($data) {
        return $this->db->insert('pelanggan', $data);
    }

    /**
     * Update customer
     */
    public function update_pelanggan($pelanggan_id, $data) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        return $this->db->update('pelanggan', $data);
    }

    /**
     * Delete customer
     */
    public function delete_pelanggan($pelanggan_id) {
        // Start transaction
        $this->db->trans_start();
        
        // Delete related tagihan first
        $this->db->select('penggunaan_id');
        $this->db->from('penggunaan');
        $this->db->where('pelanggan_id', $pelanggan_id);
        $penggunaan_list = $this->db->get()->result();
        
        if (!empty($penggunaan_list)) {
            $penggunaan_ids = array_column($penggunaan_list, 'penggunaan_id');
            
            // Delete tagihan related to these penggunaan
            if (!empty($penggunaan_ids)) {
                $this->db->where_in('penggunaan_id', $penggunaan_ids);
                $this->db->delete('tagihan');
            }
            
            // Delete penggunaan records
            $this->db->where('pelanggan_id', $pelanggan_id);
            $this->db->delete('penggunaan');
        }
        
        // Finally delete the pelanggan
        $this->db->where('pelanggan_id', $pelanggan_id);
        $result = $this->db->delete('pelanggan');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $result && $this->db->trans_status();
    }

    /**
     * Get customers with usage data
     */
    public function get_pelanggan_with_usage($pelanggan_id = null) {
        $this->db->select('pelanggan.*, users.username, level.daya, level.tarif_per_kwh, 
                          COUNT(penggunaan.penggunaan_id) as total_penggunaan');
        $this->db->from('pelanggan');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->join('penggunaan', 'penggunaan.pelanggan_id = pelanggan.pelanggan_id', 'left');
        
        if ($pelanggan_id) {
            $this->db->where('pelanggan.pelanggan_id', $pelanggan_id);
        }
        
        $this->db->group_by('pelanggan.pelanggan_id');
        return $this->db->get()->result();
    }

    /**
     * Get usage data for customer
     */
    public function get_penggunaan_by_pelanggan($pelanggan_id) {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, level.daya, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan DESC');
        return $this->db->get()->result();
    }

    /**
     * Search customers
     */
    public function search_pelanggan($keyword) {
        $this->db->select('pelanggan.*, users.username, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->like('pelanggan.nama', $keyword);
        $this->db->or_like('pelanggan.alamat', $keyword);
        $this->db->or_like('users.username', $keyword);
        return $this->db->get()->result();
    }

    /**
     * Get customer count
     */
    public function get_pelanggan_count() {
        return $this->db->count_all('pelanggan');
    }

    /**
     * Get customers by level
     */
    public function get_pelanggan_by_level($level_id) {
        $this->db->select('pelanggan.*, users.username, level.daya, level.tarif_per_kwh');
        $this->db->from('pelanggan');
        $this->db->join('users', 'users.user_id = pelanggan.user_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('pelanggan.level_id', $level_id);
        return $this->db->get()->result();
    }

    /**
     * Set level_id to NULL for all customers using a specific level
     */
    public function set_level_null($level_id) {
        $this->db->where('level_id', $level_id);
        return $this->db->update('pelanggan', ['level_id' => null]);
    }
} 