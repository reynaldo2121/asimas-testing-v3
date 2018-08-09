<!-- Page Content -->
<div class="container">
<div class="row" style='min-height:80px;'>
  <div id='notif-top' style="margin-top:50px;display:none;" class="col-md-4 alert alert-success pull-right">
    <strong>Sukses!</strong> Data berhasil disimpan
  </div>
</div>
  <div class="row">
    <h3><strong>Laporan</strong> - Rata-rata Harga Pembelian Barang</h3>
  </div>
   <div class="row" style="margin-top:10px;">
      <table id="TableMainServer" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="text-center no-sort">#</th>
                  <th class="text-center">Nama Bahan</th>
                  <!-- <th class="text-center">Kategori</th> -->
                  <th class="text-center">Stok Awal</th>
                  <th class="text-center">Masuk</th>
                  <th class="text-center">Keluar</th>
                  <th class="text-center">Stok Akhir</th>
                  <th class="text-center">Harga Per Item</th>
                  <th class="text-center">Rata-rata Harga</th>
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
   <button type="button" class="btn btn-add btn-lg" onclick="exportLaporan()" title="N.b.: Pilih 'All' terlebih dahulu pada tabel untuk mengekspor semua data">
     Export Laporan
   </button>
</div>
<!-- /.container -->


<script type="text/javascript">
function gotoCetak(){
  window.open("<?php echo base_url()?>index/modul/Laporan_harga_jual-master-cetak", "_blank");
  // location.href="Laporan_harga_jual-master-cetak";
}
function exportLaporan() {
  initDataTable.button(0).trigger();
}
var initDataTable = $('#TableMainServer').DataTable({
    /*"dom":  "<'row'<'col-sm-12 text-right'B>>"
            +"<'row'<'col-sm-6'l><'col-sm-6 text-center'f>>"
            + "<'row'<'col-sm-12'rt>>" 
            + "<'row'<'col-sm-5'i><'col-sm-7'p>>",*/
    "buttons": ['excel'],
    "lengthMenu": [
      [ 10, 25, 50, -1 ],
      [ '10', '25', '50', 'All' ]
    ],
    "bProcessing": true,
    "bServerSide": true,
    "ajax":{
          url :"<?php echo base_url()?>Laporan_harga_jual/Master/data",
          type: "post",  // type of method  , by default would be get
          error: function(e){  // error handling code
            console.log(e);
            // $("#employee_grid_processing").css("display","none");
          }
        },
    "columnDefs": [ {
      "targets"  : 'no-sort',
      "orderable": false,
    }],
    "order": [[ 1, 'ASC' ]]
  });
</script>
