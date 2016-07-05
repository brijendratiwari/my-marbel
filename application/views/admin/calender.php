<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12" style="margin-top: 2%;">

            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-sm btn-custom" data-target="#eventModal" data-toggle="modal">Create Event</button>
                </div>
            </div>
            <div class="row" style="margin-top: 2%;">
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">All Events</div>
                        <div class="panel-body event-data">

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
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create New Event</h4>
            </div>
            <div class="modal-body">



            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" id="add-event" class="btn btn-success">Create</button>
            </div>
        </div>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>



</div>
<!--create Event modal end-->

<script>

    $(document).ready(function () {


        /* call function get events month wise for listing */
        getEvents(false);


        var zone = "05:30";  //Change this to your timezone

        $.ajax({
            url: 'process',
            type: 'POST', // Send post data
            data: 'type=fetch',
            async: false,
            success: function (s) {
                json_events = s;
            }
        });





        /* initialize the calendar
         -----------------------------------------------------------------*/

       var calendar =  $('#calendar').fullCalendar({
            events: JSON.parse(json_events),
            //events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
            utc: true,
            header: {
                left: 'prev,next today',
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
                    url: 'process',
                    data: 'type=new&title=' + title + '&startdate=' + start + '&zone=' + zone,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        event.id = response.eventid;
                        $('#calendar').fullCalendar('updateEvent', event);
                    },
                    error: function (e) {
                        console.log(e.responseText);

                    }
                });
                $('#calendar').fullCalendar('updateEvent', event);
                console.log(event);
            }
        });

        function getFreshEvents() {
            $.ajax({
                url: 'process',
                type: 'POST', // Send post data
                data: 'type=fetch',
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


    });

    function getEvents(month) {

        /* get events mont wise for listing */
        $('body').find('.event-data').load("<?php echo base_url('admin/calendar/getEvents'); ?>/" + month + "");
    }

</script>


<style>

    .fc-event{
        background-color: #00aeef !important;
        border: 1px solid #00aeef !important;
    }
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