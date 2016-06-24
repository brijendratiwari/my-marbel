
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div id='calendar' style='margin-top:10px;'></div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

        var calendar = $('#calendar').fullCalendar({
            defaultDate: '2016-06-12',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2016-06-01'
                },
                {
                    title: 'Long Event',
                    start: '2016-06-07',
                    end: '2016-06-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-06-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2016-06-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2016-06-11',
                    end: '2016-06-13'
                },
                {
                    title: 'Meeting',
                    start: '2016-06-12T10:30:00',
                    end: '2016-06-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2016-06-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2016-06-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2016-06-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2016-06-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2016-06-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2016-06-28'
                }
            ],
            eventDrop: function () {
                alert('work in progress....');
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                var url = prompt('Type Event url, if exits:');
                if (title) {
                       alert('work in progress....');
//                    var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
//                    var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
//                    $.ajax({
//                        url: 'http://localhost:8888/fullcalendar/add_events.php',
//                        data: 'title=' + title + '&start=' + start + '&end=' + end + '&url=' + url,
//                        type: "POST",
//                        success: function (json) {
//                            alert('Added Successfully');
//                        }
//                    });
//                    calendar.fullCalendar('renderEvent',
//                            {
//                                title: title,
//                                start: start,
//                                end: end,
//                                allDay: allDay
//                            },
//                    true // make the event "stick"
//                            );
                }
                calendar.fullCalendar('unselect');
            }, eventClick: function (event, jsEvent, view) {
                var title = prompt('Event Title:', event.title, {buttons: {Ok: true, Cancel: false}});
                if (title) {
//                    event.title = title;
//                    $.ajax({
//                        url: 'process.php',
//                        data: 'type=changetitle&title=' + title + '&eventid=' + event.id,
//                        type: 'POST',
//                        dataType: 'json',
//                        success: function (response) {
//                            if (response.status == 'success')
//                                $('#calendar').fullCalendar('updateEvent', event);
//                        },
//                        error: function (e) {
//                            alert('Error processing your request: ' + e.responseText);
//                        }
//                    });
                }
            }

        });

    });

</script>
<style>

    .fc-event{
        background-color: #00aeef !important;
        border: 1px solid #00aeef !important;
    }
</style>