<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PHP 8.2 Compatibility Helper
 * 
 * This helper provides compatibility fixes for CodeIgniter 3.1.13 running on PHP 8.2
 * by suppressing deprecation warnings for dynamic property creation.
 */

if ( ! function_exists('php82_compatibility_init'))
{
	/**
	 * Initialize PHP 8.2 compatibility settings
	 *
	 * @return	void
	 */
	function php82_compatibility_init()
	{
		// Suppress deprecation warnings for dynamic property creation
		// This is a temporary fix until CodeIgniter 3 is updated
		if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
			error_reporting(E_ALL & ~E_DEPRECATED);
		}
	}
}

if ( ! function_exists('is_php82'))
{
	/**
	 * Check if PHP version is 8.2 or higher
	 *
	 * @return	bool
	 */
	function is_php82()
	{
		return version_compare(PHP_VERSION, '8.2.0', '>=');
	}
} 

if (!function_exists('bulan_indo')) {
    function bulan_indo($bulan) {
        $nama_bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return isset($nama_bulan[(int)$bulan]) ? $nama_bulan[(int)$bulan] : $bulan;
    }
} 