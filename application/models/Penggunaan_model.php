<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'penggunaan';
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('id_penggunaan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_with_details() {
        $this->db->select('p.*, pl.nama_pelanggan, pl.nomor_kwh, pl.alamat, t.daya, t.tarifperkwh');
        $this->db->from($this->table . ' p');
        $this->db->join('pelanggan pl', 'p.id_pelanggan = pl.id_pelanggan', 'left');
        $this->db->join('tarif t', 'pl.id_tarif = t.id_tarif', 'left');
        $this->db->order_by('p.id_penggunaan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_penggunaan', $id);
        return $this->db->get()->row();
    }

    public function get_by_id_with_details($id) {
        $this->db->select('p.*, pl.nama_pelanggan, pl.nomor_kwh, pl.alamat, t.daya, t.tarifperkwh');
        $this->db->from($this->table . ' p');
        $this->db->join('pelanggan pl', 'p.id_pelanggan = pl.id_pelanggan', 'left');
        $this->db->join('tarif t', 'pl.id_tarif = t.id_tarif', 'left');
        $this->db->where('p.id_penggunaan', $id);
        return $this->db->get()->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where('id_penggunaan', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id_penggunaan', $id);
        return $this->db->delete($this->table);
    }

    public function search($keyword = '', $bulan = '', $tahun = '') {
        $this->db->select('p.*, pl.nama_pelanggan, pl.nomor_kwh, pl.alamat, t.daya, t.tarifperkwh');
        $this->db->from($this->table . ' p');
        $this->db->join('pelanggan pl', 'p.id_pelanggan = pl.id_pelanggan', 'left');
        $this->db->join('tarif t', 'pl.id_tarif = t.id_tarif', 'left');
        
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('pl.nama_pelanggan', $keyword);
            $this->db->or_like('pl.nomor_kwh', $keyword);
            $this->db->group_end();
        }
        
        if ($bulan) {
            $this->db->where('p.bulan', $bulan);
        }
        
        if ($tahun) {
            $this->db->where('p.tahun', $tahun);
        }
        
        $this->db->order_by('p.id_penggunaan', 'DESC');
        return $this->db->get()->result();
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_by_month($bulan, $tahun) {
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->count_all_results($this->table);
    }

    public function sum_total_kwh() {
        $this->db->select('SUM(meter_ahir - meter_awal) as total_kwh');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result ? $result->total_kwh : 0;
    }

    public function average_kwh() {
        $this->db->select('AVG(meter_ahir - meter_awal) as avg_kwh');
        $this->db->from($this->table);
        $result = $this->db->get()->row();
        return $result ? $result->avg_kwh : 0;
    }

    public function get_usage_by_month() {
        $this->db->select('bulan, tahun, COUNT(*) as jumlah_data, SUM(meter_ahir - meter_awal) as total_kwh, AVG(meter_ahir - meter_awal) as rata_rata_kwh');
        $this->db->from($this->table);
        $this->db->group_by('bulan, tahun');
        $this->db->order_by('tahun DESC, bulan DESC');
        return $this->db->get()->result();
    }

    public function get_usage_by_month_with_payment() {
        $this->db->select('p.bulan, p.tahun, COUNT(*) as jumlah_data, SUM(p.meter_ahir - p.meter_awal) as total_kwh, AVG(p.meter_ahir - p.meter_awal) as rata_rata_kwh, SUM((p.meter_ahir - p.meter_awal) * t.tarifperkwh) as total_bayar, AVG((p.meter_ahir - p.meter_awal) * t.tarifperkwh) as rata_rata_bayar');
        $this->db->from($this->table . ' p');
        $this->db->join('pelanggan pl', 'p.id_pelanggan = pl.id_pelanggan', 'left');
        $this->db->join('tarif t', 'pl.id_tarif = t.id_tarif', 'left');
        $this->db->group_by('p.bulan, p.tahun');
        $this->db->order_by('p.tahun DESC, p.bulan DESC');
        return $this->db->get()->result();
    }

    public function get_by_pelanggan($id_pelanggan) {
        $this->db->select('p.*, pl.nama_pelanggan, pl.nomor_kwh, t.tarifperkwh');
        $this->db->from($this->table . ' p');
        $this->db->join('pelanggan pl', 'p.id_pelanggan = pl.id_pelanggan', 'left');
        $this->db->join('tarif t', 'pl.id_tarif = t.id_tarif', 'left');
        $this->db->where('p.id_pelanggan', $id_pelanggan);
        $this->db->order_by('p.tahun DESC, p.bulan DESC');
        return $this->db->get()->result();
    }

    public function check_duplicate($id_pelanggan, $bulan, $tahun, $exclude_id = null) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        
        if ($exclude_id) {
            $this->db->where('id_penggunaan !=', $exclude_id);
        }
        
        return $this->db->count_all_results($this->table) > 0;
    }

    public function get_latest_meter($id_pelanggan) {
        $this->db->select('meter_ahir');
        $this->db->from($this->table);
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tahun DESC, bulan DESC');
        $this->db->limit(1);
        $result = $this->db->get()->row();
        return $result ? $result->meter_ahir : 0;
    }

    public function get_statistics() {
        $stats = array();
        
        // Total usage
        $stats['total_usage'] = $this->count_all();
        
        // Usage this month
        $stats['this_month'] = $this->count_by_month(date('n'), date('Y'));
        
        // Total KWH
        $stats['total_kwh'] = $this->sum_total_kwh();
        
        // Average KWH
        $stats['avg_kwh'] = $this->average_kwh();
        
        // Usage by month
        $stats['by_month'] = $this->get_usage_by_month_with_payment();
        
        return $stats;
    }

    public function get_usage_statistics($id_pelanggan) {
        $this->db->select('SUM(meter_ahir - meter_awal) as total_usage');
        $this->db->from($this->table);
        $this->db->where('id_pelanggan', $id_pelanggan);
        $result = $this->db->get()->row();
        return $result;
    }

    public function get_latest_usage($id_pelanggan) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tahun DESC, bulan DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
} 