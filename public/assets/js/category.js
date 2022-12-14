let loc = window.location;
let base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";
$(document).ready(function() {
  var dataTable = $('#tabel_serverside_cat').DataTable( {
    "processing" : true,
    "oLanguage": {
      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
      "sSearch": "Pencarian: ",
      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
      "sInfoFiltered": "(di filter dari _MAX_ total data)",
      "oPaginate": {
        "sFirst": "<<",
        "sLast": ">>",
        "sPrevious": "<",
        "sNext": ">"
      }
    },

    "order": [],
    "ordering": true,
    "info": true,
    "serverSide": true,
    "stateSave" : true,
    "scrollX": true,
    "ajax":{
      "url" :base_url+"adm/categories_data" , // json datasource
      "type": "post",  // method  , by default get
    },
    columns: [
    {mRender: function (data, type, row) {
      return row[0];
    }},
    {mRender: function (data, type, row) {
      return row[1];
    }},
    {mRender: function (data, type, row) {
      return   '<a href="javascript:void(0);" class="btn btn-info btn-sm btn-circle kirim_data" title = "Kirim Data"  id="'+row[2]+'"  ><span class="bi bi-arrow-down-up"></span></a> ';
    }}
    ],
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }],

  error: function(){  // error handling
    $(".tabel_serverside-error").html("");
    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
    $("#tabel_serverside_processing").css("display","none");

  }

});

});
$(document).ready(function() {
  var dataTable = $('#tabel_serverside_sub_cat').DataTable( {
    "processing" : true,
    "oLanguage": {
      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
      "sSearch": "Pencarian: ",
      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
      "sInfoFiltered": "(di filter dari _MAX_ total data)",
      "oPaginate": {
        "sFirst": "<<",
        "sLast": ">>",
        "sPrevious": "<",
        "sNext": ">"
      }
    },

    "order": [],
    "ordering": true,
    "info": true,
    "serverSide": true,
    "stateSave" : true,
    "scrollX": true,
    "ajax":{
      "url" :base_url+"admin/listdata_mahasiswa_kirim_feeder" , // json datasource
      "type": "post",  // method  , by default get
    },
    columns: [
    {mRender: function (data, type, row) {
      return row[0];
    }},
    {mRender: function (data, type, row) {
      return row[2];
    }},
    {mRender: function (data, type, row) {
      return row[16];
    }},
    {mRender: function (data, type, row) {
      return row[14];
    }},
    {mRender: function (data, type, row) {
      return row[18].slice(0,4);
    }},
    {mRender: function (data, type, row) {
      return   '<a href="javascript:void(0);" class="btn btn-info btn-sm btn-circle kirim_data" title = "Kirim Data"  id="'+row[1]+'"  ><span class="bi bi-arrow-down-up"></span></a> ';
    }}
    ],
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }],

  error: function(){  // error handling
    $(".tabel_serverside-error").html("");
    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
    $("#tabel_serverside_processing").css("display","none");

  }

});

});