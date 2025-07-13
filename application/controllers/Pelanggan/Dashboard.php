<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Pelanggan_model', 'Penggunaan_model', 'Tagihan_model', 'User_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Fix: Use 'role' instead of 'level' for pelanggan session check
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'pelanggan') {
            redirect('auth');
        }
    }

    /**
     * Customer Dashboard
     */
    public function index() {
        $data['title'] = 'Dashboard Pelanggan';
        $data['user'] = $this->session->userdata();
        
        // Get customer data
        $data['pelanggan'] = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if ($data['pelanggan']) {
            // Get usage statistics
            $data['usage_stats'] = $this->Penggunaan_model->get_usage_statistics($data['pelanggan']->id_pelanggan);
            
            // Get bill statistics
            $data['bill_stats'] = $this->Tagihan_model->get_bill_statistics_for_customer($data['pelanggan']->id_pelanggan);
            
            // Get recent usage
            $data['recent_usage'] = $this->Penggunaan_model->get_by_pelanggan($data['pelanggan']->id_pelanggan);
            
            // Get recent bills
            $data['recent_bills'] = $this->Tagihan_model->get_recent_bills_for_customer($data['pelanggan']->id_pelanggan);
            
            // Get latest usage
            $data['latest_usage'] = $this->Penggunaan_model->get_latest_usage($data['pelanggan']->id_pelanggan);
        }
        
        $this->load->view('pelanggan/dashboard', $data);
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
} 