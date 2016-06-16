<script type="application/javascript">
  $(document).ready(function () {

    var userTable = $('#shipping_orders').DataTable({
      "iDisplayLength": 50,
      "order": [[ 5, "desc" ]],
      processing: true,
      serverSide: true,
      select: true,
      ajax: {
        url: "/datatables/shipped_orders",
        type: "POST", 
      },
      language: { "search": ""},
      columns: [
      { data: null, render: function( data, type, row) {
        return '<a href="edit-order?id='+data.id+'"><i class="fa fa-pencil"></i></a>';
      }},
      { data: "first_name" },
      { data: "last_name" },
      { data: "order_date" },
      { data: "tracking_number" },
      { data: "date" }
      ]
    });

    $('div.dataTables_length select').addClass('form-control');
    $('div.dataTables_length select').attr({'style': "display:inline;padding:0px;width:inherit;"});
    $('div.dataTables_filter input').addClass('form-control');
    $('div.dataTables_filter input').attr({'placeholder': "Search..."});
    $('div.dataTables_wrapper').css({'width': "99%"});
  });
</script>