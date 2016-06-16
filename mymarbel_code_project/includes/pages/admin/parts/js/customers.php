<script type="application/javascript">
    $(document).ready(function () {

        var userTable = $('#customers').DataTable({
            "iDisplayLength": 50,
            "order": [[ 1, "asc" ]],
            processing: true,
            serverSide: true,
            select: true,
            ajax: {
                url: "/datatables/customers",
                type: "POST", 
            },
            language: { "search": ""},
            columns: [
            { data: null, render: function(data, type, row) {
              return '<a href="edit-customer?id='+data.id+'"><i class="fa fa-pencil"></i></a>';
          }},
          { data: "email" },  
          { data: "first_name" },
          { data: "last_name" },
          { data: "last_activity" },
          { data: null, render: function( data, type, row) {
              var html = '';
              console.log(data);
              if (! data.phone) { return 'Empty'; }
              if (data.phone.length > 10) {
                html = '+'+data.phone.substring(0, data.phone.length - 10)+' ';
                data.phone = data.phone.substring(data.phone.length - 10);
            }
            return '<span class="phone">'+html + data.phone.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3")+'</span>';
        }},
        { data: "notes" },
        { data: null, render: function( data, type, row) {
          return '<a href="#" class="trash" data-pk="'+data.id+'" data-email="'+data.email+'"><i class="fa fa-trash-o"></i></a>';
      }}
      ],
      drawCallback: function( settings ) {
          $('#customers td a.trash').on('click', function (e) {
            e.stopPropagation(); 
            var email = $(this).attr('data-email');
            $.post( '/datatables/u_customers', {name:'remove_id', value:$(this).attr('data-pk'), pk:$(this).attr('data-pk')})
            .done(function( data ) {
                userTable.draw();
                $('#msg').addClass('alert-success').removeClass('alert-warning').html('User '+email+' was removed').fadeIn();
                setTimeout(function(){
                    $('#msg').fadeOut();
                }, 2500);
            });
        });
      }});

$('div.dataTables_length select').addClass('form-control');
$('div.dataTables_length select').attr({'style': "display:inline;padding:0px;width:inherit;"});
$('div.dataTables_filter input').addClass('form-control');
$('div.dataTables_filter input').attr({'placeholder': "Search..."});
$('div.dataTables_wrapper').css({'width': "99%"});

});
</script>