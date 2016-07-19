  <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="col-md-12">
                    <?php if($event->user_profile_pic!=''){?>
                   
                    <a href="<?php echo base_url('get_customer_info/'.$event->user_id)?>"><img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 30px; height: 30px;" src="<?php echo base_url('assets/profile-imgs/'.$event->user_profile_pic.''); ?>" data-holder-rendered="true"></a>
                    <?php }else{ ?>
                    <a href="<?php echo base_url('get_customer_info/'.$event->user_id)?>"> <img alt="140x140" class="img-circle" data-src="holder.js/140x140" style="width: 30px; height: 30px;" src="<?php echo base_url('assets/img/ui-sam.jpg'); ?>" data-holder-rendered="true"></a>
                    <?php } ?>
                     <span style="font-size:20px;color:#00aeef;"><?php echo $event->first_name.' '.$event->last_name; ?></span> - <span style="font-size:20px;color:grey"><?php echo $event->title; ?></span>
                </div>
                </div>
           
            
<div class="modal-body">

                <?php if($event->event_type!=11){?>
                <div class="col-md-12">
                <div class="col-md-4 form-group">
                     <label>Location :</label></div>
                  
                    <div class="col-md-8 form-group"><?php echo $event->location; ?></div>
               
                </div>
                <div class="col-md-12">
                     <div class="col-md-4 form-group"><label>Type :</label></div>
                     <div class="col-md-8 form-group">Task related</div>
                </div>
    
                <div class="col-md-12">
                    <div class="col-md-4 form-group"><label>Start :</label></div>
                     <div class="col-md-8 form-group"><?php 
                     if($event->startdate!=''){
                         $start_date=explode('T',$event->startdate);
                         $start_datetime=$start_date[0].' '.explode('+',$start_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($start_datetime));
                     
                     ?></div>
                </div>
                 <div class="col-md-12">
                 
                     <div class="col-md-4 form-group"><label>End :</label></div>
                  
                  <div class="col-md-8 form-group">  <?php 
                  
                     if($event->enddate!=''){
                         $end_date=explode('T',$event->enddate);
                         $end_datetime=$end_date[0].' '.explode('+',$end_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($end_datetime));
                     
                     
                     ?>
                  
                </div>
                </div>
                <?php } else{ ?>
                <div class="col-md-12">
                <div class="col-md-4 form-group">
                     <label>On Date/Time : </label></div>
                     <div class="col-md-8 form-group"><?php 
                  
                     if($event->startdate!=''){
                         $start_date=explode('T',$event->startdate);
                         $start_datetime=$start_date[0].' '.explode('+',$start_date[1])[0];
                     }
                         echo date('m/d/Y h:i A',strtotime($start_datetime));
                     
                     
                     ?>
                  
                </div>  
                </div>  
              <?php } ?>
                <div class="col-md-12">
                <div class="col-md-4 form-group">
                 
                     <label>Details : </label> </div>
                   <div class="col-md-8 form-group"> <?php echo $event->description; ?>
                </div>
                </div>
                 <div class="clearfix"></div>
          
            <div class="modal-footer">
                  <?php if($event->event_type!=11){?> 
                <?php if($event->event_created_by== $this->session->userdata['marbel_user']['user_id']){?>
                <a href="<?php echo base_url('delete_event/'.$event->id);?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger pull-left">Delete</a>
                <button type="button" data-event="<?php echo $event->id; ?>" id="edit-event" class="btn btn-custom">Edit</button>
                  <?php }  }?>
            </div>
            
           
     </div>
      </div>     
<script>
    $(document).ready(function(){
        
       $('body').on('click','#edit-event',function(){
           
           var id = $(this).attr('data-event');
           
           $('body').find('#viewEventModal').modal('hide');
           //$('body').find('#editEventModal').modal('hide');
           
            $('body').find('#editEventModal .checkout_loader').removeClass('hidden');
                $('body').find('#editEventModal').modal('show');
                $('body').find('.update-event-data').load("<?php echo base_url('admin/calendar/getSingleEvent'); ?>/" + id + "",function(response){
                    
                    if(response){
                    
                     $('body').find('#editEventModal .checkout_loader').addClass('hidden');
                        
                    }
                });
           
       })
     
    })
</script>