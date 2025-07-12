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

        // Check user credentials
        $user = $this->User_model->get_user_by_username($username);
        
        if (!$user) {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth');
        }

        if (!$this->User_model->verify_password($password, $user->password)) {
            $this->session->set_flashdata('error', 'Password salah');
            redirect('auth');
        }

        // Set session data
        $session_data = array(
            'user_id' => $user->user_id,
            'username' => $user->username,
            'nama' => $user->nama,
            'role' => $user->role,
            'logged_in' => TRUE
        );

        $this->session->set_userdata($session_data);

        // Redirect based on role
        if ($user->role == 'admin') {
            redirect('admin/dashboard');
        } else {
            redirect('pelanggan/dashboard');
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

        $this->load->view('auth/register');
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
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,pelanggan]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register');
        }

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->User_model->hash_password($this->input->post('password')),
            'nama' => $this->input->post('nama'),
            'role' => $this->input->post('role')
        );

        if ($this->User_model->create_user($data)) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan user');
        }

        redirect('auth/register');
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

        $user = $this->User_model->get_user_by_id($this->session->userdata('user_id'));
        
        if (!$this->User_model->verify_password($this->input->post('current_password'), $user->password)) {
            $this->session->set_flashdata('error', 'Password saat ini salah');
            redirect('auth/change_password');
        }

        $data = array(
            'password' => $this->User_model->hash_password($this->input->post('new_password'))
        );

        if ($this->User_model->update_user($this->session->userdata('user_id'), $data)) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah password');
        }

        redirect('auth/change_password');
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
     * Check if user is customer
     */
    private function _is_pelanggan() {
        return $this->session->userdata('role') === 'pelanggan';
    }
} 