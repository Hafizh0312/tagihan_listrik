<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggunaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Penggunaan_model', 'Pelanggan_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is customer
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'pelanggan') {
            redirect('auth');
        }
    }

    /**
     * List usage data for customer
     */
    public function index() {
        $data['title'] = 'Penggunaan Listrik';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan($pelanggan->pelanggan_id);
        $data['stats'] = $this->Penggunaan_model->get_usage_statistics($pelanggan->pelanggan_id);
        
        $this->load->view('pelanggan/penggunaan/index', $data);
    }

    /**
     * View usage detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('pelanggan/penggunaan');
        }
        
        $data['title'] = 'Detail Penggunaan Listrik';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/penggunaan');
        }
        
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_id($id);
        
        // Check if usage belongs to this customer
        if (!$data['penggunaan'] || $data['penggunaan']->pelanggan_id != $pelanggan->pelanggan_id) {
            $this->session->set_flashdata('error', 'Data penggunaan tidak ditemukan');
            redirect('pelanggan/penggunaan');
        }
        
        $this->load->view('pelanggan/penggunaan/view', $data);
    }

    /**
     * Usage statistics
     */
    public function statistics() {
        $data['title'] = 'Statistik Penggunaan Listrik';
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['stats'] = $this->Penggunaan_model->get_usage_statistics($pelanggan->pelanggan_id);
        
        // Get usage by year
        $current_year = date('Y');
        $data['usage_by_year'] = $this->Penggunaan_model->get_usage_by_year($current_year, $pelanggan->pelanggan_id);
        
        // Get usage by month for current year
        $data['monthly_usage'] = array();
        for ($month = 1; $month <= 12; $month++) {
            $monthly_data = $this->Penggunaan_model->get_penggunaan_by_period($pelanggan->pelanggan_id, $month, $current_year);
            $data['monthly_usage'][$month] = $monthly_data ? ($monthly_data->meter_akhir - $monthly_data->meter_awal) : 0;
        }
        
        $this->load->view('pelanggan/penggunaan/statistics', $data);
    }

    /**
     * Usage by year
     */
    public function by_year($year = null) {
        if (!$year) {
            $year = date('Y');
        }
        
        $data['title'] = 'Penggunaan Listrik Tahun ' . $year;
        
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/dashboard');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['year'] = $year;
        $data['usage_by_year'] = $this->Penggunaan_model->get_usage_by_year($year, $pelanggan->pelanggan_id);
        
        // Get available years
        $data['available_years'] = array();
        $current_year = date('Y');
        for ($y = $current_year; $y >= $current_year - 5; $y--) {
            $data['available_years'][] = $y;
        }
        
        $this->load->view('pelanggan/penggunaan/by_year', $data);
    }

    /**
     * Export usage data to PDF
     */
    public function export_pdf() {
        // Get customer data
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_user_id($this->session->userdata('user_id'));
        
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Data pelanggan tidak ditemukan');
            redirect('pelanggan/penggunaan');
        }
        
        $data['pelanggan'] = $pelanggan;
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan($pelanggan->pelanggan_id);
        $data['stats'] = $this->Penggunaan_model->get_usage_statistics($pelanggan->pelanggan_id);
        
        // Load PDF library
        $this->load->library('pdf');
        
        $html = $this->load->view('pelanggan/penggunaan/pdf', $data, true);
        
        $this->pdf->createPDF($html, 'laporan_penggunaan_' . $pelanggan->nama . '_' . date('Y-m-d'), true);
    }
} 