<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaksigudangmodel extends CI_Model {
	private $table_prefix = "";

	public function get($table){
		$this->load->database();
		$result = $this->db->get($this->table_prefix."".$table);
		$this->db->close();
		return $result;
	}
	public function select($condition, $table, $order_by="", $sort="ASC"){
		$this->load->database();
		$this->db->where($condition);
		$this->db->order_by($order_by, $sort);
		$result = $this->db->get($this->table_prefix."".$table);
		$this->db->close();
		return $result;
	}
	public function insert($data, $table){
		$this->load->database();
		$result = $this->db->insert($this->table_prefix."".$table, $data);
		$this->db->close();
		return $result;
	}
	public function insert_batch($data, $table) {
		$this->load->database();
		$result = $this->db->insert_batch($table, $data);
		$this->db->close();
		return $result;
	}
	public function insert_id($data, $table){
		$this->load->database();
		$result = $this->db->insert($this->table_prefix."".$table, $data);
		$insert_id = $this->db->insert_id();
		$this->db->close();
		return $insert_id;
	}
	public function update($condition, $data, $table){
		$this->load->database();
		$this->db->where($condition);
		$result = $this->db->update($this->table_prefix."".$table, $data);
		$this->db->close();
		return $result;
	}
	public function delete($condition, $table){
		$this->load->database();
		$this->db->where($condition);
		$result = $this->db->delete($this->table_prefix."".$table);
		$this->db->close();
		return $result;
	}
	public function rawQuery($query){
		$this->load->database();
		$result = $this->db->query($query);
		$this->db->close();
		return $result;
	}
	public function haveIn($field, $data, $condition, $table){
		$this->load->database();
		if($condition != null){
			$this->db->where($condition);
		}
		$this->db->where_in($field, $data);
		$result = $this->db->get($this->table_prefix."".$table);
		$this->db->close();
		return $result;
	}
	public function haveNotIn($field, $data, $condition, $table){
		$this->load->database();
		if($condition != null){
			$this->db->where($condition);
		}
		$this->db->where_not_in($field, $data);
		$result = $this->db->get($this->table_prefix."".$table);
		$this->db->close();
		return $result;
	}
	public function get_last_id($table) {
		$last_row = $this->db->select('id')->order_by('id',"desc")->limit(1)->get($table)->row();
		return !empty($last_row) ? $last_row->id : 0;
	}

	public function print_data($tipe='', $start='', $end='') {
		$result = [];
		if($tipe) {
			$sql = "SELECT gudang.id, gudang.stok_awal, gudang.jumlah_masuk, gudang.jumlah_keluar, gudang.stok_akhir, gudang.type, gudang.date_add,
          (CASE WHEN gudang.type = 1 THEN gm.no_transaksi ELSE gk.no_transaksi END) AS no_transaksi,
          (CASE WHEN gudang.type = 1 THEN gm.no_batch ELSE gk.no_batch END) AS no_batch,
          (CASE WHEN gudang.type = 1 THEN gm.expired_date ELSE gk.expired_date END) AS expired_date,
          (CASE WHEN gudang.type = 1 THEN gm.harga_pembelian ELSE gk.harga_penjualan END) AS harga,
          bahan. id AS id_bahan, bahan.nama AS nama_bahan, bahan.kode_bahan, satuan.nama AS nama_satuan
          FROM tt_gudang gudang
          LEFT JOIN tt_gudang_masuk gm ON (gm.id = gudang.id_gudang AND gudang.type = 1)
          LEFT JOIN tt_gudang_keluar gk ON (gk.id = gudang.id_gudang AND gudang.type = 2)
          LEFT JOIN m_bahan bahan ON bahan.id = gudang.id_bahan
          LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
          JOIN (
              SELECT id_bahan, max(date_add) date_add FROM tt_gudang GROUP BY id_bahan
          ) gudang_2 ON gudang.id_bahan = gudang_2.id_bahan AND gudang.date_add = gudang_2.date_add";

			if($tipe == 'harian') {
				$sql .= ' WHERE gudang.date_add = CURDATE()';
			}
			else if($tipe == 'mingguan') {
				$sql .= ' WHERE YEARWEEK(gudang.date_add, 1) = YEARWEEK(CURDATE(), 1)';
			}
			else if($tipe == 'bulanan') {
				$sql .= ' WHERE DATE_FORMAT(gudang.date_add, "%Y-%m") =  DATE_FORMAT(CURDATE(), "%Y-%m")';
			}
			else if($tipe == 'custom') {
				$start_date = date('Y-m-d', strtotime($start));
				$end_date = date('Y-m-d', strtotime($end));
				if($start_date > $end_date) {
					$start_date = date('Y-m-d', strtotime($end));
					$end_date = date('Y-m-d', strtotime($start));
				}
				$sql .= " WHERE gudang.date_add BETWEEN '".$start_date."' AND '".$end_date."'";
			}
			$result = $this->db->query($sql)->result();
		}
		return $result;
	}
}
