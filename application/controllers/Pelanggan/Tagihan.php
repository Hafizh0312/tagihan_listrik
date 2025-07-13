<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Tagihan_model', 'Pelanggan_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is customer
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'pelanggan') {
            redirect('auth');
        }
    }

    /**
     * List bills for customer
     */
    public function index() {
        $data['title'] = 'Tagihan Listrik';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan($pelanggan->id_pelanggan);
        $data['stats'] = $this->Tagihan_model->get_bill_statistics($pelanggan->id_pelanggan);
        
        $this->load->view('pelanggan/tagihan/index', $data);
    }

    /**
     * View bill detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('pelanggan/tagihan');
        }
        
        $data['title'] = 'Detail Tagihan';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/tagihan');
        }
        
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_id($id);
        
        // Check if bill belongs to this customer
        if (!$data['tagihan'] || $data['tagihan']->pelanggan_id != $pelanggan->id_pelanggan) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('pelanggan/tagihan');
        }
        
        $this->load->view('pelanggan/tagihan/view', $data);
    }

    /**
     * Bills by status
     */
    public function by_status($status = null) {
        if (!$status || !in_array($status, ['Lunas', 'Belum Lunas'])) {
            redirect('pelanggan/tagihan');
        }
        
        $data['title'] = 'Tagihan ' . $status;
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['status'] = $status;
        
        // Get bills by status for this customer
        $all_bills = $this->Tagihan_model->get_tagihan_by_status($status);
        $data['tagihan'] = array();
        
        foreach ($all_bills as $bill) {
            if ($bill->pelanggan_id == $pelanggan->id_pelanggan) {
                $data['tagihan'][] = $bill;
            }
        }
        
        $this->load->view('pelanggan/tagihan/by_status', $data);
    }

    /**
     * Bills by period
     */
    public function by_period() {
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        $data['title'] = 'Tagihan per Periode';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        
        if (!$bulan || !$tahun) {
            $data['tagihan'] = array();
            $data['bulan'] = '';
            $data['tahun'] = '';
        } else {
            $data['title'] = 'Tagihan Periode ' . $bulan . '/' . $tahun;
            $all_bills = $this->Tagihan_model->get_tagihan_by_period($bulan, $tahun);
            $data['tagihan'] = array();
            
            foreach ($all_bills as $bill) {
                if ($bill->pelanggan_id == $pelanggan->id_pelanggan) {
                    $data['tagihan'][] = $bill;
                }
            }
            
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
        }
        
        $this->load->view('pelanggan/tagihan/by_period', $data);
    }

    /**
     * Bill statistics
     */
    public function statistics() {
        $data['title'] = 'Statistik Tagihan';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['stats'] = $this->Tagihan_model->get_bill_statistics($pelanggan->id_pelanggan);
        
        // Get unpaid bills for this customer
        $all_unpaid = $this->Tagihan_model->get_unpaid_bills();
        $data['unpaid_bills'] = array();
        
        foreach ($all_unpaid as $bill) {
            if ($bill->pelanggan_id == $pelanggan->id_pelanggan) {
                $data['unpaid_bills'][] = $bill;
            }
        }
        
        // Get paid bills for this customer
        $all_paid = $this->Tagihan_model->get_paid_bills();
        $data['paid_bills'] = array();
        
        foreach ($all_paid as $bill) {
            if ($bill->pelanggan_id == $pelanggan->id_pelanggan) {
                $data['paid_bills'][] = $bill;
            }
        }
        
        $this->load->view('pelanggan/tagihan/statistics', $data);
    }

    /**
     * Print bill
     */
    public function print_bill($id = null) {
        if (!$id) {
            redirect('pelanggan/tagihan');
        }
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/tagihan');
        }
        
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_id($id);
        
        // Check if bill belongs to this customer
        if (!$data['tagihan'] || $data['tagihan']->pelanggan_id != $pelanggan->id_pelanggan) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan');
            redirect('pelanggan/tagihan');
        }
        
        $this->load->view('pelanggan/tagihan/print', $data);
    }

    /**
     * Export bills to PDF
     */
    public function export_pdf() {
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/tagihan');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan($pelanggan->id_pelanggan);
        $data['stats'] = $this->Tagihan_model->get_bill_statistics($pelanggan->id_pelanggan);
        
        // Load PDF library
        $this->load->library('pdf');
        
        $html = $this->load->view('pelanggan/tagihan/pdf', $data, true);
        
        $this->pdf->createPDF($html, 'laporan_tagihan_' . $pelanggan->nama . '_' . date('Y-m-d'), true);
    }
} 