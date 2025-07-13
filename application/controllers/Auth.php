<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    /**
     * Login page
     */
    public function index() {
        // Check if user is already logged in
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') == 'admin') {
                redirect('admin/dashboard');
            } else {
                redirect('pelanggan/dashboard');
            }
        }

        $this->load->view('auth/login');
    }

    /**
     * Login process
     */
    public function login() {
        // Load form validation library
        $this->load->library('form_validation');
        
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, show login page with errors
            $this->load->view('auth/login');
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // First check if it's an admin/petugas user
        $user = $this->User_model->get_by_username($username);
        
        if ($user && $this->User_model->verify_password($password, $user->password)) {
            // Admin/Petugas login
            $level_name = $this->User_model->get_level_name($user->id_level);
            
            $session_data = array(
                'user_id' => $user->id_user,
                'username' => $user->username,
                'nama' => $user->nama_admin,
                'role' => 'admin',
                'level_id' => $user->id_level,
                'level_name' => $level_name,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($session_data);
            redirect('admin/dashboard');
        } else {
            // Check if it's a pelanggan
            $pelanggan = $this->User_model->get_pelanggan_by_username($username);
            
            if ($pelanggan && $this->User_model->verify_password($password, $pelanggan->password)) {
                // Pelanggan login
                $session_data = array(
                    'user_id' => $pelanggan->id_pelanggan,
                    'username' => $pelanggan->username,
                    'nama' => $pelanggan->nama_pelanggan,
                    'role' => 'pelanggan',
                    'nomor_meter' => $pelanggan->nomor_kwh,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($session_data);
                redirect('pelanggan/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth');
            }
        }
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    /**
     * Register page (for admin only)
     */
    public function register() {
        // Check if user is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        $data['levels'] = $this->User_model->get_all_levels();
        $this->load->view('auth/register', $data);
    }

    /**
     * Register process
     */
    public function register_process() {
        // Check if user is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('level_id', 'Level', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        }

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->User_model->hash_password($this->input->post('password')),
            'nama_admin' => $this->input->post('nama'),
            'id_level' => $this->input->post('level_id')
        );

        if ($this->User_model->insert($data)) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan user');
        }

        redirect('auth/register');
    }

    /**
     * Register pelanggan page (for admin only)
     */
    public function register_pelanggan() {
        // Check if user is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        $this->load->model('Tarif_model');
        $data['tarifs'] = $this->Tarif_model->get_all();
        $this->load->view('auth/register_pelanggan', $data);
    }

    /**
     * Register pelanggan process
     */
    public function register_pelanggan_process() {
        // Check if user is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_pelanggan');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|callback_check_nomor_kwh');
        $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register_pelanggan');
        }

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->User_model->hash_password($this->input->post('password')),
            'nama_pelanggan' => $this->input->post('nama_pelanggan'),
            'alamat' => $this->input->post('alamat'),
            'nomor_kwh' => $this->input->post('nomor_kwh'),
            'id_tarif' => $this->input->post('id_tarif')
        );

        if ($this->User_model->insert_pelanggan($data)) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan');
        }

        redirect('auth/register_pelanggan');
    }

    /**
     * Change password
     */
    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->load->view('auth/change_password');
    }

    /**
     * Change password process
     */
    public function change_password_process() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/change_password');
        }

        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('role');

        if ($user_type == 'admin') {
            $user = $this->User_model->get_by_id($user_id);
        } else {
            $user = $this->User_model->get_pelanggan_by_id($user_id);
        }
        
        if (!$this->User_model->verify_password($this->input->post('current_password'), $user->password)) {
            $this->session->set_flashdata('error', 'Password saat ini salah');
            redirect('auth/change_password');
        }

        $data = array(
            'password' => $this->User_model->hash_password($this->input->post('new_password'))
        );

        if ($user_type == 'admin') {
            $result = $this->User_model->update($user_id, $data);
        } else {
            $result = $this->User_model->update_pelanggan($user_id, $data);
        }

        if ($result) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password');
        }

        redirect('auth/change_password');
    }

    /**
     * Check if username exists for admin
     */
    public function check_username($username) {
        $user = $this->User_model->get_by_username($username);
        if ($user) {
            $this->form_validation->set_message('check_username', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Check if username exists for pelanggan
     */
    public function check_username_pelanggan($username) {
        $pelanggan = $this->User_model->get_pelanggan_by_username($username);
        if ($pelanggan) {
            $this->form_validation->set_message('check_username_pelanggan', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Check if nomor_kwh exists
     */
    public function check_nomor_kwh($nomor_kwh) {
        $pelanggan = $this->User_model->get_pelanggan_by_nomor_meter($nomor_kwh);
        if ($pelanggan) {
            $this->form_validation->set_message('check_nomor_kwh', 'Nomor KWH sudah terdaftar');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Check if user is logged in
     */
    private function _is_logged_in() {
        return $this->session->userdata('logged_in') === TRUE;
    }

    /**
     * Check if user is admin
     */
    private function _is_admin() {
        return $this->session->userdata('role') === 'admin';
    }

    /**
     * Check if user is pelanggan
     */
    private function _is_pelanggan() {
        return $this->session->userdata('role') === 'pelanggan';
    }
} 