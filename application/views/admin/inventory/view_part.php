 <!-- Page Content -->
        <div id="page-wrapper">
                
                <div class="row">
                    <div style="margin-top: 2%;" class="col-lg-6">
                    <a class="btn btn-sm btn-default" href="<?php echo base_url('inventory');?>">Go Back</a>&nbsp;&nbsp;&nbsp; 
                 </div>
                    <div class="col-lg-12 ">
                        <h1 class="page-header">Part Information</h1>
                        
                        
                        <!--user info page-->
                            <div class="col-md-12 col-offset-sm-1">
                            <div class="col-md-6">
                           
                               <?php if($part_detail['part_image']!==''){?>
                                <img alt="140x140" class="img-responsive image_tag" data-src="holder.js/140x140" style="width: 300px; height: 150px; float: left;" src="<?php echo base_url().'assets/inventory-imgs/'.$part_detail['part_image'];?>" data-holder-rendered="true"><span style="margin-left: 2%;"><button class="btn btn-xs btn-custom update_img_button" href="edit_customer/4"><i class="fa fa-edit"></i></button></span>
                               <?php }else{ ?>
                                  <img alt="140x140" class="img-responsive" data-src="holder.js/140x140" style="width: 300px; height: 150px; float: left;" src="<?php echo base_url().'assets/img/no_image_available.jpg';?>" data-holder-rendered="true"><span style="margin-left: 2%;"><button class="btn btn-xs btn-custom update_img_button" href="edit_customer/4"><i class="fa fa-edit"></i></button></span>   
                            <?php   } ?>
                             <form id="update_image_form" style="display:none" action="<?php echo base_url().'inventory/update_image';?>" method="post">     
                             <div class="col-md-12">     
                           
                             <br><input type="file" name="part_image">
                             <p class="text-danger"  id="part_image"><?php echo form_error('part_image');?></p>
                             <input type="hidden" name="part_id" value="<?php echo $part_detail['part_id'];?>">
                             <input type="hidden" name="pervious_image" id="pervious_image" value="<?php echo $part_detail['part_image'];?>">
                             
                             </div>
                             <div class="col-md-12">      
                                 <button class="btn btn-xs btn-custom" type="submit">Update</button>
                             </div>
                             </form>
                             </div>
                             <div class="col-md-6">
                               <div class="panel panel-default">
                                    <div class="panel-heading"><?php echo $part_detail['part_name'];?></div>
                                    <div class="panel-body">
                                    <p><?php echo $part_detail['part_description'];?></p>   
                                    </div>
                            </div>      
                             </div>  
                            </div>
                        <div class="clearfix"></div>
                              <div class="col-md-12 col-offset-sm-1">
                                  
                                <div class="col-md-6">                            
                                <div class="panel panel-default">
                                    <div class="panel-heading">Manufacturer</div>
                                    <div class="panel-body">
                                        <p><?php echo $part_detail['part_manufacturer'];?></p>  
                                        <p><?php echo $part_detail['part_manufacturer_contact'];?></p>  
                                     <?php if($part_detail['part_backup_manufacturer']!=''){?>
                                        <h4>Backup manufacturer</h4>
                                        <p><?php echo $part_detail['part_backup_manufacturer'];?></p>  
                                        <p><?php echo $part_detail['part_backup_manufacturer_contact'];?></p> 
                                         
                                         <?php  }?>
                                            
                                    </div>
                                </div>
                                </div>
                               <div class="col-md-6">     
                               <h3 style="margin: 0px;">
                                        Cost : <?php echo '$'.$part_detail['part_cost'];?>
                               </h3>
                               <h3 style="margin-bottom:10px;">
                                         Weight : <?php echo $part_detail['part_weight'].' grams';?>
                               </h3>
                               <h3 style="margin-bottom:10px;">
                                       Lead Time in Weeks : <?php echo $part_detail['part_lead_time'];?>
                               </h3>
                                                                       
                               </div>
                               </div>
                        <div class="clearfix"></div>
                              <div class="col-md-12 col-offset-sm-1">
                                  
                                <div class="col-md-6">                            
                                <div class="panel panel-default">
                                    <div class="panel-heading">Contact</div>
                                    <div class="panel-body">
                                        <p><?php echo $user_detail['email'];?></p>    
                                        <p><?php echo $user_detail['phone'];?></p>    
                                        
                                            
                                    </div>
                                </div>
                                </div>
                               <div class="col-md-6">     
                               <div class="panel panel-default">
                                    <div class="panel-heading">Last Order</div>
                                    <div class="panel-body">
                                        <p><?php echo $part_detail['part_last_order'];?></p>   
                                        
                                            
                                    </div>
                                </div>
                               </div>
                               </div>
                             <div class="col-md-12 col-offset-sm-1">
                              <div class="col-md-6">    
                              <div class="panel panel-default">
                                    <div class="panel-heading">Note</div>
                                    <div class="panel-body">
                                     <p><?php echo $part_detail['part_notes'];?></p>   
                                    </div>
                              </div></div>
                             </div>
                       </div>
                           
                    
                      
                    <!-- /.col-lg-12 -->
                
                         
                      
                    </div>
                   
                <!-- /.row -->
          
        </div>
        <!-- /#page-wrapper -->
        
        
        <!--user modal ..-->

    
<!-- // user modal ..-->
<!--Reset password model-->
<!---//...end-->
<script>
        var base_url = $('body').find('#base_url').val();
   //resset password
     $(document).ready(function () {

         
         
        $('.update_img_button').click(function(){
        $('#update_image_form').toggle();    
        }); 
        // Script for validate and submit remind form by AJAX...
      });
      
        $('#update_image_form').ajaxForm(function(data) {
            var err = $.parseJSON(data);
            if (err.result == false) {
                $.each(err.error, function(index, value) {
                    $("#" + index).text(value);
                });
            }
            else {
                if (err.result) {
                  var url = base_url+'assets/inventory-imgs/'+err.image_name;  
                  $('.image_tag').attr('src',url);   
                  $('#pervious_image').val(err.image_name);   
                }
            }
        });
   // JavaScript Document
   </script>
   <style>
    .col-md-12 {
    margin-bottom: 3%;
}   
       
   </style>