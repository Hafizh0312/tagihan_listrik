<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get user by username (admin/petugas)
     */
    public function get_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get('user')->row();
    }

    /**
     * Get user by ID (admin/petugas)
     */
    public function get_by_id($id) {
        $this->db->where('id_user', $id);
        return $this->db->get('user')->row();
    }

    /**
     * Get pelanggan by username
     */
    public function get_pelanggan_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get('pelanggan')->row();
    }

    /**
     * Get pelanggan by ID
     */
    public function get_pelanggan_by_id($id) {
        $this->db->where('id_pelanggan', $id);
        return $this->db->get('pelanggan')->row();
    }

    /**
     * Get pelanggan by nomor meter (nomor_kwh in old structure)
     */
    public function get_pelanggan_by_nomor_meter($nomor_meter) {
        $this->db->where('nomor_kwh', $nomor_meter);
        return $this->db->get('pelanggan')->row();
    }

    /**
     * Create new user (admin/petugas)
     */
    public function insert($data) {
        return $this->db->insert('user', $data);
    }

    /**
     * Create new pelanggan
     */
    public function insert_pelanggan($data) {
        return $this->db->insert('pelanggan', $data);
    }

    /**
     * Update user (admin/petugas)
     */
    public function update($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update('user', $data);
    }

    /**
     * Update pelanggan
     */
    public function update_pelanggan($id, $data) {
        $this->db->where('id_pelanggan', $id);
        return $this->db->update('pelanggan', $data);
    }

    /**
     * Delete user (admin/petugas)
     */
    public function delete($id) {
        $this->db->where('id_user', $id);
        return $this->db->delete('user');
    }

    /**
     * Delete pelanggan
     */
    public function delete_pelanggan($id) {
        $this->db->where('id_pelanggan', $id);
        return $this->db->delete('pelanggan');
    }

    /**
     * Get all users (admin/petugas)
     */
    public function get_all() {
        $this->db->select('user.*, level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'level.id_level = user.id_level', 'left');
        return $this->db->get()->result();
    }

    /**
     * Get all pelanggan
     */
    public function get_all_pelanggan() {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'tarif.id_tarif = pelanggan.id_tarif', 'left');
        return $this->db->get()->result();
    }

    /**
     * Get users by level
     */
    public function get_users_by_level($level_id) {
        $this->db->where('id_level', $level_id);
        return $this->db->get('user')->result();
    }

    /**
     * Check if username exists in user table
     */
    public function username_exists_user($username, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_user !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->get('user')->num_rows() > 0;
    }

    /**
     * Check if username exists in pelanggan table
     */
    public function username_exists_pelanggan($username, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Check if nomor_kwh exists
     */
    public function nomor_meter_exists($nomor_kwh, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id_pelanggan !=', $exclude_id);
        }
        $this->db->where('nomor_kwh', $nomor_kwh);
        return $this->db->get('pelanggan')->num_rows() > 0;
    }

    /**
     * Verify password (MD5 for compatibility with existing data)
     */
    public function verify_password($password, $hash) {
        return md5($password) === $hash;
    }

    /**
     * Hash password (MD5 for compatibility)
     */
    public function hash_password($password) {
        return md5($password);
    }

    /**
     * Get user level name
     */
    public function get_level_name($level_id) {
        $this->db->where('id_level', $level_id);
        $level = $this->db->get('level')->row();
        return $level ? $level->nama_level : '';
    }

    /**
     * Get all levels
     */
    public function get_all_levels() {
        return $this->db->get('level')->result();
    }

    /**
     * Count all users
     */
    public function count_all() {
        return $this->db->count_all('user');
    }

    /**
     * Count all pelanggan
     */
    public function count_all_pelanggan() {
        return $this->db->count_all('pelanggan');
    }
} 