<!-- Page Content -->
<div class="container">
<div class="row" style='min-height:80px;'>
  <div id='notif-top' style="margin-top:50px;display:none;" class="col-md-4 alert alert-success pull-right">
    <strong>Sukses!</strong> Data berhasil disimpan
  </div>
</div>
  <div class="row">
    <h3><strong>Laporan</strong> - Stok Gudang</h3>
  </div>
   <div class="row" style="margin-top:10px;">
      <table id="TableMainServer" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="text-center no-sort">#</th>
                  <th class="text-center">Nama Bahan</th>
                  <th class="text-center">Satuan</th>
                  <th class="text-center">Stok Awal</th>
                  <th class="text-center">Masuk</th>
                  <th class="text-center">Keluar</th>
                  <th class="text-center">Stok Akhir</th>
                  <th class="text-center">Keluar PP</th>
                  <th class="text-center">Expired Date</th>
              </tr>
          </thead>

          <tbody id='bodytable'>
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg" onclick="gotoCetak()">
     Cetak Laporan
   </button>
</div>
<!-- /.container -->


<script type="text/javascript">
function gotoCetak(){
  window.open("<?php echo base_url()?>index/modul/Laporan_stok_gudang-master-cetak", "_blank");
  // location.href="Laporan_stok_gudang-master-cetak";
}
var initDataTable = $('#TableMainServer').DataTable({
    "bProcessing": true,
    "bServerSide": true,
    // "order": [[3, 'DESC']],
    "ajax":{
          url :"<?php echo base_url()?>Laporan_stok_gudang/Master/data",
          type: "post",  // type of method  , by default would be get
          error: function(e){  // error handling code
            console.log(e);
            // $("#employee_grid_processing").css("display","none");
          }
        },
    "columnDefs": [ {
      "targets"  : 'no-sort',
      "orderable": false,
    }]
  });
</script>
