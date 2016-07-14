<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12" style="margin-top: 2%;">

            <div class="row">
                <div class="col-lg-12">
                    <?php if($this->session->flashdata('success')){?>
                    <div  class="pull-right alert alert-success message"><?php echo $this->session->flashdata('success');?></div>
                    <?php } ?>
                     <?php if($this->session->flashdata('error')){?>
                    <div  class="pull-right alert alert-danger message"><?php echo $this->session->flashdata('error');?></div>
                    <?php } ?>
                    <div id="eventSuccess" class="pull-right alert alert-success hidden message"></div>
               
                    <button class="btn btn-sm btn-custom" data-target="#eventModal" data-toggle="modal">Create Event</button>
                    <a href='<?php echo base_url('calendar'); ?>' class="btn btn-sm btn-custom tab-active">Company Overview</a>
                    <a href='<?php echo base_url('calendar/my_calendar'); ?>' class="btn btn-sm btn-custom">Personal</a>
                </div>
            </div>
            <div class="row" style="margin-top: 2%;">
<!--                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Events</div>
                        <div class="panel-body event-data">

                        </div>
                    </div>

                </div>-->
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Event Types</div>
                        <div class="panel-body">
                        <?php if(!empty($event_types)){
                        foreach ($event_types as $type){ ?>
                             <div class="col-lg-12"  style="font-size:12px;">
                            <div class="col-lg-9">
                                <?php echo $type['name'];?>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-xs" style="background-color:<?php echo $type['color_code']; ?>"></button>
                            </div>
                            </div>
                          
                        <?php } } ?>
                           <div class="col-lg-12"  style="font-size:12px;">
                            <div class="col-lg-9">
                               Inventory
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-xs" style="background-color:#F5D709"></button>
                            </div>
                            </div>  
                        </div>
                    </div>

                </div>

                <div id='calendar' class="col-lg-9"></div>
            </div>

            <div style='clear:both'></div>
        </div>
    </div>
</div>

<!--create Event modal-->

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
    <div class="modal-dialog">
        <form name="event-create" id="event-create" method="post" action="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create New Event</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                 
                     <label>Event Name <i class="fa fa-calendar"></i></label>
                  
                    <input type="text" name="cd-title" class="form-control" placeholder="Event Name">
                    <span id="cd-title" class="text-danger hidden"></span>
                  
                </div>
                <div class="col-md-12">
                 
                     <label>Location <i class="fa fa-map-marker"></i></label>
                  
                    <input type="text" name="cd-location" class="form-control" placeholder="Location">
                    <span id="cd-location" class="text-danger hidden"></span>
               
                </div>
                   <div class="col-md-12">
                 
                     <label>Event Types <i class="fa fa"></i></label>
                  
                    <select  name="cd-types" class="form-control">
                    <option value="">Event Types</option>
                    <?php if(!empty($event_types)){
                        foreach ($event_types as $type){ ?>
                    <option value="<?php echo $type['id'];?>"><?php echo $type['name'];?></option>
                        <?php } } ?>
                   </select>
                    <span id="cd-types" class="text-danger hidden"></span>
               
                </div>
<!--                  <div class="col-md-12">
                 
                     <label>Select Assignee</label>
                            <select  name="cd-assignee" class="form-control">
                                <option value="">Select Assignee</option>
                                <?php if ($assignee) {
                                    foreach ($assignee as $name) {

                                        if($name['id']!=$this->session->userdata['marbel_user']['user_id']){
                                        ?>

                                        <option value="<?php echo $name['id']; ?>"><?php echo $name['first_name'] . ' ' . $name['last_name'] . '(' . $name['user_role_type'] . ')'; ?></option>
                                  <?php }} }?>

                            </select>
               <span id="cd-assignee" class="text-danger hidden"></span>
                </div>-->
                
                <div class="col-md-12">
                 
                     <label>Start Date/Time <i class="fa fa-calendar-o"></i></label>
                  
                     <input type="text" name="cd-date-start" id="" class="form-control datetimepicker8" placeholder="Date/Time">
                    <span id="cd-date-start" class="text-danger hidden"></span>
                  
                </div>
                 <div class="col-md-12">
                 
                     <label>End Date/Time <i class="fa fa-calendar-o"></i></label>
                  
                     <input type="text" name="cd-date-end" id="" class="form-control datetimepicker9" placeholder="Date/Time">
                    <span id="cd-date-end" class="text-danger hidden"></span>
                  
                </div>
                <div class="col-md-12">
                 
                     <label>Description</label>
                   <textarea name="cd-description" class="form-control" placeholder="Tell people more about event" style="max-height: 90px; height: 90px;"></textarea>
                    <span id="cd-description" class="text-danger hidden"></span>
               
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="add-event" class="btn btn-success">Create</button>
            </div>
        </div>
    </form>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>



