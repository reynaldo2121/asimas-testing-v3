<div class="container">
  <div class="col-sm-12 text-right">
    <button class="btn btn-default" title="Cetak Halaman" onclick="window.print();"><i class="fa fa-print"></i> Cetak</button>
  </div>
</div>
<div id="printSection" class="print-container">
  <table class="header">
    <tr>
      <td class="logo"><img src="<?php echo base_url(); ?>/assets/img/logo-asimas.png" alt="Logo"></td>
      <td class="kop">
        <?php
          $tanggal_kop = 'Date not set';
          if($_GET['tipe']) {
            if($_GET['tipe'] == 'harian') { 
              $tanggal_kop = date('d/m/Y'); }
            else if($_GET['tipe'] == 'harian') { 
              $tanggal_kop = date('d/m/Y'); }
            else if($_GET['tipe'] == 'mingguan') { 
              $tanggal_kop = 'Minggu ke-'.date('W o'); }
            else if($_GET['tipe'] == 'bulanan') { 
              $tanggal_kop = date('F Y'); }
            else if($_GET['tipe'] == 'custom') { 
              $tanggal_kop = date('d/m/Y', strtotime($_GET['start'])).' - '.date('d/m/Y', strtotime($_GET['end'])); }
          }
        ?>
        <h1>PT. AGARICUS SIDO MAKMUR SENTOSA</h1>
        <h3>Laporan Transaksi Gudang: <?php echo $tanggal_kop?></h3>
      </td>
    </tr>
  </table>


  <table class="regular">
    <thead>
      <tr>
        <th class="nomer">No.</th>
        <th class="nomer">No.Transaksi</th>
        <th class="text-center">Nama Bahan</th>
        <th class="text-center">Kode Bahan</th>
        <th class="text-center">Satuan</th>
        <th class="text-center">Stok Awal</th>
        <th class="text-center">Masuk</th>
        <th class="text-center">Keluar</th>
        <th class="text-center">Stok Akhir</th>
        <th class="text-center">Batch</th>
        <th class="text-center">Expire Date</th>
        <th class="text-center">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php if($list) { 
        $no = 1;
        foreach ($list as $row) { ?>
        <tr>
          <td class="text-center"><?php echo $no ?></td>
          <td class="text-center"><?php echo $row->no_transaksi ?></td>
          <td class="text-center"><?php echo $row->nama_bahan ?></td>
          <td class="text-center"><?php echo $row->kode_bahan ?></td>
          <td class="text-center"><?php echo $row->nama_satuan ?></td>
          <td class="text-center"><?php echo $row->stok_awal ?></td>
          <td class="text-center"><?php echo $row->jumlah_masuk ?></td>
          <td class="text-center"><?php echo $row->jumlah_keluar ?></td>
          <td class="text-center"><?php echo $row->stok_akhir ?></td>
          <td class="text-center"><?php echo $row->no_batch ?></td>
          <td class="text-center"><?php echo date('d-m-Y', strtotime($row->expired_date)) ?></td>
          <td class="text-center"><?php echo ($row->type == 1) ? 'Gudang Masuk' : 'Gudang Keluar' ?></td>
      </tr>
        <?php $no++; 
        }
      } 
      else { ?>
        <tr>
          <td colspan="12" class="text-center">Tidak ada data</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>


</div> <!-- tutup container -->

<style>
.print-container{
  margin: 10px auto;
  color: #000;
  width: 210mm;
}
.header{
  margin-bottom: 60px;
  border-bottom:2px solid #000;
}
.logo{
  /* text-align: right; */
  width: 70px;
}
.logo img{
  width: 60px;
  /* margin-right: 10px; */
}
.kop h1{
  margin-bottom: 0;
  font-size: 24px;
}
.kop h3{
  margin-top: 0;
  font-size: 18px;
}
table{
  width: 100%;
}

.regular{
  margin-bottom: 50px;
}
.regular tr td,
.regular tr th{
  border: 1px solid #000;
  padding: 15px 10px;
}
.nomer{
  width: 60px;
}
.regular th{
  font-weight: bold;
  background-color: #9E9E9E;
  color: #fff;
  text-align: center;
}

.text-left {
  text-align: left;
}
.text-right {
  text-align: right;
}
.text-center {
  text-align: center;
}
</style>

<style>
@page {
  /* width = 21cm (potrait)*/
  /* width = 29.7cm (landscape) */
  size: A4 landscape;
  margin: 0 1.5cm 1cm;

}



@media print {

  body {
    font: 12pt Georgia, "Times New Roman", Times, serif;
    line-height: 1.5;
    padding-top: 0px;
  }
  table.header {
    margin-bottom: 30px;
  }
  table.regular td{
    padding: 10px!important;
    /* line-height: 1.5; */
  }

  table{
    width: 26.7cm;
  }
}
</style>

<script>
  $('.navbar.navbar-default').hide();
  $(document).ready(function() {
    window.print();
  });
</script>
