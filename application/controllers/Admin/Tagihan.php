<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Tagihan_model', 'Penggunaan_model', 'Pelanggan_model']);
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('php82_compatibility_helper');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * List all bills
     */
    public function index() {
        $data['title'] = 'Kelola Tagihan Listrik';
        $data['tagihan'] = $this->Tagihan_model->get_all_tagihan();
        
        $this->load->view('admin/tagihan/index', $data);
    }

    /**
     * Generate bill from usage
     */
    public function generate($penggunaan_id = null) {
        if (!$penggunaan_id) {
            redirect('admin/tagihan');
        }
        
        $penggunaan = $this->Penggunaan_model->get_penggunaan_by_id($penggunaan_id);
        if (!$penggunaan) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        if ($this->Tagihan_model->generate_tagihan($penggunaan_id)) {
            $this->session->set_flashdata('success', 'Tagihan berhasil dibuat');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat tagihan');
        }
        
        redirect('admin/tagihan');
    }

    /**
     * Generate bills for all usage without bills
     */
    public function generate_all() {
        $penggunaan_list = $this->Penggunaan_model->get_all_penggunaan();
        $generated_count = 0;
        
        foreach ($penggunaan_list as $penggunaan) {
            $existing_bill = $this->Tagihan_model->get_tagihan_by_penggunaan($penggunaan->penggunaan_id);
            if (!$existing_bill) {
                if ($this->Tagihan_model->generate_tagihan($penggunaan->penggunaan_id)) {
                    $generated_count++;
                }
            }
        }
        
        if ($generated_count > 0) {
            $this->session->set_flashdata('success', $generated_count . ' tagihan berhasil dibuat');
        } else {
            $this->session->set_flashdata('info', 'Tidak ada tagihan baru yang perlu dibuat');
        }
        
        redirect('admin/tagihan');
    }

    /**
     * Update bill status
     */
    public function update_status($id = null) {
        if (!$id) {
            redirect('admin/tagihan');
        }
        
        $tagihan = $this->Tagihan_model->get_tagihan_by_id($id);
        if (!$tagihan) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        $status = $this->input->post('status');
        if ($status && in_array($status, ['Lunas', 'Belum Lunas'])) {
            if ($this->Tagihan_model->update_status($id, $status)) {
                $this->session->set_flashdata('success', 'Status tagihan berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate status tagihan');
            }
        } else {
            $this->session->set_flashdata('error', 'Status tidak valid');
        }
        
        redirect('admin/tagihan');
    }

    /**
     * View bill detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('admin/tagihan');
        }
        
        $data['title'] = 'Detail Tagihan';
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_id($id);
        
        if (!$data['tagihan']) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        $this->load->view('admin/tagihan/view', $data);
    }

    /**
     * Delete bill
     */
    public function delete($id = null) {
        if (!$id) {
            redirect('admin/tagihan');
        }
        
        $tagihan = $this->Tagihan_model->get_tagihan_by_id($id);
        if (!$tagihan) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        if ($this->Tagihan_model->delete_tagihan($id)) {
            $this->session->set_flashdata('success', 'Tagihan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tagihan');
        }
        
        redirect('admin/tagihan');
    }

    /**
     * Bills by status
     */
    public function by_status($status = null) {
        if (!$status || !in_array($status, ['Lunas', 'Belum Lunas'])) {
            redirect('admin/tagihan');
        }
        
        $data['title'] = 'Tagihan ' . $status;
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_status($status);
        $data['status'] = $status;
        
        $this->load->view('admin/tagihan/by_status', $data);
    }

    /**
     * Bills by customer
     */
    public function by_customer($pelanggan_id = null) {
        if (!$pelanggan_id) {
            redirect('admin/tagihan');
        }
        
        $data['title'] = 'Tagihan per Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($pelanggan_id);
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan($pelanggan_id);
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        $this->load->view('admin/tagihan/by_customer', $data);
    }

    /**
     * Bills by period
     */
    public function by_period() {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        if (!$bulan || !$tahun) {
            $data['title'] = 'Tagihan per Periode';
            $data['tagihan'] = [];
            $data['bulan'] = '';
            $data['tahun'] = '';
        } else {
            $data['title'] = 'Tagihan Periode ' . $bulan . '/' . $tahun;
            $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_period($bulan, $tahun);
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
        }
        
        $this->load->view('admin/tagihan/by_period', $data);
    }

    /**
     * Bill statistics
     */
    public function statistics() {
        $data['title'] = 'Statistik Tagihan';
        $data['stats'] = $this->Tagihan_model->get_bill_statistics();
        
        // Get unpaid bills
        $data['unpaid_bills'] = $this->Tagihan_model->get_unpaid_bills();
        
        // Get paid bills
        $data['paid_bills'] = $this->Tagihan_model->get_paid_bills();
        
        $this->load->view('admin/tagihan/statistics', $data);
    }

    /**
     * Print bill
     */
    public function print_bill($id = null) {
        if (!$id) {
            redirect('admin/tagihan');
        }
        
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_id($id);
        
        if (!$data['tagihan']) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('admin/tagihan');
        }
        
        $this->load->view('admin/tagihan/print', $data);
    }
} 