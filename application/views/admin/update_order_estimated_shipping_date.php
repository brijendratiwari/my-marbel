<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="col-lg-6">

                    <div class="pull-left alert alert-success message"><?php echo $this->session->flashdata('success'); ?></div>
                </div> 
            <?php } ?>
              
           
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <form id="add-row-form" action="<?php echo base_url('update_orders') ?>" method="POST">
            
                
            <div class="col-lg-6 col-md-offset-3" style="margin-top: 10%">
                           
                              <div class=" panel panel-default">
                                <div class="panel-heading"  style='background-color: #cccccc !important;'>
                        <b>Update Orders </b>
                    </div>

                    <div class='panel-body'>
                            <div class="col-md-12 form-group">
                                <select id="cd-country" name="cd-country" class="form-control">
                                    <option value="">Please select a country</option>
                                    <option value="North American">North American</option>
                                    <option value="International">International</option>
                                </select>
                                <span  class="text-danger"><?php echo form_error('cd-country');?></span>
                            </div>
                           
                            <div class="col-md-12 form-group">
                                <select id="cd-priority" name="cd-priority" class="form-control">
                                    <option value="">Please select a priority</option>
                                    <option value="all">All</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                   
                                </select>
                                  <span  class="text-danger"><?php echo form_error('cd-priority');?></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <select id="cd-status" name="cd-status" class="form-control">
                                    <option value="">Please select a status</option>
                                    <option value="all">All</option>
                                    <option value="deposit">Deposit</option>
                                     <option value="balance">Balance</option>
                                     <option value="refunded">Refunded</option>
                                     <option value="building">Building</option>
                                      <option value="qa">Quality Assurance</option>
                                        <option value="shipping">Shipping</option>
                                    <option value="hold">On hold</option>
                                </select>
                                 <span  class="text-danger"><?php echo form_error('cd-status');?></span>
                            </div>
                        <div class="col-md-12 form-group" id="change-input">
                               <input type="number" name="cd-number-of-day" class="form-control" placeholder="Number of Day To Add" min="1" max="100">
                               <span  class="text-danger"><?php echo form_error('cd-number-of-day');?></span>
                            </div>
                       
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <a href="<?php echo base_url('orders');?>" class="btn">Cancel</a>
                           <button type="submit" id="add-row" class="btn btn-success">Update</button>
                        </div>
                              </div>
                              </div>
            </div>
        </form>
        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->

</div>

    <script>
    $(document).ready(function(){
        
        $('#cd-country').on('change',function(){
           
            var types=$(this).val();
            if(types==='North American'){
               
               $('#change-input').html('<input type="number" name="cd-number-of-day" class="form-control" placeholder="Number of Day To Add" min="1" max="100"><span  class="text-danger"><?php echo form_error('cd-number-of-day');?></span>')
                
            }else if(types==='International'){
                
                $('#change-input').html('<input type="number" name="cd-number-of-month" class="form-control" placeholder="Number of Day To Month" min="1" max="4"><span  class="text-danger"><?php echo form_error('cd-number-of-month');?></span>')
            }else{
                
                 $('#change-input').html('<input type="number" name="cd-number-of-day" class="form-control" placeholder="Number of Day To Add" min="1" max="100"><span  class="text-danger"><?php echo form_error('cd-number-of-day');?></span>')
            }
        });
        
    });
    </script>