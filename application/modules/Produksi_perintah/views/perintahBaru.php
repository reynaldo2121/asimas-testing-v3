<style>
  #tabelDataBahanBaku tr>td, #tabelDataBahanKemas tr>td {
    vertical-align: middle;
  }
</style>
<div class="container" style="margin-top:10px;margin-bottom:20px;">
  <h2>Dokumen Baru</h2>
  <form class="form-horizontal" action="#" method="post" name="formPerintahProduksi" id="formPerintahProduksi">
    <?php if($session_detail->id == 9): ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <!-- <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">No. Dokumen</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" required>
          </div>
        </div> -->
        <input type="hidden" name="no_dokumen" id="no_dokumen" value="FRM-PPIC/02">
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Kode Produksi</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="kode_produksi" id="kode_produksi" required/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Revisi Ke</label>
          </div>
          <div class="col-sm-9">
            <!-- <label for="" class="control-label">1</label> -->
            <input type="number" min="0" name="revisi" class="form-control" value="0">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Tanggal Efektif</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="tanggal_efektif" id="tanggal_efektif" value="<?= date('d.m.Y', strtotime('07.09.2017')) ?>" readonly>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <div class="panel panel-default">
      <div class="panel-body">
        <?php if($session_detail->id == 9): ?>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Nama Produk</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Kode Nama Produk</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="alias" id="alias" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-3">
            <label for="" class="control-label">Besar Batch</label>
          </div>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="besar_batch" id="besar_batch" required>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if($session_detail->id == 9): ?>
    <div class="">
      <button class="btn btn-warning" onclick="showBahanBaku()" type="button"><i class="fa fa-plus"></i> Tambah Bahan Baku</button>
      <button class="btn btn-warning" onclick="showBahanKemas()" type="button"><i class="fa fa-plus"></i> Tambah Bahan Kemas</button>
    </div>

    <br>
    <div class="tambahan-bahan-baku">
      <h4>Bahan Baku:</h4>
      <table class="table" id="tabelDataBahanBaku">
        <td class="labelNoData text-center">Belum ada data</td>
      </table>

    </div>
    <div class="tambahan-bahan-kemas">
      <h4>Bahan Kemas:</h4>
      <table class="table" id="tabelDataBahanKemas">
        <td class="labelNoData text-center">Belum ada data</td>
      </table>
    </div>
    <?php endif; ?>

    <div class="panel panel-default">
      <div class="panel-body text-right">
        <a href="Produksi_perintah-master-index" class="btn btn-default">Kembali</a>
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
          <input type="hidden" id="numBahanBaku" value="0">
          <input type="hidden" id="indexBahanBaku" value="">
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Nama Bahan</label>
            </div>
            <div class="col-sm-9">
              <select name="bahan" class="form-control" id="bahan"="" required="">
                <option value="" disabled selected>--Pilih Bahan--</option>
                <?php foreach($bahan_baku as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama_bahan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <!-- <div class="form-group">
            <div class="col-sm-3">
              <label for="">Per Kaplet</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="per_kaplet" id="per_kaplet">
            </div>
          </div> -->
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Nama Bentuk Persediaan</label>
            </div>
            <div class="col-sm-9">
              <select name="paket" class="form-control" id="paket" onchange="showJumlahPaket(this.value)" required="">
                <option value="" disabled selected>--Pilih Bentuk Persediaan--</option>
                <?php foreach($list_paket as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group" id="kolomPaket">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Jumlah</label>
            </div>
            <div class="col-sm-9">
              <input type="number" min="0" step="0.001" onkeydown="javascript:return event.keyCode !== 69;" class="form-control" name="jumlah_paket" id="jumlah_paket">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_kaplet" class="form-control" id="satuan_kaplet"="" required="">
                <option value="" disabled selected>--Pilih Satuan--</option>
                <?php foreach($list_satuan as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Per Batch</label>
            </div>
            <div class="col-sm-9">
              <input type="number" min="0" step="0.001" onkeydown="javascript:return event.keyCode !== 69;" class="form-control" name="per_batch" id="per_batch">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_batch" class="form-control" id="satuan_batch"="" required="">
                <option value="" disabled selected>--Pilih Satuan--</option>
                <?php foreach($list_satuan as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Jumlah Lot</label>
            </div>
            <div class="col-sm-9">
              <input type="number" min="0" max="10" onkeydown="javascript:return event.keyCode !== 69;" class="form-control" name="jumlah_lot" id="jumlah_lot">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Jumlah per Lot</label>
            </div>
            <div class="col-sm-9">
              <input type="number" min="0" step="0.001" onkeydown="javascript:return event.keyCode !== 69;" class="form-control" name="jumlah_perlot" id="jumlah_perlot">
            </div>
          </div>
        </div>
        <div class="modal-footer text-right">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button class="btn btn-default" data-dismiss="modal">Close</button>
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
          <input type="hidden" id="numBahanKemas" value="0">
          <input type="hidden" id="indexBahanKemas" value="">
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Nama Bahan</label>
            </div>
            <div class="col-sm-9">
              <select name="bahan_kemas" class="form-control" id="bahan_kemas"="" required="">
                <option value="" disabled selected>--Pilih Bahan--</option>
                <?php foreach($bahan_kemas as $row): ?>
                <option value="<?= $row->id ?>"><?= $row->nama_bahan ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Jumlah</label>
            </div>
            <div class="col-sm-9">
              <input type="number" min="0" step="0.001" onkeydown="javascript:return event.keyCode !== 69;" class="form-control" name="jumlah_kemas" id="jumlah_kemas"="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3">
              <label class="control-label text-left" for="">Satuan</label>
            </div>
            <div class="col-sm-9">
              <select name="satuan_kemas" class="form-control" id="satuan_kemas"="" required="">
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
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.tutup Modal-->
<script type="text/javascript">
var list_satuan = <?php echo json_encode($list_satuan); ?>;
var list_bahan = <?php echo json_encode($list_bahan); ?>;
$("#kolomPaket").hide();

function showBahanBaku(data='') {
  if(data) {
    //Untuk edit bahan baku
    $('#formBahanBaku #numBahanBaku').val(data.num);
    $('#formBahanBaku [name="bahan"]').val(data.id_bahan);
    $('#formBahanBaku [name="paket"]').val(data.id_paket).trigger('change');
    $('#formBahanBaku [name="jumlah_paket"]').val(data.jumlah_paket);
    $('#formBahanBaku [name="satuan_kaplet"]').val(data.satuan_paket);
    $('#formBahanBaku [name="per_batch"]').val(data.per_batch);
    $('#formBahanBaku [name="satuan_batch"]').val(data.satuan_batch);
    $('#formBahanBaku [name="jumlah_lot"]').val(data.jumlah_lot);
    $('#formBahanBaku [name="jumlah_perlot"]').val(data.jumlah_perlot);
    $('#modalBahanBaku').modal('show');
  }
  else {
    //Untuk tambah bahan baku
    $('#numBahanBaku').val(0);
    $('#indexBahanBaku').val('');
    $("#formBahanBaku")[0].reset();
    $('#modalBahanBaku').modal('show');
  }
}
function showBahanKemas(data='') {
  if(data) {
    //Untuk edit bahan kemas
    $('#formBahanKemas #numBahanKemas').val(data.num);
    $('#formBahanKemas [name="bahan_kemas"]').val(data.id_bahan);
    $('#formBahanKemas [name="jumlah_kemas"]').val(data.jumlah);
    $('#formBahanKemas [name="satuan_kemas"]').val(data.satuan);
    $('#modalBahanKemas').modal('show');
  }
  else {
    //Untuk tambah bahan kemas
    $('#numBahanKemas').val(0);
    $('#indexBahanKemas').val('');
    $("#formBahanKemas")[0].reset();
    $('#modalBahanKemas').modal('show');
  }
}
function showJumlahPaket(id){
  $("#kolomPaket").show();
}

var tempBahanBaku = [];
var tempBahanKemas = [];
var numBahanBaku = 1;
var numBahanKemas = 1;
$("#formBahanBaku").on('submit', function(e){
    e.preventDefault();
    var num = ($('#numBahanBaku').val() != 0) ? $('#numBahanBaku').val() : numBahanBaku++;
    var form = $('#formBahanBaku').serializeArray();
    var dataBahan = getMasterById(list_bahan, form[0].value);
    var satuanPaket = getMasterById(list_satuan, form[3].value);
    var satuanBatch = getMasterById(list_satuan, (form[5] ? form[5].value : ''));

    var formDataObject = {
      'num': num,
      'id_bahan': (form[0] ? form[0].value : ''),
      'id_paket': $("#paket option:selected").val(),
      'jumlah_paket': (form[2] ? form[2].value : ''),
      'satuan_paket': satuanPaket.id,
      'per_batch': (form[4] ? form[4].value : ''),
      'satuan_batch': (form[5] ? form[5].value : ''),
      'jumlah_lot': (form[6] ? form[6].value : ''),
      'jumlah_perlot': (form[7] ? form[7].value : '')
    }
    var formDataHtml = "<tr id='bahanbaku"+num+"'><td>"
        + dataBahan.nama +"</td>"
        +"<td>"+ $("#paket option:selected").text() +": "+form[2].value+''+satuanPaket.nama+"</td>"
        +"<td>Per Batch: "+form[4].value+''+satuanBatch.nama+"</td>"
        +"<td>Jumlah Lot: "+form[6].value+"</td>"
        +"<td>Per Lot: "+form[7].value+"</td>"
        +"<td>"
          +"<div class='btn-group'>"
            +"<span onclick='editBahanBaku("+num+")' class='btn btn-sm btn-default' title='Edit data'><i class='fa fa-pencil'></i></span>"
            +"<span onclick='deleteBahanBaku("+num+")' class='btn btn-sm btn-default' title='Hapus data'><i class='fa fa-times'></i></span>"
          +"</div>"
        +"</td></tr>";
    
    if($('#numBahanBaku').val() != 0) {
      //Submit edit data
      var index = $('#indexBahanBaku').val();
      tempBahanBaku[index] = formDataObject;
      $("#bahanbaku"+num).replaceWith(formDataHtml);
      $("#formBahanBaku")[0].reset();
      $("#kolomPaket").hide();
      $('#modalBahanBaku').modal('hide');
    }
    else {
      //Submit tambah data
      tempBahanBaku.push(formDataObject);
      $("#tabelDataBahanBaku .labelNoData").hide();
      $("#tabelDataBahanBaku").append(formDataHtml);
      $("#formBahanBaku")[0].reset();
      $("#kolomPaket").hide();
    }
});

$("#formBahanKemas").on('submit', function(e){
    e.preventDefault();
    var num = ($('#numBahanKemas').val() != 0) ? $('#numBahanKemas').val() : numBahanKemas++;
    var form = $('#formBahanKemas').serializeArray();
    var dataBahan = getMasterById(list_bahan, form[0].value);
    var satuanKemas = getMasterById(list_satuan, form[2].value);

    var formDataObject = {
      'num': num,
      'id_bahan': (form[0] ? form[0].value : ''),
      'jumlah': (form[1] ? form[1].value : ''),
      'satuan': (form[2] ? form[2].value : '')
    }
    var formDataHtml = "<tr id='bahankemas"+num+"'>"
        +"<td>"+ dataBahan.nama +"</td><td>Jumlah: "+form[1].value+''+satuanKemas.nama+"</td>"
        +"<td>"
          +"<div class='btn-group'>"
            +"<span onclick='editBahanKemas("+num+")' class='btn btn-sm btn-default' title='Edit data'><i class='fa fa-pencil'></i></span>"
            +"<span onclick='deleteBahanKemas("+num+")' class='btn btn-sm btn-default' title='Hapus data'><i class='fa fa-times'></i></span>"
          +"</div>"
        +"</td></tr>";

    if($('#numBahanKemas').val() != 0) {
      //Submit edit data
      var index = $('#indexBahanKemas').val();
      tempBahanKemas[index] = formDataObject;
      $("#bahankemas"+num).replaceWith(formDataHtml);
      $("#formBahanKemas")[0].reset();
      $('#modalBahanKemas').modal('hide');
    }
    else {
      //Submit tambah data
      tempBahanKemas.push(formDataObject);
      $("#tabelDataBahanKemas .labelNoData").hide();
      $("#tabelDataBahanKemas").append(formDataHtml);
      $("#formBahanKemas")[0].reset();
    }
});

function editBahanBaku(n){
  data = tempBahanBaku.filter(function(index) {return index.num == n})[0];
  var index = tempBahanBaku.indexOf(data);
  if(data != undefined) {
    $('#indexBahanBaku').val(index);
    showBahanBaku(data);
  }
  else {
    $('#numBahanBaku').val(0);
    $('#indexBahanBaku').val('');
    alert('Data bahan baku tidak ditemukan!');
  }
}
function deleteBahanBaku(n){
  data = tempBahanBaku.filter(function(index) {return index.num == n})[0];
  var index = tempBahanBaku.indexOf(data);
  tempBahanBaku.splice(index, 1);
  $("#bahanbaku"+n).remove();
  if($('#tabelDataBahanBaku tr[id^="bahanbaku"]').length == 0) {
    $('#tabelDataBahanBaku .labelNoData').show();
  }
}

function editBahanKemas(n){
  data = tempBahanKemas.filter(function(index) {return index.num == n})[0];
  var index = tempBahanKemas.indexOf(data);
  if(data != undefined) {
    $('#indexBahanKemas').val(index);
    showBahanKemas(data);
  }
  else {
    $('#numBahanKemas').val(0);
    $('#indexBahanKemas').val('');
    alert('Data bahan kemas tidak ditemukan!');
  }
}
function deleteBahanKemas(n){
  data = tempBahanKemas.filter(function(index) {return index.num == n})[0];
  var index = tempBahanKemas.indexOf(data);
  tempBahanKemas.splice(index, 1);
  $("#bahankemas"+n).remove();
  if($('#tabelDataBahanKemas tr[id^="bahankemas"]').siblings().length == 0) {
    $('#tabelDataBahanKemas .labelNoData').show();
  }
}

$("#formPerintahProduksi").on('submit', function(e){
  e.preventDefault();
  var form = $("#formPerintahProduksi").serialize();
  var action = "<?php echo base_url('Produksi_perintah/Master/addData')?>/";
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
        // console.log(data);
        $("#formPerintahProduksi")[0].reset();
        $("#btnSubmit").prop("disabled", false);
        $('#btnSubmit').html('Submit Data');
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
