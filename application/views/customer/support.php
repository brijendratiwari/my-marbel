<div id="page-wrapper">


    <div class="row">
        <div class= "status" style=" width: 100%; margin-top: 100px">

            <p style="text-align: center; color: #00aeef; font-size: 32px ">  
                Questions? <br> We've got answers! </p>
            <p style="text-align: center; color: #777; padding-left: 80px; padding-right: 80px"> Check out our <a href="http://ridemarbel.com/pages/frequently-asked-questions">FAQ</a> page! It's loaded up with 80+ of our most frequently asked questions. If you cant find it there, our if you have a Marbel Board service request, just shoot us a message below and we will get back with you in a flash.  <br> <br> <a target="_blank" href="http://ridemarbel.com/pages/frequently-asked-questions"><button type="button" class="btn btn-custom btn-lg"> &nbsp &nbsp Vist FAQ Page &nbsp &nbsp</button></p></a>

        </div>  
        <br>
        <br>
        <hr>

        <div class= "col-md-12">

            <p style="text-align: center; color: #00aeef; font-size: 32px ">  
                Contact Us </p>
        </div>  
        <div class='clearfix'></div>
        <div id="output" class="alert text-center" style="display: none;"></div>
        <div class="col-md-12">
            <form id="contactForm" class="cd-form floating-labels" enctype="multipart/form-data" method="POST" action="upload">
                <div class="col-md-12 form-group">
                    <textarea placeholder="What's on your mind..."  name="cd-notes" id="cd-notes" class="form-control" required></textarea>
                </div>
                <div class="col-md-6 form-group">
                    <input type="file" name="file" id="file" />
                </div>
                <div class="col-md-6 form-group">
                    <input id="submit-btn" class="btn btn-sm btn-custom" type="submit" value="Submit">
                </div>
            </form>

        </div>

        <hr>

        <div class="col-md-12 text-center" style="margin-bottom:5%">
            <p><b>Email:</b><a href="mailto:hello@ridemarbel.com" target="_top"> hello@ridemarbel.com</a></p>
            <p style="padding-right: 15px"><b>Service Email:</b> <a href="mailto:service@ridemarbel.com" target="_top"> service@ridemarbel.com</a></p>
            <p style="padding-right: 15px"> <b>*UPDATED* Phone:</b> (813) 513 0029</p>


        </div>
        <!--- End of notes section --> 
    </div>
    <!--show loader-->
    <div class="checkout_loader hidden" id="form_loader">
        <div class="overlay new_loader" style="position:fixed;"></div>
        <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
    </div>
    <!-- show loader-->
</div>

<script>
    function beforeSubmit() {

        $('body').find('#form_loader').removeClass('hidden');
    }
    $(document).ready(function () {
        var options = {
            target: '#output',
            beforeSubmit: beforeSubmit,
            success: afterSuccess,
            uploadProgress: OnProgress,
            resetForm: true
        };



        function afterSuccess() {
            $('body').find('#form_loader').addClass('hidden');
            $('#output').show();
            $('#output').addClass("alert-warning");
        }
        function OnProgress(event, position, total, percentComplete) {
            $('#output').text('Uploaded ' + percentComplete + '%');
            if (percentComplete >= 99) {
                setTimeout(function () {
                    $('#output').hide('slow');
                }, 5000);
            }
        }

        $('#contactForm').on('submit', function (e) {
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