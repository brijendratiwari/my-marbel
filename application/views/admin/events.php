 <?php if(!empty($events)){ 
                                foreach($events as $key=>$val){
                                ?>
                            <div class="col-lg-12 form-group">
                            <div class="col-lg-9 get-event" data-eventId='<?php echo $val['id']; ?>'  data-target="#editEventModal" data-toggle="modal">
                                <i class="fa fa-calendar"></i> <a href="#"><?php echo substr($val['title'],0,9) . '...'; ?></a>
                            </div>
                            <div class="col-lg-3">
                                <a href="#"  class="text-danger"><i class="fa fa-trash"></i></a>
                            </div>
                            </div>
                                <?php } }else{ ?>
                                
<div class="col-lg-12 text-center">No Events found</div>

                                <?php } ?>
