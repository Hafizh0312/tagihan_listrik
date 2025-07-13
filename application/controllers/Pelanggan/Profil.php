<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Pelanggan_model', 'User_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is customer
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'pelanggan') {
            redirect('auth');
        }
    }

    /**
     * View profile
     */
    public function index() {
        $data['title'] = 'Profil Saya';
        $data['user'] = $this->User_model->get_pelanggan_by_id($this->session->userdata('user_id'));
        $data['pelanggan'] = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        $this->load->view('pelanggan/profil/index', $data);
    }

    /**
     * Edit profile
     */
    public function edit() {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->User_model->get_pelanggan_by_id($this->session->userdata('user_id'));
        $data['pelanggan'] = $this->Pelanggan_model->get_by_user_id($this->session->userdata('user_id'));
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                // Update user data
                $user_data = array(
                    'nama' => $this->input->post('nama')
                );
                
                if ($this->User_model->update_user($this->session->userdata('user_id'), $user_data)) {
                    // Update customer data
                    if ($data['pelanggan']) {
                        $pelanggan_data = array(
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat')
                        );
                        
                        if ($this->Pelanggan_model->update_pelanggan($data['pelanggan']->pelanggan_id, $pelanggan_data)) {
                            $this->session->set_flashdata('success', 'Profil berhasil diupdate');
                            redirect('pelanggan/profil');
                        } else {
                            $this->session->set_flashdata('error', 'Gagal mengupdate data pelanggan');
                        }
                    } else {
                        $this->session->set_flashdata('success', 'Profil berhasil diupdate');
                        redirect('pelanggan/profil');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data user');
                }
            }
        }
        
        $this->load->view('pelanggan/profil/edit', $data);
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
            $this->form_validation->set_message('matches', 'Konfirmasi Password harus sama dengan Password Baru.');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $user = $this->User_model->get_pelanggan_by_id($this->session->userdata('user_id'));
                
                if (!$this->User_model->verify_password($this->input->post('current_password'), $user->password)) {
                    $this->session->set_flashdata('error', 'Password saat ini salah');
                } else {
                    $data_update = array(
                        'password' => $this->User_model->hash_password($this->input->post('new_password'))
                    );
                    
                    if ($this->User_model->update_pelanggan($this->session->userdata('user_id'), $data_update)) {
                        $this->session->set_flashdata('success', 'Password berhasil diubah');
                        redirect('pelanggan/profil/change_password');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengubah password');
                    }
                }
            }
        }
        
        $this->load->view('pelanggan/profil/change_password', $data);
    }
} 