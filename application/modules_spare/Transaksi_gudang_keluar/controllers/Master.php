<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MX_Controller {
    private $modul = "Transaksi_gudang_keluar/";
    private $fungsi = "";
	function __construct() {
        parent::__construct();
        $this->load->model('Transaksigudangkeluarmodel');
        $this->modul .= $this->router->fetch_class();
        $this->fungsi = $this->router->fetch_method();
        $this->_insertLog();
        $this->session_detail = pegawaiLevel($this->session->userdata('id_user_level'));
    }
    function _insertLog($fungsi = null){
        $id_user = $this->session->userdata('id_user');
        $dataInsert['id_user'] = $id_user;
        $dataInsert['modul'] = $this->modul;
        $dataInsert['fungsi'] = $this->fungsi;
        $insertLog = $this->Transaksigudangkeluarmodel->insert($dataInsert, 't_log');
    }
    function index(){
        $dataCondition['deleted'] = 1;
        $data['list_data'] = $this->Transaksigudangkeluarmodel->select('', 'tt_gudang_keluar')->result();
        $data['list_bahan'] = $this->Transaksigudangkeluarmodel->select($dataCondition, 'm_bahan')->result();
        $data['list_satuan'] = $this->Transaksigudangkeluarmodel->select($dataCondition, 'm_satuan')->result();
        $data['list_batch'] = $this->Transaksigudangkeluarmodel->get('tt_gudang_masuk')->result();
        $data['list_distributor'] = $this->Transaksigudangkeluarmodel->select($dataCondition, 'm_distributor')->result();
    	$this->load->view('Transaksi_gudang_keluar/view', $data);
    }
    function data(){
        $requestData= $_REQUEST;
        $sql = "SELECT * FROM tt_gudang_keluar";
        $query=$this->Transaksigudangkeluarmodel->rawQuery($sql);
        $totalData = $query->num_rows();
        $sql = "SELECT ";
        // $sql.=" FROM tt_gudang_keluar WHERE deleted = 1";
        $sql.=  "gk.id,
                gk.no_transaksi,
                bahan.nama AS nama_bahan,
                bahan.kode_bahan,
                distributor.nama AS nama_distributor,
                gk.no_batch,
                gudang.jumlah_keluar,
                gk.tanggal_keluar,
                gk.expired_date,
                gk.keterangan,
                gk.date_added,
                gk.harga_penjualan,
                satuan.nama AS nama_satuan
                FROM tt_gudang_keluar gk, m_bahan bahan, m_distributor distributor, m_satuan satuan, tt_gudang gudang
                WHERE gk.id_bahan = bahan.id
                AND gudang.id_gudang = gk.id
                AND bahan.id_satuan = satuan.id
                AND gk.id_distributor = distributor.id";
        if( !empty($requestData['search']['value']) ) {
            $sql.=" AND ( gk.no_transaksi LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR gk.no_batch LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR bahan.nama LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR satuan.nama LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR distributor.nama LIKE '%".$requestData['search']['value']."%' )";
        }
        $query=$this->Transaksigudangkeluarmodel->rawQuery($sql);
        $totalFiltered = $query->num_rows();

        $sql .= " ORDER BY gk.date_added DESC";
        $query=$this->Transaksigudangkeluarmodel->rawQuery($sql);

        $data = array(); $i=0;
        foreach ($query->result_array() as $row) {
            $nestedData     =   array();
            $nestedData[]   =   $row["no_transaksi"];
            $nestedData[]   =   date('d/m/Y', strtotime($row["tanggal_keluar"]));
            $nestedData[]   =   $row["nama_bahan"];
            $nestedData[]   =   $row["nama_satuan"];
            $nestedData[]   =   $row["jumlah_keluar"];
            $nestedData[]   =   $row["no_batch"];
            $nestedData[]   =   date('d/m/Y', strtotime($row["expired_date"]));
            $nestedData[]   =   $row["kode_bahan"];
            $nestedData[]   =   $row["nama_distributor"];
            $nestedData[]   =   $row["keterangan"];
            if($this->session_detail->id == 7 || $this->session_detail->id == 6) {
            $nestedData[]   =   toRupiah($row['harga_penjualan']);
            }
            if($this->session_detail->id == 6) {
            $action        =    '<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" onclick="addHarga('.$row["id"].')"><i class="fa fa-pencil"></i></a>';
            } else{
            $action = '<td class="text-center"><div class="btn-group">'
                .'<a id="group'.$row["id"].'" class="divpopover btn btn-sm btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="top" onclick="confirmDelete(this)" data-html="true" title="Hapus Data?" ><i class="fa fa-times"></i></a>'
                // .'<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" onclick="showUpdate('.$row["id"].')"><i class="fa fa-pencil"></i></a>'
               .'</div>'
            .'</td>';
            }
            $nestedData[]   .=  $action;

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
    function add(){
        $params = $this->input->post();
        // Custom
        $explodeTanggal = explode("/", $params['tanggal_keluar']);
        $explodeKadaluarsa = explode("/", $params['expired_date']);
        // Condition
        $condition['no_transaksi'] = $params['no_transaksi'];
        // Data Insert
        $dataInsert['no_transaksi'] = $params['no_transaksi'];
        $dataInsert['id_bahan'] = $params['id_bahan'];
        $dataInsert['id_distributor'] = $params['id_distributor'];
        $dataInsert['no_batch'] = $params['no_batch'];
        // $dataInsert['stok_akhir']           = $bahan->num_rows() > 0 ? 
        //              ($params['jumlah_masuk']) + ($rowBahan->stok_akhir) : $params['jumlah_masuk'];
        // $dataInsert['jumlah_keluar'] = $params['jumlah_keluar'];
        $dataInsert['tanggal_keluar'] = $explodeTanggal[2].'-'.$explodeTanggal[1].'-'.$explodeTanggal[0];
        $dataInsert['expired_date'] = $explodeKadaluarsa[2].'-'.$explodeKadaluarsa[1].'-'.$explodeKadaluarsa[0];
        $dataInsert['keterangan'] = $params['keterangan'];
        $dataInsert['added_by']           = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;;
        $dataInsert['date_added']         = date('Y-m-d H:i:s');
        $dataInsert['edited_by']        = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;;
        $dataInsert['last_edited']      = date('Y-m-d H:i:s');

        $checkData = $this->Transaksigudangkeluarmodel->select($condition, 'tt_gudang_keluar');
        if($checkData->num_rows() < 1){
            $insert = $this->Transaksigudangkeluarmodel->insert_id($dataInsert, 'tt_gudang_keluar');
            if($insert){
              // Insert to tt_gudang
              $sql = "SELECT * FROM tt_gudang WHERE id_bahan = ".$params['id_bahan']." ORDER BY date_add DESC LIMIT 1";
              $bahan = $this->Transaksigudangkeluarmodel->rawQuery($sql);
              $rowBahan = $bahan->num_rows() > 0 ? $bahan->row() : null;
              $insertStok['id_gudang'] = $insert;
              $insertStok['type'] = 2;
              $insertStok['id_bahan'] = $params['id_bahan'];
              $insertStok['stok_awal'] = $bahan->num_rows() > 0 ?
                $rowBahan->stok_akhir : 0;
              $insertStok['stok_akhir'] = $bahan->num_rows() > 0 ? 
                ($rowBahan->stok_akhir) - ($params['jumlah_keluar']) : $params['jumlah_keluar'];
              $insertStok['jumlah_masuk'] = 0;
              $insertStok['jumlah_keluar'] = $params['jumlah_keluar'];
              $this->Transaksigudangkeluarmodel->insert($insertStok, 'tt_gudang');
              // Insert to tt_gudang
              
              // Update tt_bahan
              $dataCondition['id_bahan'] = $params['id_bahan'];
              $sql = "SELECT jumlah_keluar FROM tt_bahan WHERE id_bahan = ".$params['id_bahan'];
              $row = $this->Transaksigudangkeluarmodel->rawQuery($sql)->row();
              $dataUpdate['jumlah_keluar'] = ($row->jumlah_keluar) + ($params['jumlah_keluar']);
              $this->Transaksigudangkeluarmodel->update($dataCondition, $dataUpdate, 'tt_bahan');
              // Update tt_bahan
              echo json_encode(array('status' => 3));
            }else{
                echo json_encode(array('status' => 2));
            }

        }else{
            echo json_encode(array( 'status'=> 1, 'message' => 'No Transaksi sudah ada!'));
        }
    }
    function edit(){
         $params = $this->input->post();
        // Custom
        $explodeTanggal = explode("/", $params['tanggal_keluar']);
        $explodeKadaluarsa = explode("/", $params['expired_date']);
        // Condition
        $condition['id'] = $params['id'];
        // Data Insert
        $dataUpdate['id_bahan'] = $params['id_bahan'];
        $dataUpdate['id_satuan'] = $params['id_satuan'];
        $dataUpdate['id_distributor'] = $params['id_distributor'];
        $dataUpdate['no_batch'] = $params['no_batch'];
        $dataUpdate['harga_penjualan'] = $params['harga_jual'];
        $dataUpdate['jumlah_keluar'] = $params['jumlah_keluar'];
        $dataUpdate['tanggal_keluar'] = $explodeTanggal[2].'-'.$explodeTanggal[1].'-'.$explodeTanggal[0];
        $dataUpdate['expired_date'] = $explodeKadaluarsa[2].'-'.$explodeKadaluarsa[1].'-'.$explodeKadaluarsa[0];
        $dataUpdate['keterangan'] = $params['keterangan'];
        $dataUpdate['edited_by']        = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;;
        $dataUpdate['last_edited']      = date('Y-m-d H:i:s');

        $checkData = $this->Transaksigudangkeluarmodel->select($condition, 'tt_gudang_keluar');
        if($checkData->num_rows() > 0){
            $update = $this->Transaksigudangkeluarmodel->update($condition, $dataUpdate, 'tt_gudang_keluar');
            if($update){
                $list = $this->Transaksigudangkeluarmodel->select('', 'tt_gudang_keluar', 'date_add', 'DESC');
                echo json_encode(array('status' => 3,'list' => $list));
            }else{
                echo json_encode(array('status' => 2));
            }

        }else{
            echo json_encode(array( 'status'=> 1, 'message' => 'No Transaksi sudah ada!'));
        }

    }
    function addHarga(){
      $params = $this->input->post();
      if(!$params) redirect();
      $dataCondition['id'] = $params['id'];

      $checkData = $this->Transaksigudangkeluarmodel->select($dataCondition, 'tt_gudang_keluar');
      if($checkData->num_rows() > 0) {
        $dataUpdate['harga_penjualan'] = $params['harga'];
        $update = $this->Transaksigudangkeluarmodel->update($dataCondition, $dataUpdate, 'tt_gudang_keluar');
        if($update) {
          $sql = "SELECT
                gk.id,
                gk.no_transaksi,
                bahan.nama AS nama_bahan,
                bahan.kode_bahan,
                distributor.nama AS nama_distributor,
                gk.no_batch,
                gudang.jumlah_keluar,
                gk.tanggal_keluar,
                gk.expired_date,
                gk.keterangan,
                gk.date_added,
                satuan.nama AS nama_satuan
                FROM tt_gudang_keluar gk, m_bahan bahan, m_distributor distributor, m_satuan satuan, tt_gudang gudang
                WHERE gk.id_bahan = bahan.id
                AND gudang.id_gudang = gk.id
                AND bahan.id_satuan = satuan.id
                AND gk.id_distributor = distributor.id";
          $list = $this->Transaksigudangkeluarmodel->rawQuery($sql)->result();
          echo json_encode(array('status' => '3','message' => 'Berhasil mengubah data!' , 'list' => $list));
        } else {
          echo json_encode(array( 'status'=>'2', 'message' => 'Something Error!' ));          
        }
      } else {
        echo json_encode(array( 'status'=>'1', 'message' => 'Data Transaksi Gudang Masuk Tidak ditemukan!'));
      }
    }
    function delete(){
        $id = $this->input->post("id");
        if($id != null){
            $dataCondition['id'] = $id;
            $delete = $this->Transaksigudangkeluarmodel->delete($dataCondition, 'tt_gudang_keluar');
            if($delete){
                $list = $this->Transaksigudangkeluarmodel->select('', 'tt_gudang_keluar', 'date_added', 'DESC');
                echo json_encode(array('status' => '3','list' => $list));
            }else{
                echo "1";
            }
        }else{
            echo "0";
        }
    }
    function selectBahan(){
        $postdata = $this->input->post();
        $dataCondition['id_bahan'] = $postdata['id_bahan'];
        // echo $postdata['id_bahan'];
        $sql = $this->Transaksigudangkeluarmodel->select($dataCondition, 'tt_gudang_masuk');
        if($sql->num_rows() > 0 ) {
            $result = ['status' => 3, 'list_batch' => $sql->result()];
        } else {
            $result = ['status' => 1];
        }
        echo json_encode($result);
    }
}
