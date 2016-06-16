<script type="application/javascript">
  $(document).ready(function () {

    var userTable = $('#shipping_orders').DataTable({
      "iDisplayLength": 50,
      "order": [[ 9, "asc" ],[ 4, "asc" ], [3, 'asc']],
      processing: true,
      serverSide: true,
      select: true,
      ajax: {
        url: "/datatables/shipping_orders",
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
      { data: "est_ship_date" },
	  { data: "last_activity" },
      { data: "order_status" },
	  { data: "wheel_color" },
	  { data: "wheel_size" },
	  { data: "priority" }
      ]
    });

    $('div.dataTables_length select').addClass('form-control');
    $('div.dataTables_length select').attr({'style': "display:inline;padding:0px;width:inherit;"});
    $('div.dataTables_filter input').addClass('form-control');
    $('div.dataTables_filter input').attr({'placeholder': "Search..."});
    $('div.dataTables_wrapper').css({'width': "99%"});
  });
</script>