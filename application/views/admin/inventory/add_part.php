<div id="page-wrapper" style="min-height: 453px;">
            <div class="row">
                <div style="margin-top: 2%;" class="col-lg-6">
                    <a class="btn btn-sm btn-default" href="<?php echo base_url('inventory');?>">Go Back</a>&nbsp;&nbsp;&nbsp; 
                 </div>
                <div class="col-lg-12">
                    <h1 class="page-header">Add Part</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Part
                        </div>
                        
                        <div class="panel-body">
                            <div class="row">
                                 <form role="form" method="post" id="addPart" enctype="multipart/form-data">
                                <div class="col-lg-6">
                                   
                                        <div class="form-group">
                                            <label>Part Number</label>
                                            <input class="form-control" disabled="" value="<?php echo $random_number; ?>" placeholder="Part Name">
                                            <input type="hidden" name="part_unique_number" value="<?php echo $random_number; ?>">
                                             <?php echo form_error('part_unique_number');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Part Name *</label>
                                            <input class="form-control" id="part_name"  value="<?php echo set_value('part_name'); ?>" name="part_name" placeholder="Part Name">
                                             <?php echo form_error('part_name');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Description *</label>
                                            <textarea rows="3" class="form-control"  id="part_description" name="part_description" placeholder="Part Description"><?php echo set_value('part_description'); ?></textarea>
                                             <?php echo form_error('part_description');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" name="part_image">
                                             <?php echo form_error('part_image');?>
                                        </div>
                                         <div class="form-group">
                                            <label>Category *</label>
                                            <select class="form-control select_input" name="part_category" >
                                                <?php foreach($part_category as $val){?>
                                                <option value="<?php echo $val['part_category_id'];?>" <?php echo ($val['part_category_id']==set_value('part_category')? 'selected="selected"':'')?>><?php echo ucfirst($val['part_category_name']);?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="text-danger"></p>
                                        </div>
                                         <div class="form-group">
                                            <label>Type *</label>
                                            <select class="form-control select_input" name="part_type">
                                               <?php foreach($part_type as $val){?>
                                                <option value="<?php echo $val['part_type_id'];?>" <?php echo ($val['part_type_id']==set_value('part_type')? 'selected="selected"':'')?>><?php echo ucfirst($val['part_type_name']);?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Main material</label>
                                            <input value="<?php echo set_value('part_main_material'); ?>" placeholder="Main Material" class="form-control" name="part_main_material" id="part_main_material"> 
                                               <?php echo form_error('part_main_material');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity *</label>
                                            <input placeholder="Quantity" value="<?php echo set_value('part_quantity'); ?>" class="form-control" name="part_quantity"  id="part_quantity">
                                             <?php echo form_error('part_quantity');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Auto Reorder</label>
                                          
                                            <input  type="checkbox" class="form-control" name="part_auto_reorder" id="part_auto_reorder" <?php echo (set_value('part_auto_reorder')=='on')?'checked':'';?>>
                                             <?php echo form_error('part_auto_reorder');?>
                                        </div>
                                        <div class="form-group">
                                            <label>Reorder Quantity</label>
                                            <input placeholder="Reorder Quantity" class="form-control number_only" name="part_reorder_quantity" id="part_reorder_quantity" value="<?php echo set_value('part_reorder_quantity'); ?>">
                                              <?php echo form_error('part_reorder_quantity');?>
                                        </div>
                                         <div class="form-group">
                                                <label>Cost *</label>
                                                <input placeholder="Cost" value="<?php echo set_value('part_cost'); ?>" class="form-control point_only" name="part_cost" id="part_cost">
                                             <?php echo form_error('part_cost');?>
                                            </div>
                                         <div class="form-group">
                                             <label>Weight <small>(in grams)</small>*</label>
                                                 <input value="<?php echo set_value('part_weight'); ?>" placeholder="Weight" class="form-control number_only" name="part_weight" id="part_weight">
                                                 <?php echo form_error('part_weight');?>
                                            </div>
                                    
                                      
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                   
                                        <fieldset>
                                           <div class="form-group">
                                                <label>Lead time in weeks *</label>
                                                 <input placeholder="Lead time in Weeks" value="<?php echo set_value('part_lead_time'); ?>" class="form-control number_only" name="part_lead_time" id="part_lead_time">
                                                   <?php echo form_error('part_lead_time');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Manufacturer *</label>
                                                 <input placeholder="Manufacturer" value="<?php echo set_value('part_manufacturer'); ?>" class="form-control" name="part_manufacturer" id="part_manufacturer">
                                              <?php echo form_error('part_manufacturer');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Manufacturer contact *</label>
                                                 <input placeholder="Manufacturer Contact" value="<?php echo set_value('part_manufacturer_contact'); ?>" class="form-control" name="part_manufacturer_contact" id="part_manufacturer_contact">
                                                  <?php echo form_error('part_manufacturer_contact');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Backup manufacturer</label>
                                                 <input placeholder="Backup Manufacturer" value="<?php echo set_value('part_backup_manufacturer'); ?>" class="form-control" name="part_backup_manufacturer" id="part_backup_manufacturer">
                                                  <?php echo form_error('part_backup_manufacturer');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Backup manufacturer contact</label>
                                                 <input placeholder="Backup Manufacturer Contact" class="form-control" name="part_backup_manufacturer_contact" id="part_backup_manufacturer_contact" value="<?php echo set_value('part_backup_manufacturer_contact'); ?>">
                                                 <?php echo form_error('part_backup_manufacturer_contact');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Last order *</label>
                                                 <input placeholder="Last Order" class="form-control" value="<?php echo set_value('part_last_order'); ?>" name="part_last_order" id="part_last_order">
                                                  <?php echo form_error('part_last_order');?>
                                            </div>
                                            <div class="form-group">
                                                <label>Price</label>
                                                 <input placeholder="Price" value="<?php echo set_value('part_price'); ?>" class="form-control point_only" name="part_price" id="part_price">
                                               <?php echo form_error('part_price');?>
                                            </div>
                                             <div class="form-group">
                                            <label>Notes *</label>
                                            <textarea rows="3" class="form-control" name="part_notes"  id="part_notes"><?php echo set_value('part_notes'); ?></textarea>
                                            <?php echo form_error('part_notes');?>
                                            </div>
                                           <button class="btn btn-custom" type="submit" id="submit_button">Submit</button>
                                           <a class="btn btn-default" href="<?php echo base_url("inventory")?>">Cancel</a>
                                        </fieldset>
                                  </div>
                                <!-- /.col-lg-6 (nested) -->
                                 </form>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
 <div class="checkout_loader" id="form_loader" style="display:none">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
<script>
 var base_url = $('body').find('#base_url').val();
    $(document).ready(function(){
    
  $('body').find(".select_input").chosen({no_results_text: "Oops, nothing found!"}); 
  $('body').find('.number_only').number(true);
  $('body').find('.point_only').number(true,2);
  $("[name='part_auto_reorder']").bootstrapSwitch({
     size:'small' 
  });


 
});


  

</script>