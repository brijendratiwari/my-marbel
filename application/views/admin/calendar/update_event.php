     <div class="modal-body">
<div class="col-md-12">
                 
                     <label>Event Name <i class="fa fa-calendar"></i></label>
                  
                    <input type="text" name="cd-title" class="form-control" value="<?php echo $event->title; ?>" placeholder="Event Name">
                  <span id="cd-title" class="text-danger hidden"></span>
                  
                </div>
                <?php if($event->event_type!=11){?>
                <div class="col-md-12">
                 
                     <label>Location <i class="fa fa-map-marker"></i></label>
                  
                    <input type="text" name="cd-location" class="form-control" placeholder="Location" value="<?php echo $event->location; ?>" >
                    <span id="cd-location" class="text-danger hidden"></span>
               
                </div>
                <div class="col-md-12">
                 
                     <label>Event Types <i class="fa fa"></i></label>
                        <select  name="cd-types" class="form-control select_input">
                     <?php if($event->task_id>0){?>
                             <option value="2">Task</option>
                     <?php }else{ ?>
                        <option value="">Event Types</option>
                         <?php if(!empty($event_types)){
                        foreach ($event_types as $type){ ?>
                    <option value="<?php echo $type['id'];?>" <?php if($event->event_type == $type['id']){echo 'selected';} ?>><?php echo $type['name'];?></option>
                     <?php } } } ?>
                    
                   </select>
                        </select>
                    <span id="cd-types" class="text-danger hidden"></span>
               
                </div>
                
<!--                <div class="col-md-12">
                 
                    <label>Select Assignee</label>
                            <select  name="cd-assignee" class="form-control">
                                <option value="">Select Assignee</option>
                                <?php if ($assignee) {
                                    foreach ($assignee as $name) {

                                        if($name['id']!=$this->session->userdata['marbel_user']['user_id']){
                                        ?>

                                        <option value="<?php echo $name['id']; ?>" <?php if (strcmp($event->event_created_to, $name['id']) == 0) {
                echo 'selected="selected"';
            } ?>><?php echo $name['first_name'] . ' ' . $name['last_name'] . '(' . $name['user_role_type'] . ')'; ?></option>
                                  <?php }} }?>

                            </select>
               <span id="cd-assignee" class="text-danger hidden"></span>
               
                </div>-->
                <div class="col-md-12">
                 
                     <label>Start Date/Time <i class="fa fa-calendar-o"></i></label>
                  
                     <input type="text" name="cd-date-start" id="" value="<?php 
                  
                     if($event->startdate!=''){
                         $start_date=explode('T',$event->startdate);
                         $start_datetime=$start_date[0].' '.explode('+',$start_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($start_datetime));
                     
                     
                     ?>"  class="form-control datetimepicker8" placeholder="Date/Time">
                    <span id="cd-date-start" class="text-danger hidden"></span>
                  
                </div>
                 <div class="col-md-12">
                 
                     <label>End Date/Time <i class="fa fa-calendar-o"></i></label>
                  
                     <input type="text" name="cd-date-end" id="" value="<?php 
                  
                     if($event->enddate!=''){
                         $end_date=explode('T',$event->enddate);
                         $end_datetime=$end_date[0].' '.explode('+',$end_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($end_datetime));
                     
                     
                     ?>" class="form-control datetimepicker9" placeholder="Date/Time">
                    <span id="cd-date-end" class="text-danger hidden"></span>
                  
                </div>
                <?php } else{ ?>
                <div class="col-md-12">
                 
                     <label>On Date/Time <i class="fa fa-calendar-o"></i></label>
                  
                     <input type="text" id="" value="<?php 
                  
                     if($event->startdate!=''){
                         $start_date=explode('T',$event->startdate);
                         $start_datetime=$start_date[0].' '.explode('+',$start_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($start_datetime));
                     
                     
                     ?>"  class="form-control" placeholder="Date/Time">
                    <span id="cd-date-start" class="text-danger hidden"></span>
                  
                </div>  
              <?php } ?>
                <div class="col-md-12">
                 
                     <label>Description</label>
                   <textarea name="cd-description"  class="form-control" placeholder="Tell people more about event" style="max-height: 90px; height: 90px;"><?php echo $event->description; ?></textarea>
                    <span id="cd-description" class="text-danger hidden"></span>
                    <input type="hidden" value="<?php echo $event->id; ?>" name="event_id" id="event_id">
                </div>
                 <div class="clearfix"></div>
          
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <?php if($event->event_type!=11){?> 
                <?php if($event->event_created_by== $this->session->userdata['marbel_user']['user_id']){?>
                <button type="submit" id="update-event" class="btn btn-success">Update</button>
                  <?php }  }?>
            </div>
            
           
     </div>
<script>
    $(document).ready(function(){
        
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
        $('body').find(".select_input").chosen({no_results_text: "Oops, nothing found!"}); 
    })
</script>