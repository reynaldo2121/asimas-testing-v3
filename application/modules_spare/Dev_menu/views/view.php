<!-- Page Content -->
<div class="container">
<div class="row" style='min-height:80px;'>
  <div id='notif-top' style="margin-top:50px;display:none;" class="col-md-4 alert alert-success pull-right">
    <strong>Sukses!</strong> Data berhasil disimpan
  </div>
</div>
  <div class="row">
    <h3><strong>Dev</strong> - Menu</h3>
  </div>
   <div class="row" style="margin-top:10px;">
      <table id="TableMain" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="text-center no-sort">#</th>
                  <th class="text-center">Nama Menu</th>
                  <th class="text-center">Kategori</th>
                  <th class="text-center">Icon Class</th>
                  <th class="text-center">URL</th>
                  <th class="text-center">Urutan</th>
                  <th class="text-center">Tanggal Buat</th>
                  <th class="text-center no-sort">Aksi</th>
              </tr>
          </thead>

          <tbody id='bodytable'>
            
          </tbody>
      </table>
   </div>
   <!-- Button trigger modal -->
   <button type="button" class="btn btn-add btn-lg"  onclick="showAdd()">
     Tambah Menu
   </button>
</div>
<!-- /.container -->

<!-- Modal Add -->
<div class="modal fade" id="modalform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Menu</h4>
      </div>
      <form action="" method="POST" id="myform">      
        <div class="modal-body">
           <div class="row">
             <div class="col-sm-6">
                <div class="form-group">
                 <label for="nama">Nama Menu</label>
                 <input type="text" name="nama" maxlength="50" Required class="form-control" id="nama" placeholder="Nama Menu">
                 <input type="hidden" name="id" maxlength="50" Required class="form-control" id="id" placeholder="ID Menu">
               </div>
             </div>
             <div class="col-sm-6">
               <div class="form-group">
                 <label for="id_kategori">Kategori</label>
                 <select name="id_kategori" class="form-control" id="id_kategori" required="">
                 </select>
               </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                 <label for="urutan">Urutan Menu</label>
                 <input type="number" min="0" name="urutan" class="form-control" id="urutan" placeholder="Urutan Menu">
               </div>
             </div>
             <div class="col-sm-8">
                <div class="form-group">
                 <label for="icon_class">Icon Class</label>
                 <input type="text" name="icon_class" maxlength="50" class="form-control" id="icon_class" placeholder="Icon Class (ex: font awesome/glyphicon)">
               </div>
             </div>
             <div class="col-sm-12">
                <div class="form-group">
                 <label for="url">URL</label>
                 <input type="text" name="url" Required class="form-control" id="url" placeholder="URL (segmen setelah base_url)">
               </div>
             </div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-add" id="aSimpan">Simpan</button>
        </div>
      </form>
    </div>
 </div>
</div>
<!-- /.Modal Add-->


