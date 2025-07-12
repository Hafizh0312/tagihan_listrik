<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all bills
     */
    public function get_all_tagihan() {
        $this->db->select('tagihan.*, penggunaan.pelanggan_id, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama as nama_pelanggan, pelanggan.alamat,
                          level.daya, level.tarif_per_kwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->order_by('tagihan.created_at DESC');
        return $this->db->get()->result();
    }

    /**
     * Get bill by ID
     */
    public function get_tagihan_by_id($tagihan_id) {
        $this->db->select('tagihan.*, penggunaan.pelanggan_id, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama as nama_pelanggan, pelanggan.alamat,
                          level.daya, level.tarif_per_kwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('tagihan.tagihan_id', $tagihan_id);
        return $this->db->get()->row();
    }

    /**
     * Get bills by customer ID
     */
    public function get_tagihan_by_pelanggan($pelanggan_id) {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, level.daya, level.tarif_per_kwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        $this->db->order_by('tagihan.created_at DESC');
        return $this->db->get()->result();
    }

    /**
     * Get bill by usage ID
     */
    public function get_tagihan_by_penggunaan($penggunaan_id) {
        $this->db->where('penggunaan_id', $penggunaan_id);
        return $this->db->get('tagihan')->row();
    }

    /**
     * Create new bill
     */
    public function create_tagihan($data) {
        return $this->db->insert('tagihan', $data);
    }

    /**
     * Update bill
     */
    public function update_tagihan($tagihan_id, $data) {
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->update('tagihan', $data);
    }

    /**
     * Delete bill
     */
    public function delete_tagihan($tagihan_id) {
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->delete('tagihan');
    }

    /**
     * Generate bill from usage
     */
    public function generate_tagihan($penggunaan_id) {
        // Get usage data
        $this->db->select('penggunaan.*, pelanggan.level_id, level.tarif_per_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->join('level', 'level.level_id = pelanggan.level_id', 'left');
        $this->db->where('penggunaan.penggunaan_id', $penggunaan_id);
        $penggunaan = $this->db->get()->row();

        if (!$penggunaan) {
            return false;
        }

        // Calculate total KWH and bill amount
        $total_kwh = $penggunaan->meter_akhir - $penggunaan->meter_awal;
        $total_tagihan = $total_kwh * $penggunaan->tarif_per_kwh;

        // Check if bill already exists
        $existing_bill = $this->get_tagihan_by_penggunaan($penggunaan_id);
        if ($existing_bill) {
            // Update existing bill
            $data = array(
                'total_kwh' => $total_kwh,
                'total_tagihan' => $total_tagihan
            );
            return $this->update_tagihan($existing_bill->tagihan_id, $data);
        } else {
            // Create new bill
            $data = array(
                'penggunaan_id' => $penggunaan_id,
                'total_kwh' => $total_kwh,
                'total_tagihan' => $total_tagihan,
                'status' => 'Belum Lunas'
            );
            return $this->create_tagihan($data);
        }
    }

    /**
     * Update bill status
     */
    public function update_status($tagihan_id, $status) {
        $data = array('status' => $status);
        $this->db->where('tagihan_id', $tagihan_id);
        return $this->db->update('tagihan', $data);
    }

    /**
     * Get bills by status
     */
    public function get_tagihan_by_status($status) {
        $this->db->select('tagihan.*, penggunaan.pelanggan_id, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama as nama_pelanggan');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->where('tagihan.status', $status);
        $this->db->order_by('tagihan.created_at DESC');
        return $this->db->get()->result();
    }

    /**
     * Get unpaid bills
     */
    public function get_unpaid_bills() {
        return $this->get_tagihan_by_status('Belum Lunas');
    }

    /**
     * Get paid bills
     */
    public function get_paid_bills() {
        return $this->get_tagihan_by_status('Lunas');
    }

    /**
     * Get bill statistics
     */
    public function get_bill_statistics($pelanggan_id = null) {
        $this->db->select('COUNT(*) as total_bills,
                          SUM(CASE WHEN status = "Lunas" THEN 1 ELSE 0 END) as paid_bills,
                          SUM(CASE WHEN status = "Belum Lunas" THEN 1 ELSE 0 END) as unpaid_bills,
                          SUM(total_tagihan) as total_amount,
                          SUM(CASE WHEN status = "Lunas" THEN total_tagihan ELSE 0 END) as paid_amount,
                          SUM(CASE WHEN status = "Belum Lunas" THEN total_tagihan ELSE 0 END) as unpaid_amount');
        $this->db->from('tagihan');
        
        if ($pelanggan_id) {
            $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
            $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        }
        
        return $this->db->get()->row();
    }

    /**
     * Get bills by period
     */
    public function get_tagihan_by_period($bulan, $tahun, $pelanggan_id = null) {
        $this->db->select('tagihan.*, penggunaan.pelanggan_id, pelanggan.nama as nama_pelanggan');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
        $this->db->join('pelanggan', 'pelanggan.pelanggan_id = penggunaan.pelanggan_id', 'left');
        $this->db->where('penggunaan.bulan', $bulan);
        $this->db->where('penggunaan.tahun', $tahun);
        
        if ($pelanggan_id) {
            $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Get bill count
     */
    public function get_tagihan_count($pelanggan_id = null) {
        if ($pelanggan_id) {
            $this->db->join('penggunaan', 'penggunaan.penggunaan_id = tagihan.penggunaan_id', 'left');
            $this->db->where('penggunaan.pelanggan_id', $pelanggan_id);
        }
        return $this->db->count_all('tagihan');
    }
} 