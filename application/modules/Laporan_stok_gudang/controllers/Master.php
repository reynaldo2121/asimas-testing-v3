<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
  private $modul = "Laporan_stok_gudang/";
  private $fungsi = "";
  function __construct() {
    parent::__construct();
    $this->load->model('Laporanstokgudangmodel');
    $this->modul .= $this->router->fetch_class();
    $this->fungsi = $this->router->fetch_method();
    $this->_insertLog();
  }
  function _insertLog($fungsi = null){
    $id_user = $this->session->userdata('id_user');
    $dataInsert['id_user'] = $id_user;
    $dataInsert['modul'] = $this->modul;
    $dataInsert['fungsi'] = $this->fungsi;
    $insertLog = $this->Laporanstokgudangmodel->insert($dataInsert, 't_log');
  }
  function index(){
    $this->load->view('Laporan_stok_gudang/view');
  }
  function cetak(){
    // $sql = "SELECT
    // bahan.id, bahan.nama AS nama_bahan , bahan.expired_date,
    // SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_awal AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_awal,
    // SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_akhir,
    // SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_masuk AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_masuk,
    // SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_keluar AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_keluar,
    // satuan.nama AS nama_satuan
    // FROM m_bahan bahan
    // LEFT JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
    // LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
    // WHERE bahan.deleted = 1
    // GROUP BY bahan.id 
    // ORDER BY bahan.nama";    

    //..revisi aldo
    $sql = "  SELECT
      bahan.id, bahan.nama AS nama_bahan , bahan.expired_date,
      SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_awal AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_awal,
      SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_akhir,
      SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_masuk AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_masuk,
      SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_keluar AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_keluar,
      satuan.nama AS nama_satuan,
      IF(gudang.type = 1, 'Gudang Masuk','Gudang Keluar')as type     
      FROM m_bahan bahan
      JOIN m_bahan_kategori kategori ON kategori.id = bahan.id_kategori_bahan
      JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
      JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
      WHERE bahan.deleted = 1
      GROUP BY gudang.id_gudang
      ORDER BY bahan.nama";

    $query=$this->Laporanstokgudangmodel->rawQuery($sql);
    $data['data_list'] = $query->result();
    $this->load->view('Laporan_stok_gudang/cetak', $data);
  }

  function data()
  {
    $requestData= $_REQUEST;

      // $sql = "SELECT bahan.id
      //         FROM m_bahan bahan
      //         LEFT JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
      //         LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
      //         WHERE bahan.deleted = 1 GROUP BY bahan.id";

      //..revisi aldo
    $sql = "SELECT bahan.id
    FROM m_bahan bahan
    JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
    JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
    WHERE bahan.deleted = 1 GROUP BY gudang.id_gudang";


    $query = $this->Laporanstokgudangmodel->rawQuery($sql);
    $totalData = $query->num_rows();

    $columns = array(
      0 => "", 
      1 => "bahan.nama", 
      2 => "satuan.nama",
      3 => "MAX(stok_awal)",
      4 => "jumlah_masuk",
      5 => "jumlah_keluar",
      6 => "MAX(stok_akhir)",
      7 => "bahan.expired_date"
      );

      // $sql = "SELECT
      //         bahan.id, bahan.nama AS nama_bahan , bahan.expired_date,
      //         SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_awal AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_awal,
      //         SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_akhir,
      //         SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_masuk AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_masuk,
      //         SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_keluar AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_keluar,
      //         satuan.nama AS nama_satuan
      //         FROM m_bahan bahan
      //         LEFT JOIN m_bahan_kategori kategori ON kategori.id = bahan.id_kategori_bahan
      //         LEFT JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
      //         LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
      //         WHERE bahan.deleted = 1";

      //..revisi aldo
    $sql = "SELECT
    bahan.id, bahan.nama AS nama_bahan , bahan.expired_date,
    SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_awal AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_awal,
    SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_akhir,
    SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_masuk AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_masuk,
    SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_keluar AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_keluar,
    satuan.nama AS nama_satuan,
    gudang.type as type
    FROM m_bahan bahan
    JOIN m_bahan_kategori kategori ON kategori.id = bahan.id_kategori_bahan
    JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
    JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
    WHERE bahan.deleted = 1
    ";


    if( !empty($requestData['search']['value']) ) {
      $sql.=" AND ( bahan.nama LIKE '%".$requestData['search']['value']."%' ";
        $sql.=" OR kategori.nama LIKE '%".$requestData['search']['value']."%' )";
}
$totalFiltered = $query->num_rows();

      // $sql.=" GROUP BY bahan.id";
      //..revisi aldo
$sql.="GROUP BY gudang.id_gudang";
// $sql.="ORDER BY bahan.nama";

if($requestData['order'][0]['column']) {
  $sql .= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
}
if($requestData['length'] > 0) {
  $sql.= " LIMIT ".$requestData['start']." ,".$requestData['length']."";
}
$query=$this->Laporanstokgudangmodel->rawQuery($sql);

$data = array(); $i=0;
foreach ($query->result_array() as $row) {

  $sql = "SELECT SUM(jumlah_keluar) AS keluar_pp FROM h_bahan WHERE id_bahan = ".$row['id'];
  $keluar_pp = $this->Laporanstokgudangmodel->rawQuery($sql)->row()->keluar_pp;
  $jumlahKeluar = ($keluar_pp > 0 ? floatval($keluar_pp) : 0) + ($row['jumlah_keluar']);
  $nestedData     =   array();
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($i+1)."</span>";
  $nestedData[]   =   $row["nama_bahan"];
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".$row["nama_satuan"]."</span>";
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["stok_awal"] ? $row["stok_awal"] : '-')."</span>";
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["jumlah_masuk"] ? $row["jumlah_masuk"] : '-')."</span>";
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($jumlahKeluar ? $jumlahKeluar : '-')."</span>";
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["stok_akhir"] ? $row["stok_akhir"] : '-')."</span>";
  $expiredDate = $row['expired_date'] == '0000-00-00' ? '-' : date('d/m/Y', strtotime($row["expired_date"]));
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".$expiredDate."</span>";
          //revisi aldo
  $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row['type'] == 1 ? 'Gudang Masuk' : 'Gudang Keluar')."</span>";
  $data[] = $nestedData; $i++;

}
$totalData = count($data);
$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
  );
echo json_encode($json_data);


}
}
