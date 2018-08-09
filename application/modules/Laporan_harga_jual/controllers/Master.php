<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
    private $modul = "Laporan_harga_jual/";
    private $fungsi = "";
	function __construct() {
        parent::__construct();
        $this->load->model('Laporanhargajualmodel');
        $this->modul .= $this->router->fetch_class();
        $this->fungsi = $this->router->fetch_method();
        $this->_insertLog();
    }
    function _insertLog($fungsi = null){
        $id_user = $this->session->userdata('id_user');
        $dataInsert['id_user'] = $id_user;
        $dataInsert['modul'] = $this->modul;
        $dataInsert['fungsi'] = $this->fungsi;
        $insertLog = $this->Laporanhargajualmodel->insert($dataInsert, 't_log');
    }
    function index(){
    	$this->load->view('Laporan_harga_jual/view');
    }
    function cetak(){
        $sql = "SELECT
                bahan.nama AS nama_bahan, kategori.nama AS nama_kategori,
                SUM(gk.harga_penjualan / gudang.jumlah_keluar) / COUNT(*) AS total
                FROM m_bahan bahan, tt_gudang_keluar gk, m_bahan_kategori kategori, tt_gudang gudang
                WHERE gudang.id_bahan = bahan.id AND bahan.id_kategori_bahan = kategori.id
                AND gudang.id_gudang = gk.id";
        $sql .= " GROUP BY gk.id_bahan";
        $sql .= " ORDER BY gk.date_added DESC";
        $query=$this->Laporanhargajualmodel->rawQuery($sql);
        $data['data_list'] = $query->result();
    	$this->load->view('Laporan_harga_jual/cetak', $data);
    }
    function data() {

      $requestData= $_REQUEST;
      $sql = "SELECT bahan.id
              FROM m_bahan bahan
              LEFT JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
              LEFT JOIN tt_gudang_masuk gm ON gm.id = gudang.id_gudang AND gudang.type = 1
              LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
              WHERE bahan.deleted = 1 GROUP BY bahan.id";
      $query = $this->Laporanhargajualmodel->rawQuery($sql);
      $totalData = $query->num_rows();

      $columns = array(
            0 => "", 
            1 => "bahan.nama", 
            2 => "MAX(stok_awal)",
            3 => "jumlah_masuk",
            4 => "jumlah_keluar",
            5 => "MAX(stok_akhir)",
            6 => "harga_per_item",
            7 => "harga_rata"
         );
      $sql = "SELECT
              bahan.id, bahan.nama AS nama_bahan , bahan.expired_date,
              SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_awal AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_awal,
              SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS stok_akhir,
              SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_masuk AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_masuk,
              SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.jumlah_keluar AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 ) AS jumlah_keluar,
              ((SUM(gudang.jumlah_masuk * gm.harga_pembelian)) / SUM(gudang.jumlah_masuk)) AS harga_per_item,
              (((SUM(gudang.jumlah_masuk * gm.harga_pembelian)) / SUM(gudang.jumlah_masuk)) * SUBSTRING_INDEX( GROUP_CONCAT(CAST(gudang.stok_akhir AS CHAR) ORDER BY gudang.date_add DESC), ',', 1 )) AS harga_rata,
              satuan.nama AS nama_satuan
              FROM m_bahan bahan
              LEFT JOIN m_bahan_kategori kategori ON kategori.id = bahan.id_kategori_bahan
              LEFT JOIN tt_gudang gudang ON bahan.id = gudang.id_bahan
              LEFT JOIN tt_gudang_masuk gm ON gm.id = gudang.id_gudang AND gudang.type = 1
              LEFT JOIN m_satuan satuan ON bahan.id_satuan = satuan.id
              WHERE bahan.deleted = 1";
      if( !empty($requestData['search']['value']) ) {
          $sql.=" AND ( bahan.nama LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR kategori.nama LIKE '%".$requestData['search']['value']."%' )";
      }
      $totalFiltered = $query->num_rows();
      $sql.=" GROUP BY bahan.id";
      if($requestData['order'][0]['column']) {
            $sql .= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
        }
      if($requestData['length'] > 0) {
        $sql.= " LIMIT ".$requestData['start']." ,".$requestData['length']."";
      }
      $query=$this->Laporanhargajualmodel->rawQuery($sql);

      $data = array(); $i=0;
      foreach ($query->result_array() as $row) {
          $sql = "SELECT SUM(jumlah_keluar) AS keluar_pp FROM h_bahan WHERE id_bahan = ".$row['id'];
          $keluar_pp = $this->Laporanhargajualmodel->rawQuery($sql)->row()->keluar_pp;
          $jumlahKeluar = ($keluar_pp > 0 ? floatval($keluar_pp) : 0) + ($row['jumlah_keluar']);
          $nestedData     =   array();
          $nestedData[]   =   "<span class='text-center' style='display:block;'>".($i+1)."</span>";
          $nestedData[]   =   $row["nama_bahan"];
          $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["stok_awal"] ? $row["stok_awal"] : '-')."</span>";
          $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["jumlah_masuk"] ? $row["jumlah_masuk"] : '-')."</span>";
          $nestedData[]   =   "<span class='text-center' style='display:block;'>".($jumlahKeluar ? $jumlahKeluar : '-')."</span>";
          $nestedData[]   =   "<span class='text-center' style='display:block;'>".($row["stok_akhir"] ? $row["stok_akhir"] : '-')."</span>";
          $nestedData[]   =   "<span class='text-right' style='display:block;'>".toRupiah($row['harga_per_item'])."</span>";
          $nestedData[]   =   "<span class='text-right' style='display:block;'>".toRupiah($row['harga_rata'])."</span>";
          // $nestedData[]   =   "<span class='text-right' style='display:block;'>".toRupiah($row['harga_per_item'] * $row['stok_akhir'])."</span>";

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
    function testQuery(){
        $sql = "SELECT gudang.id, gudang.id_bahan, bahan.nama,
                gudang.jumlah_masuk, gudang.stok_akhir,
                gm.harga_pembelian
                FROM tt_gudang gudang, tt_gudang_masuk gm, m_bahan bahan
                WHERE type = 1
                AND gm.id = gudang.id_gudang
                AND gudang.id_bahan = bahan.id
                AND gudang.id_bahan = 1
                ORDER BY gudang.date_add DESC";
        $query = $this->Laporanhargajualmodel->rawQuery($sql);
        
        $formula1 = null;
        $formula2 = null;    
        $stokAkhir = 0;
        foreach($query->result() as $index => $row) {
            if($index == 0) {
                $stokAkhir = $row->stok_akhir;
            }
            $formula1 += (($row->jumlah_masuk) * ($row->harga_pembelian));
            $formula2 += $row->jumlah_masuk;
        }

        $rata = ($formula1) / ($formula2);
        echo toRupiah($rata).'<BR>';
        echo toRupiah(($rata) * ($stokAkhir));
    }
    // function data(){
    //     $requestData= $_REQUEST;
    //     $sql = "SELECT * FROM tt_gudang_keluar";
    //     $query=$this->Laporanhargajualmodel->rawQuery($sql);
    //     $totalData = $query->num_rows();
    //     $sql = "SELECT
    //             bahan.nama AS nama_bahan, kategori.nama AS nama_kategori,
    //             SUM(gk.harga_penjualan / gudang.jumlah_keluar) / COUNT(*) AS total
    //             FROM m_bahan bahan, tt_gudang_keluar gk, m_bahan_kategori kategori, tt_gudang gudang
    //             WHERE gudang.id_bahan = bahan.id AND bahan.id_kategori_bahan = kategori.id
    //             AND gudang.id_gudang = gk.id";
    //     if( !empty($requestData['search']['value']) ) {
    //         $sql.=" AND ( bahan.nama LIKE '%".$requestData['search']['value']."%' )";
    //         // $sql.=" OR m_bahan.nama LIKE '%".$requestData['search']['value']."%' )";
    //     }
    //     $sql .= " GROUP BY gk.id_bahan";
    //     $query=$this->Laporanhargajualmodel->rawQuery($sql);
    //     $totalFiltered = $query->num_rows();

    //     $sql .= " ORDER BY gk.date_added DESC";
    //     $query=$this->Laporanhargajualmodel->rawQuery($sql);

    //     $data = array(); $i=0;
    //     foreach ($query->result_array() as $row) {
    //         $nestedData     =   array();
    //         $nestedData[]   =   "<span class='text-center' style='display:block;'>".($i+1)."</span>";
    //         $nestedData[]   =   $row["nama_bahan"];
    //         $nestedData[]   =   $row["nama_kategori"];
    //         $nestedData[]   =   toRupiah($row['total']);

    //         $data[] = $nestedData; $i++;
    //     }
    //     $totalData = count($data);
    //     $json_data = array(
    //                 "draw"            => intval( $requestData['draw'] ),
    //                 "recordsTotal"    => intval( $totalData ),
    //                 "recordsFiltered" => intval( $totalFiltered ),
    //                 "data"            => $data
    //                 );
    //     echo json_encode($json_data);
    // }
  }
