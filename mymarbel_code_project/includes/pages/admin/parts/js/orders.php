<script type="application/javascript">
    $(document).ready(function () {

        var userTable = $('#orders').DataTable({
            "iDisplayLength": 50,
            "order": [[ 2, "desc" ]],
            processing: true,
            serverSide: true,
            select: true,
            ajax: {
                url: "/datatables/orders",
                type: "POST", 
            },
            language: { "search": ""},
            columns: [
            { data: null, render: function( data, type, row) {
              return '<a href="edit-order?id='+data.id+'"><i class="fa fa-pencil"></i></a>';
          }},
          { data: "order_number" },
          { data: "order_date" },
          { data: "first_name" },
          { data: "last_name" },
          { data: "order_status" },
          { data: null, render: function(data, type, row) {
            if (data.tracking_number) {
              return data.tracking_number;
            } 
            if (data.est_ship_date == 0) {
              return '';
            }
            return data.est_ship_date;
          }},
          { data: "order_total" },
          { data: null, render: function( data, type, row) {
              return '<a href="#" class="trash" data-pk="'+data.order_number+'" data-order_number="'+data.order_number+'"><i class="fa fa-trash-o"></i></a>';
          }}
          ],
          drawCallback: function( settings ) {
              $('#orders td a.trash').on('click', function (e) {
                e.stopPropagation(); 
                var order_number = $(this).attr('data-order_number');
                if (confirm("Are you sure you want to delete order # "+order_number)) {
                  $.post( '/datatables/u_orders', {name:'remove_id', value:$(this).attr('data-pk'), pk:$(this).attr('data-pk')})
                  .done(function( data ) {
                      userTable.draw();
                      $('#msg').addClass('alert-success').removeClass('alert-warning').html('Order #'+order_number+' was removed').fadeIn();
                      setTimeout(function(){
                          $('#msg').fadeOut();
                      }, 2500);
                  });
              }
          });
          }
      });

$('div.dataTables_length select').addClass('form-control');
$('div.dataTables_length select').attr({'style': "display:inline;padding:0px;width:inherit;"});
$('div.dataTables_filter input').addClass('form-control');
$('div.dataTables_filter input').attr({'placeholder': "Search..."});
$('div.dataTables_wrapper').css({'width': "99%"});
});
</script>