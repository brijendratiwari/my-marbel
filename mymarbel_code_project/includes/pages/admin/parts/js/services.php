<script>
  $(document).ready(function () {
    $('#finished').DataTable({
      "iDisplayLength": 50,
      "order": [[ 2, "desc" ]],
      processing: true,
      serverSide: true,
      select: true,
      ajax: {
        url: "/datatables/services?status=finished",
        type: "POST", 
      },
      language: { "search": ""},
      columns: [
        { data: null, render: function( data, type, row) {
          return '<a href="edit-service?id='+data.id+'"><i class="fa fa-pencil"></i></a>';
        }},
        { data: "first_name" },
        { data: "last_name" },
        { data: "qa_date" },
        { data: "tracking_number" },
        { data: "status" }
      ]
    });
    $('#inhouse').DataTable({
      "iDisplayLength": 50,
      "order": [[ 2, "desc" ]],
      processing: true,
      serverSide: true,
      select: true,
      ajax: {
        url: "/datatables/services?status=inhouse",
        type: "POST", 
      },
      language: { "search": ""},
      columns: [
        { data: null, render: function( data, type, row) {
          return '<a href="edit-service?id='+data.id+'"><i class="fa fa-pencil"></i></a>';
        }},
        { data: "first_name" },
        { data: "last_name" },
        { data: "date" },
        { data: "priority" },
        { data: "due_date" },
        { data: "status" }
      ]
    });
    $('#pending').DataTable({
      "iDisplayLength": 50,
      "order": [[ 2, "desc" ]],
      processing: true,
      serverSide: true,
      select: true,
      ajax: {
        url: "/datatables/services?status=pending",
        type: "POST", 
      },
      language: { "search": ""},
      columns: [
        { data: null, render: function( data, type, row) {
          return '<a href="new-service?service_id='+data.id+'&id='+data.user_id+'"><i class="fa fa-pencil"></i></a>';
        }},
        { data: "first_name" },
        { data: "last_name" },
        { data: "date" },
        { data: "suggested_response" },
        { data: "tracking_in" }
      ]
    });

    $('div.dataTables_length select').addClass('form-control');
    $('div.dataTables_length select').attr({'style': "display:inline;padding:0px;width:inherit;"});
    $('div.dataTables_filter input').addClass('form-control');
    $('div.dataTables_filter input').attr({'placeholder': "Search..."});
    $('div.dataTables_wrapper').css({'width': "99%"});
  });
</script>