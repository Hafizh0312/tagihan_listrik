<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Penggunaan_model', 'Pelanggan_model', 'Tagihan_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * List all usage data
     */
    public function index() {
        $data['title'] = 'Kelola Penggunaan Listrik';
        $data['penggunaan'] = $this->Penggunaan_model->get_all_penggunaan();
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        
        $this->load->view('admin/penggunaan/index', $data);
    }

    /**
     * Add new usage data
     */
    public function add() {
        $data['title'] = 'Tambah Penggunaan Listrik';
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
            $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|callback__cek_meter_akhir');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                // Check if usage already exists for this period
                if ($this->Penggunaan_model->usage_exists(
                    $this->input->post('pelanggan_id'),
                    $this->input->post('bulan'),
                    $this->input->post('tahun')
                )) {
                    $this->session->set_flashdata('error', 'Data penggunaan untuk periode ini sudah ada');
                } else {
                    $data_insert = array(
                        'pelanggan_id' => $this->input->post('pelanggan_id'),
                        'bulan' => $this->input->post('bulan'),
                        'tahun' => $this->input->post('tahun'),
                        'meter_awal' => $this->input->post('meter_awal'),
                        'meter_akhir' => $this->input->post('meter_akhir')
                    );
                    
                    if ($this->Penggunaan_model->create_penggunaan($data_insert)) {
                        // Auto generate bill
                        $penggunaan_id = $this->db->insert_id();
                        $this->Tagihan_model->generate_tagihan($penggunaan_id);
                        
                        $this->session->set_flashdata('success', 'Penggunaan berhasil ditambahkan dan tagihan dibuat otomatis');
                        redirect('admin/penggunaan');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menambahkan penggunaan');
                    }
                }
            }
        }
        
        $this->load->view('admin/penggunaan/add', $data);
    }

    /**
     * Edit usage data
     */
    public function edit($id = null) {
        if (!$id) {
            redirect('admin/penggunaan');
        }
        
        $data['title'] = 'Edit Penggunaan Listrik';
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_id($id);
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        
        if (!$data['penggunaan']) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan');
            redirect('admin/penggunaan');
        }
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required');
            $this->form_validation->set_rules('bulan', 'Bulan', 'required|numeric|greater_than[0]|less_than[13]');
            $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|greater_than[2000]');
            $this->form_validation->set_rules('meter_awal', 'Meter Awal', 'required|numeric|greater_than_equal_to[0]');
            $this->form_validation->set_rules('meter_akhir', 'Meter Akhir', 'required|numeric|greater_than[meter_awal]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                // Check if usage already exists for this period (excluding current record)
                if ($this->Penggunaan_model->usage_exists(
                    $this->input->post('pelanggan_id'),
                    $this->input->post('bulan'),
                    $this->input->post('tahun'),
                    $id
                )) {
                    $this->session->set_flashdata('error', 'Data penggunaan untuk periode ini sudah ada');
                } else {
                    $data_update = array(
                        'pelanggan_id' => $this->input->post('pelanggan_id'),
                        'bulan' => $this->input->post('bulan'),
                        'tahun' => $this->input->post('tahun'),
                        'meter_awal' => $this->input->post('meter_awal'),
                        'meter_akhir' => $this->input->post('meter_akhir')
                    );
                    
                    if ($this->Penggunaan_model->update_penggunaan($id, $data_update)) {
                        // Update related bill
                        $tagihan = $this->Tagihan_model->get_tagihan_by_penggunaan($id);
                        if ($tagihan) {
                            $this->Tagihan_model->generate_tagihan($id);
                        }
                        
                        $this->session->set_flashdata('success', 'Penggunaan berhasil diupdate');
                        redirect('admin/penggunaan');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengupdate penggunaan');
                    }
                }
            }
        }
        
        $this->load->view('admin/penggunaan/edit', $data);
    }

    /**
     * Delete usage data
     */
    public function delete($id = null) {
        if (!$id) {
            redirect('admin/penggunaan');
        }
        
        $penggunaan = $this->Penggunaan_model->get_penggunaan_by_id($id);
        if (!$penggunaan) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan');
            redirect('admin/penggunaan');
        }
        
        // Check if bill exists
        $tagihan = $this->Tagihan_model->get_tagihan_by_penggunaan($id);
        if ($tagihan) {
            $this->Tagihan_model->delete_tagihan($tagihan->tagihan_id);
        }
        
        if ($this->Penggunaan_model->delete_penggunaan($id)) {
            $this->session->set_flashdata('success', 'Penggunaan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus penggunaan');
        }
        
        redirect('admin/penggunaan');
    }

    /**
     * View usage detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('admin/penggunaan');
        }
        
        $data['title'] = 'Detail Penggunaan Listrik';
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_id($id);
        
        if (!$data['penggunaan']) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan');
            redirect('admin/penggunaan');
        }
        
        // Get related bill
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_penggunaan($id);
        
        $this->load->view('admin/penggunaan/view', $data);
    }

    /**
     * Usage statistics
     */
    public function statistics() {
        $data['title'] = 'Statistik Penggunaan Listrik';
        $data['stats'] = $this->Penggunaan_model->get_usage_statistics();
        
        // Get usage by year
        $current_year = date('Y');
        $data['usage_by_year'] = $this->Penggunaan_model->get_usage_by_year($current_year);
        
        $this->load->view('admin/penggunaan/statistics', $data);
    }

    /**
     * Usage by customer
     */
    public function by_customer($pelanggan_id = null) {
        if (!$pelanggan_id) {
            redirect('admin/penggunaan');
        }
        
        $data['title'] = 'Penggunaan per Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($pelanggan_id);
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan($pelanggan_id);
        $data['stats'] = $this->Penggunaan_model->get_usage_statistics($pelanggan_id);
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/penggunaan');
        }
        
        $this->load->view('admin/penggunaan/by_customer', $data);
    }

    /**
     * Callback untuk validasi Meter Akhir > Meter Awal
     */
    public function _cek_meter_akhir($meter_akhir) {
        $meter_awal = $this->input->post('meter_awal');
        if ($meter_akhir > $meter_awal) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_cek_meter_akhir', 'Meter Akhir harus lebih besar dari Meter Awal.');
            return FALSE;
        }
    }
} 