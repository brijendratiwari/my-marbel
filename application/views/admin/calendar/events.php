 <?php if(!empty($events)){ 
                                foreach($events as $key=>$val){
                                ?>
                            <div class="col-lg-12 form-group"  style="font-size:12px;font-weight:bold;">
                            <div class="col-lg-9 get-event"  data-eventId='<?php echo $val['id']; ?>'  data-target="#editEventModal" data-toggle="modal">
                                <i class="fa fa-calendar"></i> <a href="#" style="color:black;"><?php echo substr($val['title'],0,10) . '...'; ?></a>
                            </div>
                            <div class="col-lg-3">
                                <a href="<?php echo base_url('delete_event/'.$val['id']);?>" onclick="return confirm('Are you sure to delete event permanently?');"  class="text-danger"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>
                                <?php } }else{ ?>
                                
<div class="col-lg-12 text-center">No Events found</div>

                                <?php } ?>
