<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all usage data
     */
    public function get_all_penggunaan() {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, 
                          level.daya, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->order_by('penggunaan.tahun DESC, penggunaan.bulan DESC');
        return $this->db->get()->result();
    }

    /**
     * Get usage by ID
     */
    public function get_penggunaan_by_id($penggunaan_id) {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, 
                          level.daya, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('penggunaan.penggunaan_id', $penggunaan_id);
        return $this->db->get()->row();
    }

    /**
     * Get usage by customer ID
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
     * Get usage by customer and period
     */
    public function get_penggunaan_by_period($pelanggan_id, $bulan, $tahun) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get('penggunaan')->row();
    }

    /**
     * Create new usage
     */
    public function create_penggunaan($data) {
        return $this->db->insert('penggunaan', $data);
    }

    /**
     * Update usage
     */
    public function update_penggunaan($penggunaan_id, $data) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->update('penggunaan', $data);
    }

    /**
     * Delete usage
     */
    public function delete_penggunaan($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->delete('penggunaan');
    }

    /**
     * Check if usage exists for period
     */
    public function usage_exists($pelanggan_id, $bulan, $tahun, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('penggunaan_id !=', $exclude_id);
        }
        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get('penggunaan')->num_rows() > 0;
    }

    /**
     * Get usage statistics
     */
    public function get_usage_statistics($pelanggan_id = null) {
        $this->db->select('SUM(meter_akhir - meter_awal) as total_kwh, 
                          COUNT(*) as total_periods,
                          AVG(meter_akhir - meter_awal) as avg_kwh_per_month');
        $this->db->from('penggunaan');
        
        if ($pelanggan_id) {
            $this->db->where('pelanggan_id', $pelanggan_id);
        }
        
        return $this->db->get()->row();
    }

    /**
     * Get usage by year
     */
    public function get_usage_by_year($tahun, $pelanggan_id = null) {
        $this->db->select('penggunaan.*, pelanggan.nama as nama_pelanggan');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->where('penggunaan.tahun', $tahun);
        
        if ($pelanggan_id) {
            $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        }
        
        $this->db->order_by('penggunaan.bulan ASC');
        return $this->db->get()->result();
    }

    /**
     * Get latest usage for customer
     */
    public function get_latest_usage($pelanggan_id) {
        $this->db->where('pelanggan_id', $pelanggan_id);
        $this->db->order_by('tahun DESC, bulan DESC');
        $this->db->limit(1);
        return $this->db->get('penggunaan')->row();
    }

    /**
     * Calculate total KWH
     */
    public function calculate_total_kwh($meter_awal, $meter_akhir) {
        return $meter_akhir - $meter_awal;
    }

    /**
     * Get usage count
     */
    public function get_penggunaan_count($pelanggan_id = null) {
        if ($pelanggan_id) {
            $this->db->where('pelanggan_id', $pelanggan_id);
        }
        return $this->db->count_all('penggunaan');
    }
} 