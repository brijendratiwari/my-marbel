<script type="application/javascript">
$(document).ready(function() { 
  var options = { 
    target:   '#output',
    beforeSubmit:  beforeSubmit,
    success:       afterSuccess,
    uploadProgress: OnProgress,
    resetForm: true
  };

  function beforeSubmit() {
    $('#output').show();
    $('#output').addClass("alert-warning");
    $('#output').text('Starting Upload...');
  }

  function afterSuccess() {
    $('#submit-btn').val('Submit');
  }
  function OnProgress(event, position, total, percentComplete) {
    $('#output').text('Uploaded '+percentComplete + '%');
    if (percentComplete >= 99) {
      setTimeout(function() {
        $('#output').hide('slow');
      }, 5000);
    }
  }

  $('#contactForm').on('submit', function(e) {
    e.preventDefault();
    $(this).ajaxSubmit(options);
  });
});

$(document).ready(function () {
  $("#date-popover").popover({html: true, trigger: "manual"});
  $("#date-popover").hide();
  $("#date-popover").click(function (e) {
    $(this).hide();
  });

  $("#my-calendar").zabuto_calendar({
    action: function () {
      return myDateFunction(this.id, false);
    },
    action_nav: function () {
      return myNavFunction(this.id);
    },
    ajax: {
      url: "show_data.php?action=1",
      modal: true
    },
    legend: [
    {type: "text", label: "Special event", badge: "00"},
    {type: "block", label: "Regular event", }
    ]
  });
});


function myNavFunction(id) {
  $("#date-popover").hide();
  var nav = $("#" + id).data("navigation");
  var to = $("#" + id).data("to");
  console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}
</script>