</div>
<!--create Event modal end-->


<!--update Event modal-->

<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
    <div class="modal-dialog">
        <form name="event-update" id="event-update" method="post" action="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Event Detail</h4>
            </div>
            <div class="update-event-data"><!--content will be load on click--></div>
            </div>
    </form>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>



</div>
<!--update Event modal end-->

<script>

    $(document).ready(function () {


        /* call function get events month wise for listing */
        getEvents(0);


        var zone = "05:30";  //Change this to your timezone

        $.ajax({
            url: '<?php echo base_url('calendar/process'); ?>',
            type: 'POST', // Send post data
            data: 'type=fetch&cal_type=forall',
            async: false,
            success: function (s) {
                json_events = s;
            }
        });





        /* initialize the calendar
         -----------------------------------------------------------------*/

        var calendar = $('#calendar').fullCalendar({
            events: JSON.parse(json_events),
            //events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
            //eventColor: '#00aeef',
             eventRender: function(event, element) {
//                if(event.event_created_by == '<?php echo $this->session->userdata['marbel_user']['user_id']; ?>') {
                    element.css('background-color', ''+event.color_code+'');
                    element.css('border-color',''+event.color_code+'');
//                }else{
//                    
//                    element.css('background-color', 'grey');
//                    element.css('border-color', 'grey');
//                }
                 if(event.event_created_by == '<?php echo $this->session->userdata['marbel_user']['user_id']; ?>' && event.task_id != 0) {
                    element.css('display', 'none');
                }
            },
            utc: true,
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true,
            slotDuration: '00:30:00',
            eventReceive: function (event) {
                var title = event.title;
                var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
                $.ajax({
                    url: '<?php echo base_url('calendar/process'); ?>',
                    data: 'type=new&title=' + title + '&startdate=' + start + '&zone=' + zone,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        event.id = response.id;
                        $('#calendar').fullCalendar('updateEvent', event);
                    },
                    error: function (e) {
                        console.log(e.responseText);

                    }
                });
                $('#calendar').fullCalendar('updateEvent', event);
                console.log(event);
            },
            eventDrop: function (event, delta, revertFunc) {
                var title = event.title;
                var start = event.start.format();
                var end = (event.end == null) ? start : event.end.format();
                $.ajax({
                    url: '<?php echo base_url('calendar/process'); ?>',
                    data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status != 'success')
                            revertFunc();
                        getEvents(0);
                    },
                    error: function (e) {
                        revertFunc();
                        alert('Error processing your request: ' + e.responseText);
                    }
                });
            },
            eventClick: function (event, jsEvent, view) {
               
                $('body').find('.checkout_loader').removeClass('hidden');
                $('body').find('#editEventModal').modal('show');
                $('body').find('.update-event-data').load("<?php echo base_url('admin/calendar/getSingleEvent'); ?>/" + event.id + "",function(response){
                    
                    if(response){
                    
                     $('body').find('.checkout_loader').addClass('hidden');
                        
                    }
                });
//                var title = prompt('Event Title:', event.title, {buttons: {Ok: true, Cancel: false}});
//                if (title) {
//                    event.title = title;
//                    console.log('type=changetitle&title=' + title + '&eventid=' + event.id);
//                    $.ajax({
//                        url: 'process',
//                        data: 'type=changetitle&title=' + title + '&eventid=' + event.id,
//                        type: 'POST',
//                        dataType: 'json',
//                        success: function (response) {
//                            if (response.status == 'success')
//                                $('#calendar').fullCalendar('updateEvent', event);
//                            getEvents(0);
//                        },
//                        error: function (e) {
//                            alert('Error processing your request: ' + e.responseText);
//                        }
//                    });
//                }
            },
            eventResize: function (event, delta, revertFunc) {
                console.log(event);
                var title = event.title;
                var end = event.end.format();
                var start = event.start.format();
                $.ajax({
                    url: '<?php echo base_url('calendar/process'); ?>',
                    data: 'type=resetdate&title=' + title + '&start=' + start + '&end=' + end + '&eventid=' + event.id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status != 'success')
                            revertFunc();
                        getEvents(0);
                    },
                    error: function (e) {
                        revertFunc();
                        alert('Error processing your request: ' + e.responseText);
                    }
                });
            }, dayRender: function(date, cell){
                    var maxDate = new Date();
                    if (date > maxDate){
                        $(cell).addClass('disabled');
        }
    }

        });

        function getFreshEvents() {
            $.ajax({
                url: '<?php echo base_url('calendar/process'); ?>',
                type: 'POST', // Send post data
                data: 'type=fetch&cal_type=forall',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
        }




        /* call events function on previous and next click..*/
        $('.fc-prev-button').click(function () {
            var moment = $('#calendar').fullCalendar('getDate');
            getEvents(moment.format());
        });
        $('.fc-next-button').click(function () {
            var moment = $('#calendar').fullCalendar('getDate');
            getEvents(moment.format());
        });
/* datetime picker*/
       
        $('.datetimepicker8').datetimepicker();
        $('.datetimepicker9').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $(".datetimepicker8").on("dp.change", function (e) {
            $('.datetimepicker9').data("DateTimePicker").minDate(e.date);
        });
        $(".datetimepicker9").on("dp.change", function (e) {
            $('.datetimepicker8').data("DateTimePicker").maxDate(e.date);
        });
            
 /* add event through ajax */
var base_url = $('body').find('#base_url').val();
    
        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#eventModal #form_loader').removeClass('hidden');
            },
            url: base_url+'add_event',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#eventModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#eventModal #" + index2).text(msg);
                            $("#eventModal #" + index2).removeClass('hidden');
                        });
                    });
                }
                else {
                    $('body').find('#eventModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#eventModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#eventSuccess").text(err.success);
                        $("#eventSuccess").removeClass('hidden');
                        
                         setTimeout(function () {
                            $('body').find('#eventModal').modal('hide');
                        }, 500)
                        window.location.href='<?php echo base_url('calendar');?>';
                  }
                    else {
                        $('body').find('#eventModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        setTimeout(function () {
                            $('body').find('#eventModal').modal('hide');
                        }, 500)
                    }
                }
            }
        };
        $('body').find('#event-create').ajaxForm(options);
    /*end ajax here */
    /* Update event through ajax */
