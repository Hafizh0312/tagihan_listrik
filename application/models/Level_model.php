<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all tarif levels
     */
    public function get_all_levels() {
        return $this->db->get('tarif')->result();
    }

    /**
     * Get tarif level by ID
     */
    public function get_level_by_id($id_tarif) {
        $this->db->where('id_tarif', $id_tarif);
        return $this->db->get('tarif')->row();
    }

    /**
     * Create new tarif level
     */
    public function create_level($data) {
        return $this->db->insert('tarif', $data);
    }

    /**
     * Update tarif level
     */
    public function update_level($id_tarif, $data) {
        $this->db->where('id_tarif', $id_tarif);
        return $this->db->update('tarif', $data);
    }

    /**
     * Delete tarif level
     */
    public function delete_level($id_tarif) {
        // Check if tarif is used by any pelanggan
        $this->db->where('id_tarif', $id_tarif);
        $count = $this->db->get('pelanggan')->num_rows();
        
        if ($count > 0) {
            return false; // Cannot delete if used by pelanggan
        }
        
        $this->db->where('id_tarif', $id_tarif);
        return $this->db->delete('tarif');
    }

    /**
     * Get tarif level count
     */
    public function get_level_count() {
        return $this->db->count_all('tarif');
    }

    /**
     * Check if daya exists
     */
    public function daya_exists($daya, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_tarif !=', $exclude_id);
        }
        $this->db->where('daya', $daya);
        return $this->db->get('tarif')->num_rows() > 0;
    }

    /**
     * Get tarif levels with customer count
     */
    public function get_levels_with_customer_count() {
        $this->db->select('tarif.*, COUNT(pelanggan.id_pelanggan) as customer_count');
        $this->db->from('tarif');
        $this->db->join('pelanggan', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $this->db->group_by('tarif.id_tarif');
        return $this->db->get()->result();
    }

    /**
     * Get average tarif
     */
    public function get_average_tarif() {
        $this->db->select('AVG(tarifperkwh) as average_tarif');
        $result = $this->db->get('tarif')->row();
        return $result ? $result->average_tarif : 0;
    }

    /**
     * Get tarif range
     */
    public function get_tarif_range() {
        $this->db->select('MIN(tarifperkwh) as min_tarif, MAX(tarifperkwh) as max_tarif');
        return $this->db->get('tarif')->row();
    }

    /**
     * Get unique daya values
     */
    public function get_unique_daya() {
        $this->db->select('daya, COUNT(*) as count');
        $this->db->group_by('daya');
        return $this->db->get('tarif')->result();
    }
} 