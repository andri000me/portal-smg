<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Anti XSS Filter
|--------------------------------------------------------------------------
|
| untuk keamanan XSS Injection dari form input.
|
*/

if (!function_exists('input')) {
	function input($var)
	{
		$ci = get_instance();
		$input = strip_tags(trim($ci->input->post($var, true)));
		return $input;
	}
}


/*
|--------------------------------------------------------------------------
| Parse tanggal dari database
|--------------------------------------------------------------------------
|
| merubah format tanggal database menjadi format tanggal indonesia.
|
*/

if (!function_exists('tgl_indo')) {
	function tgl_indo($date)
	{
		$arr_bln = array(
			1 => 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'jul', 'agustus', 'september', 'oktober', 'november', 'desember'
		);

		$exp = explode('-', $date);

		$d = $exp[2];
		$m = $arr_bln[(int) $exp[1]];
		$y = $exp[0];

		$tgl = $d . ' ' . substr(ucfirst($m), 0, 3) . ' ' . $y;
		return $tgl;
	}
}

/*
|--------------------------------------------------------------------------
| Parse tanggal dari form input ke database
|--------------------------------------------------------------------------
|
| merubah format tanggal form input menjadi format tanggal database.
|
*/

if (!function_exists('parse_tgl')) {
	function parse_tgl($date)
	{
		$exp = explode('/', $date);

		$d = $exp[0];
		$m = $exp[1];
		$y = $exp[2];

		$tgl = $y . '-' . $m . '-' . $d;
		return $tgl;
	}
}

/*
|--------------------------------------------------------------------------
| Parse tanggal dari database ke form input
|--------------------------------------------------------------------------
|
| merubah format tanggal database menjadi format tanggal form input.
|
*/

if (!function_exists('parse_tgl_db')) {
	function parse_tgl_db($date)
	{
		$exp = explode('-', $date);

		$d = $exp[2];
		$m = $exp[1];
		$y = $exp[0];

		$tgl = $d . '/' . $m . '/' . $y;
		return $tgl;
	}
}

/*
|--------------------------------------------------------------------------
| Parse format size
|--------------------------------------------------------------------------
|
| merubah format size ukuran file.
|
*/

if (!function_exists('format_size')) {
	function format_size($bytes)
	{
		if (($bytes * 1024) >= 1073741824) {
			$bytes = number_format($bytes / 1024, 2) . ' GB';
		} elseif (($bytes * 1024) >= 1048576) {
			$bytes = number_format($bytes / 1024, 2) . ' MB';
		} elseif (($bytes * 1024) >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}
}

/*
|--------------------------------------------------------------------------
| Array Sum
|--------------------------------------------------------------------------
|
| menjumlahkan total pada array di kolom tertentu.
|
*/

if (!function_exists('arr_sum')) {
	function arr_sum($arr, $kol)
	{
		$arr_sum = array_sum(array_column($arr, $kol));
		return $arr_sum;
	}
}
