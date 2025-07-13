<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Pelanggan_model', 'Penggunaan_model', 'Tagihan_model', 'Tarif_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }
    }

    /**
     * Admin Dashboard
     */
    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['user'] = $this->session->userdata();
        
        // Statistik total
        $data['total_pelanggan'] = $this->Pelanggan_model->count_all();
        $data['total_penggunaan'] = $this->Penggunaan_model->count_all();
        $data['total_tagihan'] = $this->Tagihan_model->count_all();
        $data['total_tarif'] = $this->Tarif_model->count_all();
        
        // Data terbaru
        $data['recent_pelanggan'] = $this->Pelanggan_model->get_all();
        $data['recent_tagihan'] = $this->Tagihan_model->get_all();
        
        // Statistik tagihan bulanan untuk area chart
        $data['statistik_tagihan'] = $this->Tagihan_model->get_monthly_statistics(6);
        
        // Statistik status tagihan untuk pie chart
        $stats = $this->Tagihan_model->get_statistics();
        $data['status_tagihan'] = [
            'paid_bills' => (int)($stats->paid_bills ?? 0),
            'unpaid_bills' => (int)($stats->unpaid_bills ?? 0)
        ];

        $this->load->view('admin/dashboard', $data);
    }

    /**
     * Profile page
     */
    public function profile() {
        $data['title'] = 'Profil Admin';
        $data['user'] = $this->User_model->get_by_id($this->session->userdata('user_id'));
        
        // Get user level name
        if ($data['user']) {
            $data['user']->role = $this->User_model->get_level_name($data['user']->id_level);
        }
        
        // Get statistics for sidebar
        $data['total_pelanggan'] = $this->Pelanggan_model->count_all();
        $data['total_tagihan'] = $this->Tagihan_model->count_all();
        $data['tagihan_lunas'] = $this->Tagihan_model->count_by_status('sudah_bayar');
        $data['tagihan_belum_lunas'] = $this->Tagihan_model->count_by_status('belum_bayar');
        
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
                $user = $this->User_model->get_by_id($this->session->userdata('user_id'));
                
                if (!$this->User_model->verify_password($this->input->post('current_password'), $user->password)) {
                    $this->session->set_flashdata('error', 'Password saat ini salah');
                } else {
                    $data_update = array(
                        'password' => $this->User_model->hash_password($this->input->post('new_password'))
                    );
                    
                    if ($this->User_model->update($this->session->userdata('user_id'), $data_update)) {
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