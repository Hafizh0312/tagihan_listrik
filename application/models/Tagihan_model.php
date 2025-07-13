<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all bills
     */
    public function get_all() {
        $this->db->select('tagihan.*, penggunaan.id_pelanggan, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama_pelanggan, pelanggan.alamat, pelanggan.nomor_kwh,
                          tarif.daya, tarif.tarifperkwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->order_by('tagihan.bulan ASC, tagihan.tahun DESC');
        return $this->db->get()->result();
    }

    /**
     * Count all bills
     */
    public function count_all() {
        return $this->db->count_all('tagihan');
    }

    /**
     * Get bill statistics
     */
    public function get_statistics() {
        $this->db->select('COUNT(*) as total_bills,
                          SUM(CASE WHEN status = "sudah_bayar" THEN 1 ELSE 0 END) as paid_bills,
                          SUM(CASE WHEN status = "belum_bayar" THEN 1 ELSE 0 END) as unpaid_bills,
                          SUM(jumlah_meter) as total_kwh');
        $this->db->from('tagihan');
        return $this->db->get()->row();
    }

    /**
     * Get all bills (old method for compatibility)
     */
    public function get_all_tagihan() {
        return $this->get_all();
    }

    /**
     * Get bill by ID
     */
    public function get_tagihan_by_id($tagihan_id) {
        $this->db->select('tagihan.*, penggunaan.id_pelanggan, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama_pelanggan, pelanggan.alamat, pelanggan.nomor_kwh,
                          tarif.daya, tarif.tarifperkwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('tagihan.id_tagihan', $tagihan_id);
        return $this->db->get()->row();
    }

    /**
     * Get bills by customer ID
     */
    public function get_tagihan_by_pelanggan($pelanggan_id) {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, tarif.daya, tarif.tarifperkwh');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        $this->db->order_by('tagihan.bulan ASC, tagihan.tahun DESC');
        return $this->db->get()->result();
    }

    /**
     * Get bill by usage ID
     */
    public function get_tagihan_by_penggunaan($penggunaan_id) {
        $this->db->where('id_penggunaan', $penggunaan_id);
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
        $this->db->where('id_tagihan', $tagihan_id);
        return $this->db->update('tagihan', $data);
    }

    /**
     * Delete bill
     */
    public function delete_tagihan($tagihan_id) {
        $this->db->where('id_tagihan', $tagihan_id);
        return $this->db->delete('tagihan');
    }

    /**
     * Generate bill from usage
     */
    public function generate_tagihan($penggunaan_id) {
        // Get usage data
        $this->db->select('penggunaan.*, pelanggan.id_tarif, tarif.tarifperkwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('penggunaan.id_penggunaan', $penggunaan_id);
        $penggunaan = $this->db->get()->row();

        if (!$penggunaan) {
            return false;
        }

        // Calculate total KWH and bill amount
        $total_kwh = $penggunaan->meter_ahir - $penggunaan->meter_awal;
        $total_tagihan = $total_kwh * $penggunaan->tarifperkwh;

        // Check if bill already exists
        $existing_bill = $this->get_tagihan_by_penggunaan($penggunaan_id);
        if ($existing_bill) {
            // Update existing bill
            $data = array(
                'jumlah_meter' => $total_kwh,
                'bulan' => $penggunaan->bulan,
                'tahun' => $penggunaan->tahun
            );
            return $this->update_tagihan($existing_bill->id_tagihan, $data);
        } else {
            // Create new bill
            $data = array(
                'id_penggunaan' => $penggunaan_id,
                'id_pelanggan' => $penggunaan->id_pelanggan,
                'bulan' => $penggunaan->bulan,
                'tahun' => $penggunaan->tahun,
                'jumlah_meter' => $total_kwh,
                'status' => 'belum_bayar'
            );
            return $this->create_tagihan($data);
        }
    }

    /**
     * Update bill status
     */
    public function update_status($tagihan_id, $status) {
        $data = array('status' => $status);
        $this->db->where('id_tagihan', $tagihan_id);
        return $this->db->update('tagihan', $data);
    }

    /**
     * Get bills by status
     */
    public function get_tagihan_by_status($status) {
        $this->db->select('tagihan.*, penggunaan.id_pelanggan, penggunaan.bulan, penggunaan.tahun,
                          pelanggan.nama_pelanggan');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->where('tagihan.status', $status);
        $this->db->order_by('tagihan.bulan ASC, tagihan.tahun DESC');
        return $this->db->get()->result();
    }

    /**
     * Get unpaid bills
     */
    public function get_unpaid_bills() {
        return $this->get_tagihan_by_status('belum_bayar');
    }

    /**
     * Get paid bills
     */
    public function get_paid_bills() {
        return $this->get_tagihan_by_status('sudah_bayar');
    }

    /**
     * Count bills by status
     */
    public function count_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('tagihan');
    }

    /**
     * Get bill statistics (old method for compatibility)
     */
    public function get_bill_statistics($pelanggan_id = null) {
        $this->db->select('COUNT(*) as total_bills,
                          SUM(CASE WHEN status = "sudah_bayar" THEN 1 ELSE 0 END) as paid_bills,
                          SUM(CASE WHEN status = "belum_bayar" THEN 1 ELSE 0 END) as unpaid_bills,
                          SUM(jumlah_meter) as total_kwh');
        $this->db->from('tagihan');
        
        if ($pelanggan_id) {
            $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
            $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        }
        
        return $this->db->get()->row();
    }

    /**
     * Get bills by period
     */
    public function get_tagihan_by_period($bulan, $tahun, $pelanggan_id = null) {
        $this->db->select('tagihan.*, penggunaan.id_pelanggan, pelanggan.nama_pelanggan');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->where('tagihan.bulan', $bulan);
        $this->db->where('tagihan.tahun', $tahun);
        
        if ($pelanggan_id) {
            $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Get bill count
     */
    public function get_tagihan_count($pelanggan_id = null) {
        if ($pelanggan_id) {
            $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
            $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        }
        return $this->db->count_all('tagihan');
    }

    /**
     * Mark all bills as paid
     */
    public function mark_all_paid($pelanggan_id = null) {
        if ($pelanggan_id) {
            $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
            $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        }
        $this->db->where('status', 'belum_bayar');
        return $this->db->update('tagihan', ['status' => 'sudah_bayar']);
    }

    /**
     * Get bill statistics for customer
     */
    public function get_bill_statistics_for_customer($pelanggan_id) {
        $this->db->select('COUNT(*) as total_bills,
                          SUM(CASE WHEN status = "sudah_bayar" THEN 1 ELSE 0 END) as paid_bills,
                          SUM(CASE WHEN status = "belum_bayar" THEN 1 ELSE 0 END) as unpaid_bills,
                          SUM(jumlah_meter * tarif.tarifperkwh) as total_amount');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        return $this->db->get()->row();
    }

    /**
     * Get recent bills for customer
     */
    public function get_recent_bills_for_customer($pelanggan_id, $limit = 5) {
        $this->db->select('tagihan.*, penggunaan.bulan, penggunaan.tahun, 
                          (tagihan.jumlah_meter * tarif.tarifperkwh) as total_tagihan');
        $this->db->from('tagihan');
        $this->db->join('penggunaan', 'penggunaan.id_penggunaan = tagihan.id_penggunaan', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = penggunaan.id_pelanggan', 'left');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        $this->db->where('penggunaan.id_pelanggan', $pelanggan_id);
        $this->db->order_by('tagihan.bulan DESC, tagihan.tahun DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
} 