<script type="text/javascript">
  // initialize datatable
  var table = $("#TableMain").DataTable({
    "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": "no-sort"
        } ],
        // "order": [[ 1, 'asc' ]]    
  });
  table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = "<span style='display:block' class='text-center'>"+(i+1)+"</span>";
        } );
  } ).draw();

  var jsonList = <?php echo $list; ?>;
  var jsonKat = <?php echo $list_kat; ?>;
 
  var awalLoad = true;
  
  loadData(jsonList);
  load_kat(jsonKat);
  
  function load_kat(json){
  	var html = "<option value='' selected disabled>Pilih Kategori</option>";
  	for (var i=0;i<json.length;i++){
  	     html = html+ "<option value='"+json[i].id+"'>"+json[i].nama+"</option>";
  	}
  	$("#id_kategori").html(html);
  }
  
  function loadData(json){
	  //clear table
    table.clear().draw();
	  for(var i=0;i<json.length;i++){
		  table.row.add( [
            "",
            json[i].nama,
            json[i].nama_kategori,
            json[i].icon_class,
            json[i].url,
            "<span class='center-block text-center'>"+json[i].urutan+"</span>",
            DateFormat.format.date(json[i].date_add, "dd-MM-yyyy HH:mm"),
            '<td class="text-center"><div class="btn-group" >'+
                '<a id="group'+i+'" class="divpopover btn btn-sm btn-default" href="javascript:void(0)" data-toggle="popover" data-placement="top" onclick="confirmDelete(this)" data-html="true" title="Hapus Data?" ><i class="fa fa-times"></i></a>'+
                '<a class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ubah Data" onclick="showUpdate('+i+')"><i class="fa fa-pencil"></i></a>'+
               '</div>'+
            '</td>'
        ] ).draw( false );
    }
	  if (!awalLoad){
		  $('.divpopover').attr("data-content","ok");
		  $('.divpopover').popover();
	  }
	  awalLoad = false;	 
  }
  
  
  function showAdd(){
    $("#myModalLabel").text("Tambah Menu");
    $("#id").val("");
    $("#nama").val("");
    $("#url").val("");
    $("#icon_class").val("");
    $("#urutan").val("");
    $("#id_kategori").val("");
    load_kat(jsonKat);
    $("#modalform").modal("show");    
  }
  
  function showUpdate(i){
    load_kat(jsonKat);

    $("#myModalLabel").text("Ubah Menu");
    $("#id").val(jsonList[i].id);
    $("#nama").val(jsonList[i].nama);
    $("#url").val(jsonList[i].url);
    $("#icon_class").val(jsonList[i].icon_class);
    $("#urutan").val(jsonList[i].urutan);
  	$("#id_kategori").val(jsonList[i].id_kategori);
	  $("#modalform").modal("show");
  }
  
  $("#myform").on('submit', function(e){
    e.preventDefault();
    var notifText = 'Data berhasil ditambahkan!';
    var action = "<?php echo base_url('Dev_menu/Master/add')?>/";
    if ($("#id").val() != ""){
      action = "<?php echo base_url('Dev_menu/Master/edit')?>/";
      notifText = 'Data berhasil diubah!';
	  }
	  var param = $('#myform').serialize();
	  if ($("#id").val() != ""){
		 param = $('#myform').serialize()+"&id="+$('#id').val();
	  }
	  
    $.ajax({
      type: 'post',
      url: action,
      data: param,
	    dataType: 'json',
      beforeSend: function() { 
        // tambahkan loading
        $("#aSimpan").prop("disabled", true);
        $('#aSimpan').html('Sedang Menyimpan...');
      },
      success: function (data) {
        if (data.status == '3'){
          console.log("ojueojueokl"+data.status);
          jsonList = data.list;
          loadData(jsonList);
          $('#aSimpan').html('Simpan');
          $("#aSimpan").prop("disabled", false);
  				$("#modalform").modal('hide');
  				// $("#notif-top").fadeIn(500);
  				// $("#notif-top").fadeOut(2500);
          new PNotify({
                        title: 'Sukses',
                        text: notifText,
                        type: 'success',
                        hide: true,
                        delay: 5000,
                        styling: 'bootstrap3'
                      });
  			}
      }
    });
  });
	
	function deleteData(element){
		var el = $(element).attr("id");
		console.log(el);
		var id  = el.replace("aConfirm","");
		var i = parseInt(id);
		//console.log(jsonList[i]);
		$.ajax({
          type: 'post',
          url: '<?php echo base_url('Dev_menu/Master/delete'); ?>/',
          data: {"id":jsonList[i].id},
		      dataType: 'json',
          beforeSend: function() { 
            // kasi loading
            $("#aConfirm"+i).html("Sedang Menghapus...");
            $("#aConfirm"+i).prop("disabled", true);
          },
          success: function (data) {
      			if (data.status == '3'){
              $("#aConfirm"+i).prop("disabled", false);
  				// $("#notif-top").fadeIn(500);
  				// $("#notif-top").fadeOut(2500);
              new PNotify({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus!',
                            type: 'success',
                            hide: true,
                            delay: 5000,
                            styling: 'bootstrap3'
                          });
      				jsonList = data.list;
      				loadData(jsonList);
      			}
          }    
        });
	}
	
	function confirmDelete(el){
		var element = $(el).attr("id");
		console.log(element);
		var id  = element.replace("group","");
		var i = parseInt(id);
    $(el).attr("data-content","<button class=\'btn btn-danger myconfirm\'  href=\'#\' onclick=\'deleteData(this)\' id=\'aConfirm"+i+"\' style=\'min-width:85px\'><i class=\'fa fa-trash\'></i> Ya</button>");
		$(el).popover();

	}
  
  //Hack untuk bootstrap popover (popover hilang jika diklik di luar)
  $(document).on('click', function (e) {
    $('[data-toggle="popover"],[data-original-title]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {                
            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
        }
    });
  });    
</script>
