<div id="page-wrapper">


<div class="row">
    <div class= "status" style=" width: 100%; margin-top: 100px">

      <p style="text-align: center; color: #00aeef; font-size: 32px ">  
        Questions? <br> We've got answers! </p>
        <p style="text-align: center; color: #777; padding-left: 80px; padding-right: 80px"> Check out our <a href="http://ridemarbel.com/pages/frequently-asked-questions">FAQ</a> page! It's loaded up with 80+ of our most frequently asked questions. If you cant find it there, our if you have a Marbel Board service request, just shoot us a message below and we will get back with you in a flash.  <br> <br> <a target="_blank" href="http://ridemarbel.com/pages/frequently-asked-questions"><button type="button" class="btn btn-primary btn-lg outline"> &nbsp &nbsp Vist FAQ Page &nbsp &nbsp</button></p></a>

      </div>  
      <br>
      <br>
      <hr>

      <div class= "status" style=" width: 100%; margin-top: 50px">

        <p style="text-align: center; color: #00aeef; font-size: 32px ">  
          Contact Us </p>
        </div>  

        <div id="output" class="alert text-center" style="display: none; margin: 0 50px;"></div>
        <table width="100%" class="video" style="margin-bottom: -50px">
          <tbody style="margin-top: -20px">

            <tr>
              <td width="100%" align="center" valign="top">
                <form id="contactForm" class="cd-form floating-labels" enctype="multipart/form-data" method="POST" action="upload">
                  <fieldset>
                    <div class="form-group">
                      <div class="row-fluid">
                        <div class="col-md-12">
                          <textarea placeholder="What's on your mind..."  name="cd-notes" id="cd-notes" style="margin-top: -100px" required></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row-fluid">
                        <div class="col-md-6">
                          <input type="file" name="file" id="file" />
                        </div>
                        <div class="col-md-6">
                          <input id="submit-btn" type="submit" value="Submit">
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </form>
              </td>
            </tr>


          </tbody>
        </table>

        <hr>

        <table width="100%" class="video" style="margin-top: -50px">
          <tbody>
            <td width="100%" align="center" valign="top">
              <table class="video" width="100%" style=" margin-top: 70px">
                <tr>

                  <td align="right" valign="top" width="50%" style="color: #777"><b>

                    <p style="padding-right: 15px"> Email:</p>
                    <p style="padding-right: 15px"> Service Email:</p>
                    <p style="padding-right: 15px"> *UPDATED* Phone:</p>

                  </b>
                </td>
                <td align="left" valign="top" width="50%" style="color: #777">

                  <p style="padding-left: 15px"><a href="mailto:hello@ridemarbel.com" target="_top"> hello@ridemarbel.com</a></p>
                  <p style="padding-left: 15px"><a href="mailto:service@ridemarbel.com" target="_top"> service@ridemarbel.com</a></p>
                  <p style="padding-left: 15px"> (813) 513 0029</p>

                </td>
              </tr>
            </table>

          </td>
        </tbody>
      </table>
      <!--- End of notes section --> 
</div>
    
    <script>
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

//  $("#my-calendar").zabuto_calendar({
//    action: function () {
//      return myDateFunction(this.id, false);
//    },
//    action_nav: function () {
//      return myNavFunction(this.id);
//    },
//    ajax: {
//      url: "show_data.php?action=1",
//      modal: true
//    },
//    legend: [
//    {type: "text", label: "Special event", badge: "00"},
//    {type: "block", label: "Regular event", }
//    ]
//  });
});


function myNavFunction(id) {
  $("#date-popover").hide();
  var nav = $("#" + id).data("navigation");
  var to = $("#" + id).data("to");
  console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}
</script>