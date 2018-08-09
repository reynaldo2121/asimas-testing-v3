<div class="container" style="margin-top:10px;margin-bottom:20px;">
  <h2>Ubah Dokumen</h2>
  <form class="form-horizontal" action="<?= base_url() ?>index/modul/Produksi_perintah-master-index" method="post" id="formPerintahProduksi">
    <input type="hidden" name="id" value="<?= base64_url_decode($this->uri->segment(4)) ?>">
    <?php if($session_detail->id == 9): ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <!-- <?php $is_revisi = ($perintah_produksi->revisi != 0 ? "readonly value='".$perintah_produksi->no_dokumen."'" : null); ?>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">No. Dokumen</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" <?= $is_revisi ?> />
          </div>
        </div> -->
        <input type="hidden" name="no_dokumen" id="no_dokumen" value="<?= $perintah_produksi->no_dokumen ?>">
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Revisi Ke</label>
          </div>
          <div class="col-sm-9">
            <label for="" class="control-label"><?= $perintah_produksi->revisi ?></label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Tanggal Efektif</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="tanggal_efektif" id="tanggal_efektif" required value="<?= $perintah_produksi->tanggal_efektif ?>">
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if($session_detail->id == 5): ?>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">No. Perintah Produksi</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="no_pp" id="no_pp" value="<?= $perintah_produksi->no_perintah ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">No. Sales Order</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="no_so" id="no_so" value="<?= $perintah_produksi->no_sales_order ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Estimasi Proses</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="estimasi" id="estimasi" value="<?= $perintah_produksi->estimasi_proses ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Kode Produksi</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="kode_produksi" id="kode_produksi" value="<?= $perintah_produksi->kode_produksi ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Expired Date</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="expired_date" id="expired_date" value="<?= $perintah_produksi->expired_date ?>" required>
          </div>
        </div>
        <?php elseif($session_detail->id == 9): ?>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Nama Produk</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="<?= $perintah_produksi->nama_produk ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Kode Nama Produk</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="alias" id="alias" value="<?= $perintah_produksi->alias ?>" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Besar Batch</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="besar_batch" id="besar_batch" value="<?= $perintah_produksi->besar_batch ?>" />
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if($session_detail->id == 9): ?>
    <div class="">
      <button class="btn btn-warning" onclick="showBahanBaku()" type="button">Tambah Bahan Baku</button>
      <button class="btn btn-warning" onclick="showBahanKemas()" type="button">Tambah Bahan Kemas</button>
    </div>


    <div class="tambahan-bahan-baku">
      <h3>Bahan Baku:</h3>
      <table class="table" id="dataBahanBaku">
      </table>

    </div>
    <div class="tambahan-bahan-kemas">
      <h3>Bahan Kemas:</h3>
      <table class="table" id="dataBahanKemas">
      </table>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
      <div class="panel-body text-right">
        <a href="<?= base_url() ?>index/modul/Produksi_perintah-master-index" class="btn btn-default">Kembali</a>
        <button class="btn btn-success" id="btnSubmit">Submit Data</button>
      </div>
    </div>
  </form>
</div>

