<?php

function base64_url_encode($input) {
 return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input) {
 return base64_decode(strtr($input, '._-', '+/='));
}

function pegawaiLevel($id) {
	$CI =& get_instance();
	$CI->load->database();
	$query = $CI->db->get_where('m_pegawai_level', array('id' => $id));
	return $query->row();
}

function toRupiah($number) {
	return "Rp".number_format($number, 0, '.', '.');
}

function cetakBulan()
{
	$month = intval(date('m'));
	
	$listMonth = [
		1 => "Januari",
		2 => "Februari",
		3 => "Maret",
		4 => "April",
		5 => "Mei",
		6 => "Juni",
		7 => "Juli",
		8 => "Agustus",
		9 => "September",
		10 => "Oktober",
		11 => "November",
		12 => "Desember"
	];

	return $listMonth[$month];
} 