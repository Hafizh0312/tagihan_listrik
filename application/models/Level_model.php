<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all levels
     */
    public function get_all_level() {
        $this->db->order_by('daya ASC');
        return $this->db->get('level')->result();
    }

    /**
     * Get level by ID
     */
    public function get_level_by_id($level_id) {
        $this->db->where('level_id', $level_id);
        return $this->db->get('level')->row();
    }

    /**
     * Get level by daya
     */
    public function get_level_by_daya($daya) {
        $this->db->where('daya', $daya);
        return $this->db->get('level')->row();
    }

    /**
     * Create new level
     */
    public function create_level($data) {
        return $this->db->insert('level', $data);
    }

    /**
     * Update level
     */
    public function update_level($level_id, $data) {
        $this->db->where('level_id', $level_id);
        return $this->db->update('level', $data);
    }

    /**
     * Delete level
     */
    public function delete_level($level_id) {
        $this->db->where('level_id', $level_id);
        return $this->db->delete('level');
    }

    /**
     * Check if daya exists
     */
    public function daya_exists($daya, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('level_id !=', $exclude_id);
        }
        $this->db->where('daya', $daya);
        return $this->db->get('level')->num_rows() > 0;
    }

    /**
     * Get level count
     */
    public function get_level_count() {
        return $this->db->count_all('level');
    }

    /**
     * Get unique daya values
     */
    public function get_unique_daya() {
        $this->db->select('DISTINCT daya');
        $this->db->order_by('daya ASC');
        return $this->db->get('level')->result();
    }

    /**
     * Get levels with customer count
     */
    public function get_levels_with_customer_count() {
        $this->db->select('level.*, COUNT(pelanggan.pelanggan_id) as customer_count');
        $this->db->from('level');
        $this->db->join('pelanggan', 'pelanggan.level_id = level.level_id', 'left');
        $this->db->group_by('level.level_id');
        $this->db->order_by('level.daya ASC');
        return $this->db->get()->result();
    }

    /**
     * Get average tariff
     */
    public function get_average_tarif() {
        $this->db->select('AVG(tarif_per_kwh) as avg_tarif');
        return $this->db->get('level')->row();
    }

    /**
     * Get min and max tariff
     */
    public function get_tarif_range() {
        $this->db->select('MIN(tarif_per_kwh) as min_tarif, MAX(tarif_per_kwh) as max_tarif');
        return $this->db->get('level')->row();
    }
} 