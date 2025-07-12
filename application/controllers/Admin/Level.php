<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Level_model', 'Pelanggan_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    /**
     * List all levels
     */
    public function index() {
        $data['title'] = 'Kelola Level Daya';
        $data['levels'] = $this->Level_model->get_all_level();
        $data['levels_with_customers'] = $this->Level_model->get_levels_with_customer_count();
        
        $this->load->view('admin/level/index', $data);
    }

    /**
     * Add new level
     */
    public function add() {
        $data['title'] = 'Tambah Level Daya';
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('tarif_per_kwh', 'Tarif per KWH', 'required|numeric|greater_than[0]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                // Check if daya already exists
                if ($this->Level_model->daya_exists($this->input->post('daya'))) {
                    $this->session->set_flashdata('error', 'Level daya dengan nilai ' . $this->input->post('daya') . ' sudah ada');
                } else {
                    $data_insert = array(
                        'daya' => $this->input->post('daya'),
                        'tarif_per_kwh' => $this->input->post('tarif_per_kwh')
                    );
                    
                    if ($this->Level_model->create_level($data_insert)) {
                        $this->session->set_flashdata('success', 'Level daya berhasil ditambahkan');
                        redirect('admin/level');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menambahkan level daya');
                    }
                }
            }
        }
        
        $this->load->view('admin/level/add', $data);
    }

    /**
     * Edit level
     */
    public function edit($id = null) {
        if (!$id) {
            redirect('admin/level');
        }
        
        $data['title'] = 'Edit Level Daya';
        $data['level'] = $this->Level_model->get_level_by_id($id);
        
        if (!$data['level']) {
            $this->session->set_flashdata('error', 'Level daya tidak ditemukan');
            redirect('admin/level');
        }
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('daya', 'Daya', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('tarif_per_kwh', 'Tarif per KWH', 'required|numeric|greater_than[0]');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                // Check if daya already exists (excluding current record)
                if ($this->Level_model->daya_exists($this->input->post('daya'), $id)) {
                    $this->session->set_flashdata('error', 'Level daya dengan nilai ' . $this->input->post('daya') . ' sudah ada');
                } else {
                    $data_update = array(
                        'daya' => $this->input->post('daya'),
                        'tarif_per_kwh' => $this->input->post('tarif_per_kwh')
                    );
                    
                    if ($this->Level_model->update_level($id, $data_update)) {
                        $this->session->set_flashdata('success', 'Level daya berhasil diupdate');
                        redirect('admin/level');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal mengupdate level daya');
                    }
                }
            }
        }
        
        $this->load->view('admin/level/edit', $data);
    }

    /**
     * Delete level
     */
    public function delete($id = null) {
        if (!$id) {
            redirect('admin/level');
        }
        
        $level = $this->Level_model->get_level_by_id($id);
        if (!$level) {
            $this->session->set_flashdata('error', 'Level daya tidak ditemukan');
            redirect('admin/level');
        }
        
        // Update all customers using this level to set level_id to NULL
        $this->Pelanggan_model->set_level_null($id);
        
        if ($this->Level_model->delete_level($id)) {
            $this->session->set_flashdata('success', 'Level daya berhasil dihapus. Semua pelanggan yang menggunakan level ini telah diupdate.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus level daya');
        }
        
        redirect('admin/level');
    }

    /**
     * View level detail
     */
    public function view($id = null) {
        if (!$id) {
            redirect('admin/level');
        }
        
        $data['title'] = 'Detail Level Daya';
        $data['level'] = $this->Level_model->get_level_by_id($id);
        
        if (!$data['level']) {
            $this->session->set_flashdata('error', 'Level daya tidak ditemukan');
            redirect('admin/level');
        }
        
        // Get customers using this level
        $data['customers'] = $this->Pelanggan_model->get_pelanggan_by_level($id);
        
        $this->load->view('admin/level/view', $data);
    }

    /**
     * Level statistics
     */
    public function statistics() {
        $data['title'] = 'Statistik Level Daya';
        $data['levels_with_customers'] = $this->Level_model->get_levels_with_customer_count();
        $data['average_tarif'] = $this->Level_model->get_average_tarif();
        $data['tarif_range'] = $this->Level_model->get_tarif_range();
        $data['unique_daya'] = $this->Level_model->get_unique_daya();
        
        $this->load->view('admin/level/statistics', $data);
    }

    /**
     * Import levels from CSV
     */
    public function import() {
        $data['title'] = 'Import Level Daya';
        
        if ($this->input->post()) {
            $this->load->library('upload');
            
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 2048;
            
            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('csv_file')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            } else {
                $upload_data = $this->upload->data();
                $file_path = $upload_data['full_path'];
                
                // Process CSV file
                $imported_count = 0;
                $errors = array();
                
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    // Skip header row
                    fgetcsv($handle);
                    
                    while (($data_row = fgetcsv($handle)) !== FALSE) {
                        if (count($data_row) >= 2) {
                            $daya = trim($data_row[0]);
                            $tarif = trim($data_row[1]);
                            
                            if (is_numeric($daya) && is_numeric($tarif) && $daya > 0 && $tarif > 0) {
                                if (!$this->Level_model->daya_exists($daya)) {
                                    $insert_data = array(
                                        'daya' => $daya,
                                        'tarif_per_kwh' => $tarif
                                    );
                                    
                                    if ($this->Level_model->create_level($insert_data)) {
                                        $imported_count++;
                                    } else {
                                        $errors[] = "Gagal import daya: $daya";
                                    }
                                } else {
                                    $errors[] = "Daya $daya sudah ada";
                                }
                            } else {
                                $errors[] = "Data tidak valid: $daya, $tarif";
                            }
                        }
                    }
                    fclose($handle);
                }
                
                // Delete uploaded file
                unlink($file_path);
                
                if ($imported_count > 0) {
                    $this->session->set_flashdata('success', "$imported_count level daya berhasil diimport");
                }
                
                if (!empty($errors)) {
                    $this->session->set_flashdata('error', implode('<br>', $errors));
                }
                
                redirect('admin/level');
            }
        }
        
        $this->load->view('admin/level/import', $data);
    }

    /**
     * Export levels to CSV
     */
    public function export() {
        $levels = $this->Level_model->get_all_level();
        
        $filename = 'level_daya_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add header
        fputcsv($output, array('Daya (Watt)', 'Tarif per KWH'));
        
        // Add data
        foreach ($levels as $level) {
            fputcsv($output, array($level->daya, $level->tarif_per_kwh));
        }
        
        fclose($output);
        exit;
    }
} 