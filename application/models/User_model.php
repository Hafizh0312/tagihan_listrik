<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get user by username
     */
    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get('users')->row();
    }

    /**
     * Get user by ID
     */
    public function get_user_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('users')->row();
    }

    /**
     * Create new user
     */
    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    /**
     * Update user
     */
    public function update_user($user_id, $data) {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Delete user
     */
    public function delete_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->delete('users');
    }

    /**
     * Get all users
     */
    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    /**
     * Get users by role
     */
    public function get_users_by_role($role) {
        $this->db->where('role', $role);
        return $this->db->get('users')->result();
    }

    /**
     * Check if username exists
     */
    public function username_exists($username, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('user_id !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->get('users')->num_rows() > 0;
    }

    /**
     * Verify password
     */
    public function verify_password($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Hash password
     */
    public function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
} 