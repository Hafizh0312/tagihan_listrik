<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Pelanggan_model', 'User_model', 'Level_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * List all customers
     */
    public function index() {
        $data['title'] = 'Kelola Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['users'] = $this->User_model->get_users_by_role('pelanggan');
        $data['levels'] = $this->Level_model->get_all_level();
        
        $this->load->view('admin/pelanggan/index', $data);
    }

    /**
     * Add new customer
     */
    public function add() {
        $data['title'] = 'Tambah Pelanggan';
        $data['users'] = $this->User_model->get_users_by_role('pelanggan');
        $data['levels'] = $this->Level_model->get_all_level();
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('user_id', 'User Account', 'required');
            $this->form_validation->set_rules('level_id', 'Level Daya', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data_insert = array(
                    'nama' => $this->input->post('nama'),
                    'alamat' => $this->input->post('alamat'),
                    'user_id' => $this->input->post('user_id'),
                    'level_id' => $this->input->post('level_id')
                );
                
                if ($this->Pelanggan_model->create_pelanggan($data_insert)) {
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
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($id);
        $data['users'] = $this->User_model->get_users_by_role('pelanggan');
        $data['levels'] = $this->Level_model->get_all_level();
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'required');
            $this->form_validation->set_rules('user_id', 'User Account', 'required');
            $this->form_validation->set_rules('level_id', 'Level Daya', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $data_update = array(
                    'nama' => $this->input->post('nama'),
                    'alamat' => $this->input->post('alamat'),
                    'user_id' => $this->input->post('user_id'),
                    'level_id' => $this->input->post('level_id')
                );
                
                if ($this->Pelanggan_model->update_pelanggan($id, $data_update)) {
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
     * Delete customer
     */
    public function delete($id = null) {
        if (!$id) {
            redirect('admin/pelanggan');
        }
        
        $pelanggan = $this->Pelanggan_model->get_pelanggan_by_id($id);
        if (!$pelanggan) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }
        
        if ($this->Pelanggan_model->delete_pelanggan($id)) {
            $this->session->set_flashdata('success', 'Pelanggan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus pelanggan');
        }
        
        redirect('admin/pelanggan');
    }

    /**
     * View customer detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('admin/pelanggan');
        }
        
        $data['title'] = 'Detail Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan_by_id($id);
        
        if (!$data['pelanggan']) {
            $this->session->set_flashdata('error', 'Pelanggan tidak ditemukan');
            redirect('admin/pelanggan');
        }
        
        // Get customer usage data
        $data['penggunaan'] = $this->Pelanggan_model->get_penggunaan_by_pelanggan($id);
        
        $this->load->view('admin/pelanggan/view', $data);
    }

    /**
     * Search customers
     */
    public function search() {
        $keyword = $this->input->get('keyword');
        $data['title'] = 'Hasil Pencarian Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->search_pelanggan($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('admin/pelanggan/search', $data);
    }
} 