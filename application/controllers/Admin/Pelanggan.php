<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Pelanggan_model', 'Tarif_model', 'User_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * Index - List all customers
     */
    public function index() {
        $data['title'] = 'Kelola Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        
        $this->load->view('admin/pelanggan/index', $data);
    }

    /**
     * Add new customer
     */
    public function add() {
        $data['title'] = 'Tambah Pelanggan';
        $data['tarifs'] = $this->Tarif_model->get_all();
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|callback_check_nomor_kwh');
            $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data_insert = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->User_model->hash_password($this->input->post('password')),
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'id_tarif' => $this->input->post('id_tarif')
                );

                if ($this->Pelanggan_model->insert($data_insert)) {
                    $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan');
                    redirect('admin/pelanggan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan');
                }
            }
        }
        
        $this->load->view('admin/pelanggan/add', $data);
    }

    /**
     * Edit customer
     */
    public function edit($id = null) {
        if (!$id) {
            redirect('admin/pelanggan');
        }

        $data['title'] = 'Edit Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($id);
        $data['tarifs'] = $this->Tarif_model->get_all();
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username[' . $id . ']');
            $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_kwh', 'Nomor KWH', 'required|callback_check_nomor_kwh[' . $id . ']');
            $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data_update = array(
                    'username' => $this->input->post('username'),
                    'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                    'alamat' => $this->input->post('alamat'),
                    'nomor_kwh' => $this->input->post('nomor_kwh'),
                    'id_tarif' => $this->input->post('id_tarif')
                );

                // Update password if provided
                if ($this->input->post('password')) {
                    $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]');
                    
                    if ($this->form_validation->run() == FALSE) {
                        $this->session->set_flashdata('error', validation_errors());
                    } else {
                        $data_update['password'] = $this->User_model->hash_password($this->input->post('password'));
                    }
                }

                if ($this->Pelanggan_model->update($id, $data_update)) {
                    $this->session->set_flashdata('success', 'Pelanggan berhasil diupdate');
                    redirect('admin/pelanggan');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate pelanggan');
                }
            }
        }
        
        $this->load->view('admin/pelanggan/edit', $data);
    }

    /**
     * View customer details
     */
    public function view($id = null) {
        if (!$id) {
            redirect('admin/pelanggan');
        }

        $data['title'] = 'Detail Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($id);
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }

        // Get usage data
        $this->load->model('Penggunaan_model');
        $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan_by_pelanggan($id);
        
        // Get bill data
        $this->load->model('Tagihan_model');
        $data['tagihan'] = $this->Tagihan_model->get_tagihan_by_pelanggan($id);
        
        $this->load->view('admin/pelanggan/view', $data);
    }

    /**
     * Delete customer
     */
    public function delete($id = null) {
        if (!$id) {
            redirect('admin/pelanggan');
        }

        $pelanggan = $this->Pelanggan_model->get_by_id($id);
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }

        if ($this->Pelanggan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pelanggan');
        }

        redirect('admin/pelanggan');
    }

    /**
     * Search customers
     */
    public function search() {
        $keyword = $this->input->get('keyword');
        $data['title'] = 'Hasil Pencarian Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->search($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('admin/pelanggan/search', $data);
    }

    /**
     * Check username uniqueness
     */
    public function check_username($username, $exclude_id = null) {
        if ($this->Pelanggan_model->username_exists($username, $exclude_id)) {
            $this->form_validation->set_message('check_username', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Check nomor_kwh uniqueness
     */
    public function check_nomor_kwh($nomor_kwh, $exclude_id = null) {
        if ($this->Pelanggan_model->nomor_kwh_exists($nomor_kwh, $exclude_id)) {
            $this->form_validation->set_message('check_nomor_kwh', 'Nomor KWH sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
} 