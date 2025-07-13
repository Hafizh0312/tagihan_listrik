<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Penggunaan_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Tarif_model');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Data Penggunaan Listrik';
        $data['penggunaan'] = $this->Penggunaan_model->get_all_with_details();
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['tarif'] = $this->Tarif_model->get_all();
        
        $this->load->view('admin/penggunaan/index', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_ahir' => $this->input->post('meter_ahir')
            );
            
            if ($this->Penggunaan_model->insert($data)) {
                $this->session->set_flashdata('success', 'Data penggunaan berhasil ditambahkan');
                redirect('admin/penggunaan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data penggunaan');
            }
        }
        
        $data['title'] = 'Tambah Data Penggunaan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['tarif'] = $this->Tarif_model->get_all();
        
        $this->load->view('admin/penggunaan/add', $data);
    }

    public function edit($id) {
        if ($this->input->post()) {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'bulan' => $this->input->post('bulan'),
                'tahun' => $this->input->post('tahun'),
                'meter_awal' => $this->input->post('meter_awal'),
                'meter_ahir' => $this->input->post('meter_ahir')
            );
            
            if ($this->Penggunaan_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Data penggunaan berhasil diperbarui');
                redirect('admin/penggunaan');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data penggunaan');
            }
        }
        
        $data['title'] = 'Edit Data Penggunaan';
        $data['penggunaan'] = $this->Penggunaan_model->get_by_id($id);
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['tarif'] = $this->Tarif_model->get_all();
        
        if (!$data['penggunaan']) {
            show_404();
        }
        
        $this->load->view('admin/penggunaan/edit', $data);
    }

    public function view($id) {
        $data['title'] = 'Detail Penggunaan';
        $data['penggunaan'] = $this->Penggunaan_model->get_by_id_with_details($id);
        
        if (!$data['penggunaan']) {
            show_404();
        }
        
        $this->load->view('admin/penggunaan/view', $data);
    }

    public function delete($id) {
        if ($this->Penggunaan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data penggunaan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data penggunaan');
        }
        redirect('admin/penggunaan');
    }

    public function search() {
        $keyword = $this->input->get('keyword');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        $data['title'] = 'Pencarian Data Penggunaan';
        $data['penggunaan'] = $this->Penggunaan_model->search($keyword, $bulan, $tahun);
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['tarif'] = $this->Tarif_model->get_all();
        $data['keyword'] = $keyword;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        
        $this->load->view('admin/penggunaan/search', $data);
    }

    public function statistics() {
        $data['title'] = 'Statistik Penggunaan';
        $data['total_penggunaan'] = $this->Penggunaan_model->count_all();
        $data['penggunaan_bulan_ini'] = $this->Penggunaan_model->count_by_month(date('m'), date('Y'));
        $data['total_kwh'] = $this->Penggunaan_model->sum_total_kwh();
        $data['rata_rata_kwh'] = $this->Penggunaan_model->average_kwh();
        $data['penggunaan_per_bulan'] = $this->Penggunaan_model->get_usage_by_month();
        
        $this->load->view('admin/penggunaan/statistics', $data);
    }
} 