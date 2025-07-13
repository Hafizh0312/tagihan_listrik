<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all customers
     */
    public function get_all() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        return $this->db->get()->result();
    }

    /**
     * Get customer by ID
     */
    public function get_by_id($pelanggan_id) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.id_pelanggan', $pelanggan_id);
        return $this->db->get()->row();
    }

    /**
     * Get customer by username
     */
    public function get_pelanggan_by_username($username) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.username', $username);
        return $this->db->get()->row();
    }

    /**
     * Create new customer
     */
    public function insert($data) {
        return $this->db->insert('pelanggan', $data);
    }

    /**
     * Update customer
     */
    public function update($pelanggan_id, $data) {
        $this->db->where('id_pelanggan', $pelanggan_id);
        return $this->db->update('pelanggan', $data);
    }

    /**
     * Delete customer
     */
    public function delete($pelanggan_id) {
        // Start transaction
        $this->db->trans_start();
        
        // Delete related tagihan first
        $this->db->select('id_penggunaan');
        $this->db->from('penggunaan');
        $this->db->where('id_pelanggan', $pelanggan_id);
        $penggunaan_list = $this->db->get()->result();
        
        if (!empty($penggunaan_list)) {
            $penggunaan_ids = array_column($penggunaan_list, 'id_penggunaan');
            
            // Delete tagihan related to these penggunaan
            if (!empty($penggunaan_ids)) {
                $this->db->where_in('id_penggunaan', $penggunaan_ids);
                $this->db->delete('tagihan');
            }
            
            // Delete penggunaan records
            $this->db->where('id_pelanggan', $pelanggan_id);
            $this->db->delete('penggunaan');
        }
        
        // Finally delete the pelanggan
        $this->db->where('id_pelanggan', $pelanggan_id);
        $result = $this->db->delete('pelanggan');
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $result && $this->db->trans_status();
    }

    /**
     * Get customers with usage data
     */
    public function get_pelanggan_with_usage($pelanggan_id = null) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh, 
                          COUNT(penggunaan.id_penggunaan) as total_penggunaan');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->join('penggunaan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left');
        
        if ($pelanggan_id) {
            $this->db->where('pelanggan.id_pelanggan', $pelanggan_id);
        }
        
        $this->db->group_by('pelanggan.id_pelanggan');
        return $this->db->get()->result();
    }

    /**
     * Get usage data for customer
     */
    public function get_penggunaan_by_pelanggan($pelanggan_id) {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, tarif.daya, tarif.tarifperkwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan ASC');
        return $this->db->get()->result();
    }

    /**
     * Search customers
     */
    public function search($keyword) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->like('pelanggan.nama_pelanggan', $keyword);
        $this->db->or_like('pelanggan.alamat', $keyword);
        $this->db->or_like('pelanggan.username', $keyword);
        $this->db->or_like('pelanggan.nomor_kwh', $keyword);
        return $this->db->get()->result();
    }

    /**
     * Get customer count
     */
    public function count_all() {
        return $this->db->count_all('pelanggan');
    }

    /**
     * Get customers by tarif
     */
    public function get_pelanggan_by_tarif($id_tarif) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.id_tarif', $id_tarif);
        return $this->db->get()->result();
    }

    /**
     * Set id_tarif to NULL for all customers using a specific tarif
     */
    public function set_tarif_null($id_tarif) {
        $this->db->where('id_tarif', $id_tarif);
        return $this->db->update('pelanggan', ['id_tarif' => null]);
    }

    /**
     * Check if nomor_kwh exists
     */
    public function nomor_kwh_exists($nomor_kwh, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        $this->db->where('nomor_kwh', $nomor_kwh);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Set id_tarif to NULL for all customers using a specific tarif
     */
    public function set_level_null($id_tarif) {
        $this->db->where('id_tarif', $id_tarif);
        return $this->db->update('pelanggan', ['id_tarif' => null]);
    }

    /**
     * Get customers by tarif level
     */
    public function get_pelanggan_by_level($id_tarif) {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('pelanggan.id_tarif', $id_tarif);
        return $this->db->get()->result();
    }
} 