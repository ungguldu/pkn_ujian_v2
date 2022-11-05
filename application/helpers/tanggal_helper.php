<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tgl_indo')) {
	function date_indo($tgl)
	{
		$ubah = gmdate($tgl, time() + 60 * 60 * 8);
		$pecah = explode("-", $ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal . ' ' . $bulan . ' ' . $tahun;
	}
}

if (!function_exists('bulan')) {
	function bulan($bln)
	{
		switch ($bln) {
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

//Format Shortdate
if (!function_exists('tanggal_pendek')) {
	function tanggal_pendek($tgl)
	{
		if ($tgl == '0000-00-00 00:00:00') return '&#x26D4;';
		$tanggal = substr($tgl, 0, 10);
		$ubah = gmdate($tanggal, time() + 60 * 60 * 8);
		$pecah = explode("-", $ubah);
		$tanggal = $pecah[2];
		$bulan = short_bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal . '/' . $bulan . '/' . $tahun;
	}
}

if (!function_exists('short_bulan')) {
	function short_bulan($bln)
	{
		switch ($bln) {
			case 1:
				return "01";
				break;
			case 2:
				return "02";
				break;
			case 3:
				return "03";
				break;
			case 4:
				return "04";
				break;
			case 5:
				return "05";
				break;
			case 6:
				return "06";
				break;
			case 7:
				return "07";
				break;
			case 8:
				return "08";
				break;
			case 9:
				return "09";
				break;
			case 10:
				return "10";
				break;
			case 11:
				return "11";
				break;
			case 12:
				return "12";
				break;
		}
	}
}

//Format Medium date
if (!function_exists('tanggal_sedang')) {
	function tanggal_sedang($tgl, $jam = FAlSE)
	{
		if ($tgl == '0000-00-00 00:00:00') return '&#x26D4;';
		$tanggal = substr($tgl, 0, 10);
		$ubah = gmdate($tanggal, time() + 60 * 60 * 8);
		$pecah = explode("-", $ubah);
		$tanggal = $pecah[2];
		$bulan = medium_bulan($pecah[1]);
		$tahun = $pecah[0];
		if ($jam == FAlSE) {
			return $tanggal . '-' . $bulan . '-' . $tahun;
		} else {
			return $tanggal . '-' . $bulan . '-' . $tahun . ', ' . substr($tgl, 10);
		}
	}
}

if (!function_exists('medium_bulan')) {
	function medium_bulan($bln)
	{
		switch ($bln) {
			case 1:
				return "Jan";
				break;
			case 2:
				return "Feb";
				break;
			case 3:
				return "Mar";
				break;
			case 4:
				return "Apr";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Jun";
				break;
			case 7:
				return "Jul";
				break;
			case 8:
				return "Ags";
				break;
			case 9:
				return "Sep";
				break;
			case 10:
				return "Okt";
				break;
			case 11:
				return "Nov";
				break;
			case 12:
				return "Des";
				break;
		}
	}
}

//Long date indo Format
if (!function_exists('tanggal_panjang')) {
	function tanggal_panjang($tgl, $jam = FAlSE)
	{
		if ($tgl == '0000-00-00 00:00:00') return '&#x26D4;';
		$tanggal = substr($tgl, 0, 10);
		$pukul = substr($tgl, 11, 19);
		$ubah = gmdate($tanggal, time() + 60 * 60 * 8);
		$pecah = explode("-", $ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];
		$bulan = bulan($pecah[1]);

		$nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
		$nama_hari = "";
		if ($nama == "Sunday") {
			$nama_hari = "Minggu";
		} else if ($nama == "Monday") {
			$nama_hari = "Senin";
		} else if ($nama == "Tuesday") {
			$nama_hari = "Selasa";
		} else if ($nama == "Wednesday") {
			$nama_hari = "Rabu";
		} else if ($nama == "Thursday") {
			$nama_hari = "Kamis";
		} else if ($nama == "Friday") {
			$nama_hari = "Jumat";
		} else if ($nama == "Saturday") {
			$nama_hari = "Sabtu";
		}
		if ($jam !== FALSE) {
			return $nama_hari . ', ' . $tgl . ' ' . $bulan . ' ' . $thn . ' - ' . $pukul;
		}
		return $nama_hari . ', ' . $tgl . ' ' . $bulan . ' ' . $thn;
	}
}

function datepicker_to_mysql($date = null, $full = TRUE)
{
	if (empty($date)) $timestamp = date("Y-m-d H:i:s");
	$timestamp = strtotime(str_replace('/', '-', $date));
	if ($full) return date("Y-m-d H:i:s", $timestamp);
	return date("Y-m-d", $timestamp);
}

/**
 * Creating date collection between two dates
 *
 * <code>
 * <?php
 * # Example 1
 * date_range("2014-01-01", "2014-01-20", "+1 day", "m/d/Y");
 *
 * # Example 2. you can use even time
 * date_range("01:00:00", "23:00:00", "+1 hour", "H:i:s");
 * </code>
 *
 * @author Ali OYGUR <alioygur@gmail.com>
 * @param string since any date, time or datetime format
 * @param string until any date, time or datetime format
 * @param string step
 * @param string date of output format
 * @return array
 */
function tanggal_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
{

	$dates = array();
	$current = strtotime($first);
	$last = strtotime($last);

	while ($current <= $last) {

		$dates[] = date($output_format, $current);
		$current = strtotime($step, $current);
	}

	return $dates;
}

function is_tanggal_benar($date)
{
	if (false === strtotime($date)) {
		return false;
	}
	list($year, $month, $day) = explode('-', $date);
	return checkdate($month, $day, $year);
}

function validateDate($date, $format = 'Y-m-d')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}