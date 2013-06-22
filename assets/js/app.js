$( document ).ready(function() {

  var oTable = $('table').dataTable({
    "iDisplayStart": 0,
    "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 'All']],
    "sPaginationType": "bootstrap"
  });

 })