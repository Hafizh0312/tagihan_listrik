<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Pelanggan_model', 'Penggunaan_model', 'Tagihan_model', 'Level_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * Admin Dashboard
     */
    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['user'] = $this->session->userdata();
        
        // Get statistics
        $data['total_pelanggan'] = $this->Pelanggan_model->get_pelanggan_count();
        $data['total_penggunaan'] = $this->Penggunaan_model->get_penggunaan_count();
        $data['total_tagihan'] = $this->Tagihan_model->get_tagihan_count();
        $data['total_level'] = $this->Level_model->get_level_count();
        
        // Get recent data
        $data['recent_pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['recent_penggunaan'] = $this->Penggunaan_model->get_all_penggunaan();
        $data['recent_tagihan'] = $this->Tagihan_model->get_all_tagihan();
        
        // Get bill statistics
        $data['bill_stats'] = $this->Tagihan_model->get_bill_statistics();
        
        // Get usage statistics
        $data['usage_stats'] = $this->Penggunaan_model->get_usage_statistics();
        
        $this->load->view('admin/dashboard', $data);
    }

    /**
     * Profile page
     */
    public function profile() {
        $data['title'] = 'Profil Admin';
        $data['user'] = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        
        $this->load->view('admin/profile', $data);
    }

    /**
     * Change password
     */
    public function change_password() {
        $data['title'] = 'Ganti Password';
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
            $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
                
                if (!$this->User_model->verify_password($this->input->post('current_password'), $user->password)) {
                    $this->session->set_flashdata('error', 'Password saat ini salah');
                } else {
                    $data_update = array(
                        'password' => $this->User_model->hash_password($this->input->post('new_password'))
                    );
                    
                    if ($this->User_model->update_user($this->session->userdata('user_id'), $data_update)) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password');
                    }
                }
            }
        }
        
        $this->load->view('admin/change_password', $data);
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
} 