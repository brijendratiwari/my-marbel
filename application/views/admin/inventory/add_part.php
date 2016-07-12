<div id="page-wrapper" style="min-height: 453px;">
            <div class="row">
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
                                 <form role="form" method="post" id="addPart">
                                <div class="col-lg-6">
                                   
                                        <div class="form-group">
                                            <label>Part Name *</label>
                                            <input class="form-control" id="part_name" name="part_name" placeholder="Part Name">
                                            <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="3" class="form-control" id="part_description" name="part_description" placeholder="Part Description"></textarea>
                                             <p class="text-danger"></p>
                                        </div>
                                         <div class="form-group">
                                            <label>Category *</label>
                                            <select class="form-control select_input" name="part_category" >
                                                <?php foreach($part_category as $val){?>
                                                <option value="<?php echo $val['part_category_id'];?>"><?php echo ucfirst($val['part_category_name']);?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="text-danger"></p>
                                        </div>
                                         <div class="form-group">
                                            <label>Type *</label>
                                            <select class="form-control select_input" name="part_type">
                                               <?php foreach($part_type as $val){?>
                                                <option value="<?php echo $val['part_type_id'];?>"><?php echo ucfirst($val['part_type_name']);?></option>
                                                <?php } ?>
                                            </select>
                                             <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Main material *</label>
                                            <input placeholder="Main Material" class="form-control" name="part_main_material" id="part_main_material"> 
                                             <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity *</label>
                                            <input placeholder="Quantity" class="form-control number_only" name="part_quantity"  id="part_quantity">
                                              <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Reorder Quantity</label>
                                            <input placeholder="Reorder Quantity" class="form-control number_only" name="part_reorder_quantity" id="part_reorder_quantity">
                                              <p class="text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Auto Reorder</label>
                                            <input type="checkbox" class="form-control" name="part_auto_reorder" id="part_auto_reorder">
                                               <p class="text-danger"></p>
                                        </div>
                                         <div class="form-group">
                                                <label>Cost *</label>
                                                <input placeholder="Cost" class="form-control point_only" name="part_cost" id="part_cost">
                                              <p class="text-danger"></p>
                                            </div>
                                         <div class="form-group">
                                                <label>Weight *</label>
                                                 <input placeholder="Weight" class="form-control point_only" name="part_weight" id="part_weight">
                                                  <p class="text-danger"></p>
                                            </div>
                                    
                                      
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                   
                                        <fieldset>
                                           <div class="form-group">
                                                <label>Lead time in weeks *</label>
                                                 <input placeholder="Lead time in Weeks" class="form-control number_only" name="part_lead_time" id="part_lead_time">
                                                   <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Manufacturer *</label>
                                                 <input placeholder="Manufacturer" class="form-control" name="part_manufacturer" id="part_manufacturer">
                                             <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Manufacturer contact *</label>
                                                 <input placeholder="Manufacturer Contact" class="form-control" name="part_manufacturer_contact" id="part_manufacturer_contact">
                                                   <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Backup manufacturer</label>
                                                 <input placeholder="Backup Manufacturer" class="form-control" name="part_backup_manufacturer" id="part_backup_manufacturer">
                                                   <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Backup manufacturer contact</label>
                                                 <input placeholder="Backup Manufacturer Contact" class="form-control" name="part_backup_manufacturer_contact" id="part_backup_manufacturer_contact">
                                                   <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Last order</label>
                                                 <input placeholder="Last Order" class="form-control" name="part_last_order" id="part_last_order">
                                                   <p class="text-danger"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Price *</label>
                                                 <input placeholder="Price" class="form-control point_only" name="part_price" id="part_price">
                                                   <p class="text-danger"></p>
                                            </div>
                                             <div class="form-group">
                                            <label>Notes</label>
                                            <textarea rows="3" class="form-control" name="part_notes" id="part_notes"></textarea>
                                              <p class="text-danger"></p>
                                            </div>
                                           <button class="btn btn-primary" type="submit" id="submit_button">Submit</button>
                                        <button class="btn btn-default" type="reset">Cancel</button>
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
  $('body').find('.point_only').number(true,3);
  $("[name='part_auto_reorder']").bootstrapSwitch({
     size:'small' 
  });


});

$(document).ajaxStart(function(){
    $(".checkout_loader").css("display", "block");
});

$(document).ajaxComplete(function(){
    $(".checkout_loader").css("display", "none");
}); 

  $('#addPart').ajaxForm(function(data) {
             var err = $.parseJSON(data);       
            if (err.result == false) {
                   
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#addPart #" + index2).next('.text-danger').text(msg);
                        });
                    });
             }else{
              if (err.result) {
                  $(".checkout_loader").css("display", "block");
                    window.location.href = base_url + 'inventory';
                }   
                 
             } 
        });
  

</script>