<!-- Modal tambah bahan baku -->
<div class="modal fade" id="modalBahanBaku" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Bahan Baku</h4>
      </div>
      <form action="" method="POST" id="formBahanBaku" enctype="multipart/form-data" class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Nama Bahan</label>
            </div>
            <div class="col-sm-9">
              <select name="bahan" class="form-control" id="bahan"="">
                <option value="" disabled selected>--Pilih Bahan--</option>
                <?php foreach($bahan_baku as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama_bahan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Nama Bentuk Persediaan</label>
            </div>
            <div class="col-sm-9">
              <select name="paket" class="form-control" id="paket" onchange="showJumlahPaket(this.value)">
                <option value="" disabled selected>--Pilih Bentuk Persediaan--</option>
                <?php foreach($list_paket as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group" id="kolomPaket">
            <div class="col-sm-3">
              <label for="">Jumlah</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="jumlah_paket" id="jumlah_paket">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_kaplet" class="form-control" id="satuan_kaplet"="">
                <option value="" disabled selected>--Pilih Satuan--</option>
                <?php foreach($list_satuan as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Per Batch</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="per_batch" id="per_batch">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_batch" class="form-control" id="satuan_batch"="">
                <option value="" disabled selected>--Pilih Satuan--</option>
                <?php foreach($list_satuan as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Jumlah Lot</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="jumlah_lot" id="jumlah_lot">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Jumlah per Lot</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="jumlah_perlot" id="jumlah_perlot">
            </div>
          </div>
        </div>
        <div class="modal-footer text-right">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.tutup Modal-->
<!-- Modal tambah bahan kemas -->
<div class="modal fade" id="modalBahanKemas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Bahan Kemas</h4>
      </div>
      <form action="" method="POST" id="formBahanKemas" enctype="multipart/form-data" class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Nama Bahan</label>
            </div>
            <div class="col-sm-9">
              <select name="bahan_kemas" class="form-control" id="bahan_kemas"="">
                <option value="" disabled selected>--Pilih Bahan--</option>
                <?php foreach($bahan_kemas as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama_bahan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Jumlah</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="jumlah_kemas" id="jumlah_kemas"="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_kemas" class="form-control" id="satuan_kemas"="">
                <option value="" disabled selected>--Pilih Satuan--</option>
                <?php foreach($list_satuan as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <!-- <div class="form-group">
            <div class="col-sm-3">
              <label for="">Aktual</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="aktual" id="aktual"="">
            </div>
          </div> -->
        </div>
        <div class="modal-footer text-right">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.tutup Modal-->
<script type="text/javascript">
var list_satuan = <?php echo json_encode($list_satuan); ?>;
var list_bahan = <?php echo json_encode($list_bahan); ?>;
var bahan_baku = <?php echo json_encode($list_bahan_baku); ?>;
var bahan_kemas = <?php echo json_encode($list_bahan_kemas); ?>;
var tempBahanBaku = [];
var tempBahanKemas = [];
var numBahanBaku = 1;
var numBahanKemas = 1;
$(document).ready(function(){
  $("#kolomPaket").hide();
  // Append Bahan Baku ke Table
  if(bahan_baku != null) {
    for(i = 0; i < bahan_baku.length; i++){
      var data = bahan_baku[i];
      var num = numBahanBaku++;
      tempBahanBaku.push({
          'num': num,
          'id_bahan': data.id_bahan,
          'id_paket': data.id_paket,
          'nama_paket': data.nama_paket,
          'jumlah_paket': data.jumlah_paket,
          'satuan_paket' : data.satuan_paket,
          'per_batch': data.per_batch,
          'id_satuan_batch': data.id_satuan_batch,
          'satuan_batch': data.satuan_batch,
          'jumlah_lot': data.jumlah_lot,
          'jumlah_perlot': data.jumlah_perlot
      });

      // 'id_bahan': form[0].value,
      // 'id_paket': $("#paket option:selected").val(),
      // 'jumlah_paket': form[2].value,
      // 'satuan_paket': satuanPaket.id,
      // 'per_batch': form[4].value,
      // 'satuan_batch': form[5].value,
      // 'jumlah_lot': form[6].value,
      // 'jumlah_perlot': form[7].value
       $("#dataBahanBaku")
        .append("<tr id='bahanbaku"+num+"'><td>"+ data.nama_bahan +"</td><td>"+data.nama_paket+": "+data.jumlah_paket+''+data.nama_satuan_paket+"</td><td>Per Batch: "+data.per_batch+''+data.satuan_batch+"</td><td>Per Lot: "+data.jumlah_perlot+"</td><td>Jumlah Lot: "+data.jumlah_lot+"</td><td><span onclick='deleteBahanBaku("+num+")' class='fa fa-times'></span></td></tr>");
    }
  }
  // Append Bahan Kemas ke Table
  if(bahan_kemas != null) {
    for(i = 0; i < bahan_kemas.length; i++){
      var data = bahan_kemas[i];
      var num = numBahanKemas++;
      console.log(data);
      tempBahanKemas.push({
          'num': num,
          'id_bahan': data.id_bahan,
          'jumlah': data.jumlah,
          'satuan': data.id_satuan
      });
       $("#dataBahanKemas")
      .append("<tr id='bahankemas"+num+"'><td>"+ data.nama_bahan +"</td><td>Jumlah: "+data.jumlah+''+data.satuan+"</td><td><span onclick='deleteBahanKemas("+num+")' class='fa fa-times'></span></td></tr>");
    } 
  }
});
function showBahanBaku() {
  $("#formBahanBaku")[0].reset();
  $('#modalBahanBaku').modal('show');
}
function showBahanKemas() {
  $("#formBahanKemas")[0].reset();
  $('#modalBahanKemas').modal('show');
}
function showJumlahPaket(id){
  $("#kolomPaket").show();
}
$("#formBahanBaku").on('submit', function(e){
    e.preventDefault();
    var num = numBahanBaku++;
    var form = $('#formBahanBaku').serializeArray();
    var dataBahan = getMasterById(list_bahan, form[0].value);
    var satuanPaket = getMasterById(list_satuan, form[3].value);
    var satuanBatch = getMasterById(list_satuan, form[5].value);
    tempBahanBaku.push({
        'id_bahan': form[0].value,
        'id_paket': $("#paket option:selected").val(),
        'jumlah_paket': form[2].value,
        'satuan_paket': satuanPaket.id,
        'per_batch': form[4].value,
        'satuan_batch': form[5].value,
        'jumlah_lot': form[6].value,
        'jumlah_perlot': form[7].value
    });
    $("#dataBahanBaku")
    .append("<tr><td>"+ num +"</td><td>"+ dataBahan.nama +"</td><td>"+ $("#Pakett option:selected").text() +": "+form[2].value+''+satuanPaket.nama+"</td><td>Per Batch: "+form[3].value+''+satuanBatch.nama+"</td><td>Per Lot: "+form[6].value+"</td><td>Jumlah Lot: "+form[5].value+"</td><td><span onclick='deleteBahanBaku("+num+")' class='fa fa-times'></span></td></tr>");
    $("#formBahanBaku")[0].reset();
    $("#kolomPaket").hide();
});

$("#formBahanKemas").on('submit', function(e){
    e.preventDefault();
    var num = numBahanKemas++;
    var form = $('#formBahanKemas').serializeArray();
    var dataBahan = getMasterById(list_bahan, form[0].value);
    var satuanKemas = getMasterById(list_satuan, form[2].value);

    tempBahanKemas.push({
        'num': num,
        'id_bahan': form[0].value,
        'jumlah': form[1].value,
        'satuan': form[2].value
    });

    $("#dataBahanKemas")
    .append("<tr id='bahankemas"+num+"'><td>"+ dataBahan.nama +"</td><td>Jumlah: "+form[1].value+''+satuanKemas.nama+"</td><td><span onclick='deleteBahanKemas("+num+")' class='fa fa-times'></span></td></tr>");
    $("#formBahanKemas")[0].reset();
});

function deleteBahanBaku(n){
  data = tempBahanBaku.filter(function(index) {return index.num == n})[0];
  var index = tempBahanBaku.indexOf(data);
  tempBahanBaku.splice(index, 1);
  $("#bahanbaku"+n).remove();
}

function deleteBahanKemas(n){
  data = tempBahanKemas.filter(function(index) {return index.num == n})[0];
  var index = tempBahanKemas.indexOf(data);
  tempBahanKemas.splice(index, 1);
  $("#bahankemas"+n).remove();
}

$("#formPerintahProduksi").on('submit', function(e){
  e.preventDefault();
  console.log(JSON.stringify(tempBahanBaku));
  var form = $("#formPerintahProduksi").serialize();
  var action = "<?php echo base_url('Produksi_perintah/Master/editData')?>/";
  $.ajax({
      url: action,
      type: 'post',
      data: form+"&bahan_baku="+JSON.stringify(tempBahanBaku)+"&bahan_kemas="+JSON.stringify(tempBahanKemas),
      dataType: 'json',
      beforeSend: function() {
        $("#btnSubmit").prop("disabled", true);
        $('#btnSubmit').html('Sedang Menyimpan...');
      },
      error: function(e) {
        console.log(e);
      },
      success: function (data) {
        // New Field Value
        $list = data.list;
        // R&D
        $("#tanggal_efektif").attr('value', $list.tanggal_efektif);
        $("#nama_produk").attr('value', $list.nama_produk);
        $("#alias").attr('value', $list.alias);
        $("#besar_batch").attr('value', $list.besar_batch);
        // PPIC
        $("#no_pp").attr('value', $list.no_pp);
        $("#no_so").attr('value', $list.no_so);
        $("#estimasi").attr('value', $list.estimasi);
        $("#kode_produksi").attr('value', $list.kode_produksi);
        $("#expired_date").attr('value', $list.expired_date);
        // Clear Field
        // numBahanBaku = 1;
        // numBahanKemas = 1;
        // tempBahanBaku = [];
        // tempBahanKemas = [];
        // $("#dataBahanBaku").html('');
        // $("#dataBahanKemas").html('');
        $("#formPerintahProduksi")[0].reset();
        $("#btnSubmit").prop("disabled", false);
        $('#btnSubmit') .html('Submit Data');
        new PNotify({
          title: data.status ? 'Sukses' : 'Gagal',
          text: data.message,
          type: data.status ? 'success' : 'error',
          hide: true,
          delay: 3000,
          styling: 'bootstrap3'
        });
      }
    });
});

function getMasterById(jsonData, id){
  data = jsonData.filter(function(index) {return index.id == id});
  return data.length > 0 ? data[0] : false;
}
</script>
