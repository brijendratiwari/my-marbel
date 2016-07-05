     <div class="col-md-12">
                 
                     <label>Event Name</label>
                  
                    <input type="text" name="cd-title" class="form-control" value="<?php echo $event->title; ?>" placeholder="Event Name">
                  <span id="cd-title" class="text-danger hidden"></span>
                  
                </div>
                <div class="col-md-12">
                 
                     <label>Location</label>
                  
                    <input type="text" name="cd-location" class="form-control" placeholder="Location" nvalue="<?php echo $event->location; ?>" >
                    <span id="cd-location" class="text-danger hidden"></span>
               
                </div>
                <div class="col-md-12">
                 
                     <label>Start Date/Time</label>
                  
                     <input type="text" name="cd-date-start" id="" value="<?php echo date('m/d/Y h:i A',strtotime($event->startdate)); ?>"  class="form-control datetimepicker8" placeholder="Date/Time">
                    <span id="cd-date-start" class="text-danger hidden"></span>
                  
                </div>
                 <div class="col-md-12">
                 
                     <label>End Date/Time</label>
                  
                     <input type="text" name="cd-date-end" id="" value="<?php echo date('m/d/Y h:i A',strtotime($event->enddate)); ?>" class="form-control datetimepicker9" placeholder="Date/Time">
                    <span id="cd-date-end" class="text-danger hidden"></span>
                  
                </div>
                <div class="col-md-12">
                 
                     <label>Description</label>
                   <textarea name="cd-description"  class="form-control" placeholder="Tell people more about event" style="max-height: 90px; height: 90px;"><?php echo $event->description; ?></textarea>
                    <span id="cd-description" class="text-danger hidden"></span>
               
                </div>

<script>
    $(document).ready(function(){
        
        /* datetime picker*/
         $('body').find('.datetimepicker8').datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
            });
            $('body').find('.datetimepicker9').datetimepicker({
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down"
                },
            });
    })
</script>