var base_url = $('body').find('#base_url').val();
            
        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#editEventModal #form_loader').removeClass('hidden');
            },
            url: base_url+'update_event',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#editEventModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#editEventModal #" + index2).text(msg);
                            $("#editEventModal #" + index2).removeClass('hidden');
                        });
                    });
                }
                else {
                    $('body').find('#editEventModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#editEventModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#eventSuccess").text(err.success);
                        $("#eventSuccess").removeClass('hidden');
                        
                         setTimeout(function () {
                            $('body').find('#editEventModal').modal('hide');
                        }, 500)
                        window.location.href='<?php echo base_url('calendar');?>';
                  }
                    else {
                        $('body').find('#editEventModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        setTimeout(function () {
                            $('body').find('#editEventModal').modal('hide');
                        }, 500)
                    }
                }
            }
        };
        $('body').find('#event-update').ajaxForm(options);
    /*end ajax here */
    /*get evnt on click..*/
    $('body').on('click','.get-event',function(){
    $('body').find('.checkout_loader').removeClass('hidden');
       var event = $(this).attr('data-eventId');
       
         if(event!=''){
             
             $('body').find('.update-event-data').load("<?php echo base_url('admin/calendar/getSingleEvent'); ?>/" + event + "",function(response){
                 if(response){
                     $('body').find('.checkout_loader').addClass('hidden');
                 }
             });
         }
    
    })
    /*get evnt on click..*/
    
    
    
    });

    function getEvents(month) {

        /* get events mont wise for listing */
        $('body').find('.event-data').load("<?php echo base_url('admin/calendar/getEvents'); ?>/" + month + "");
    }

</script>


<style>

/*    .fc-event{
        background-color: #00aeef !important;
        border: 1px solid #00aeef !important;
    }*/
    #trash{
        width:32px;

        float:left;
        padding-bottom: 15px;
        position: relative;
    }



    #external-events {
        float: left;
        width: 15%;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
        text-align: left;
    }

    #external-events h4 {
        font-size: 16px;
        margin-top: 0;
        padding-top: 1em;
    }

    #external-events .fc-event {
        margin: 10px 0;
        cursor: pointer;
    }

    #external-events p {
        margin: 1.5em 0;
        font-size: 11px;
        color: #666;
    }

    #external-events p input {
        margin: 0;
        vertical-align: middle;
    }

</style>