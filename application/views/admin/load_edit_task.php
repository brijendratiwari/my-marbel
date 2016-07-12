      <form name="task" method="post" action="<?php echo base_url('update_task/'.$tasks['task_id']);?>" id="edit-row-form">

                    <div class="col-lg-12" >

                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Task name : </label>
                           
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" name="cd-taskname" class="form-control" placeholder="Task Name" value="<?php echo $tasks['task_name'];?>">
                            <span id="cd-taskname" class="text-danger"><?php echo form_error('cd-taskname'); ?></span>
                            
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Category : </label>

                          

                        </div>
                        <div class="col-md-6 form-group">
                             <select  name="cd-category" class="form-control" >
                                <option value="">Select Category</option>
                                <?php if ($category) {
                                    foreach ($category as $name) {
                                        ?>

                                        <option value="<?php echo $name['cat_id']; ?>" <?php if (strcmp($tasks['task_cat_id'], $name['cat_id']) == 0) {
                echo 'selected="selected"';
            } ?>><?php echo $name['cat_name']; ?></option>
                                    <?php }
                                }
                                ?>


                            </select>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Assignee name : </label>

                           
                        </div>
                        <div class="col-md-6 form-group">
                             
                            <select  name="cd-assignee" class="form-control">
                                <option value="">Select Assignee</option>
                                <?php if ($assignee) {
                                    foreach ($assignee as $name) {

                                        //if($name['id']!=$this->session->userdata['marbel_user']['user_id']){
                                        ?>

                                        <option value="<?php echo $name['id']; ?>" <?php if (strcmp($tasks['task_assign_to'], $name['id']) == 0) {
                echo 'selected="selected"';
            } ?>><?php echo $name['first_name'] . ' ' . $name['last_name'] . '(' . $name['user_role_type'] . ')'; ?></option>
                                  <?php //}
                                  } }?>

                            </select>
                            <span id="cd-assignee" class="text-danger"><?php echo form_error('cd-assignee'); ?></span>
                           
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Due date : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" name="cd-duedate"  class="form-control duedate" placeholder="Due Date" readonly="readonly" value=" <?php echo (($tasks['task_due_date']!='' && $tasks['task_due_date']!='0000-00-00')? date('m/d/Y', strtotime($tasks['task_due_date'])):'');?>">
                            <span id="cd-duedate" class="text-danger"><?php echo form_error('cd-duedate'); ?></span>
                           
                        </div>
                        </div>
<!--                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Completed date : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo (($tasks['task_completed_date']!='' && $tasks['task_completed_date']!='0000-00-00')? date('m/d/Y', strtotime($tasks['task_completed_date'])):'Not Completed');?>
                        </div>
                        </div>-->
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Regarding : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" name="cd-regarding"  class="form-control" placeholder="Regarding" id="cd-regarding" value="<?php echo (!empty($tasks['task_regarding']))?$tasks['task_regarding']:"";?>">
                            <span id="cd-regarding" class="text-danger"><?php echo form_error('cd-regarding'); ?></span>
                            
                        </div>
                        </div>
                        
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Effort : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                          
                            <select  name="cd-effort" class="form-control">
                               <option value="">Effort</option>
                                <option value="1" <?php if (strcmp($tasks['task_effort'], '1') == 0) {
                echo 'selected="selected"';
            } ?>>1</option>
                                <option value="10"<?php if (strcmp($tasks['task_effort'], '10') == 0) {
                echo 'selected="selected"';
            } ?>>10</option>
                                <option value="25"<?php if (strcmp($tasks['task_effort'], '25') == 0) {
                echo 'selected="selected"';
            } ?>>25</option>
                                <option value="50"<?php if (strcmp($tasks['task_effort'], '50') == 0) {
                echo 'selected="selected"';
            } ?>>50</option>
                                <option value="100"<?php if (strcmp($tasks['task_effort'], '100') == 0) {
                echo 'selected="selected"';
            } ?>>100</option>

                            </select>
                            <span id="cd-effort" class="text-danger"><?php echo form_error('cd-effort'); ?></span>
                           
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Value : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                             <select  name="cd-value" class="form-control">
                               <option value="">Value</option>
                                <option value="100" <?php if (strcmp($tasks['task_value'], '100') == 0) {
                echo 'selected="selected"';
            } ?>>100</option>
                                <option value="200" <?php if (strcmp($tasks['task_value'], '200') == 0) {
                echo 'selected="selected"';
            } ?>>200</option>
                                <option value="300" <?php if (strcmp($tasks['task_value'], '300') == 0) {
                echo 'selected="selected"';
            } ?>>300</option>
                                <option value="400" <?php if (strcmp($tasks['task_value'], '400') == 0) {
                echo 'selected="selected"';
            } ?>>400</option>
                                <option value="500" <?php if (strcmp($tasks['task_value'], '500') == 0) {
                echo 'selected="selected"';
            } ?>>500</option>
                                <option value="600" <?php if (strcmp($tasks['task_value'], '600') == 0) {
                echo 'selected="selected"';
            } ?>>600</option>
                                <option value="700" <?php if (strcmp($tasks['task_value'], '700') == 0) {
                echo 'selected="selected"';
            } ?>>700</option>
                                <option value="800" <?php if (strcmp($tasks['task_value'], '800') == 0) {
                echo 'selected="selected"';
            } ?>>800</option>
                                <option value="900" <?php if (strcmp($tasks['task_value'], '900') == 0) {
                echo 'selected="selected"';
            } ?>>900</option>
                                <option value="1000" <?php if (strcmp($tasks['task_value'], '1000') == 0) {
                echo 'selected="selected"';
            } ?>>1000</option>

                            </select>
                            <span id="cd-value" class="text-danger"><?php echo form_error('cd-value'); ?></span>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                       
                            <div class="col-md-6 form-group">  
                           <label> Status : </label>
                            </div> 
                            <div class="col-md-6 form-group ">  
                            
                           <select  name="cd-status" class="form-control">
                               <option value="To Do" <?php if (strcmp($tasks['task_status'], 'To Do') == 0) {
                echo 'selected="selected"';
            } ?>>To Do</option>
                               <option value="Testing" <?php if (strcmp($tasks['task_status'], 'Testing') == 0) {
                echo 'selected="selected"';
            } ?>>Testing</option>
                               <option value="In Progress" <?php if (strcmp($tasks['task_status'], 'In Progress') == 0) {
                echo 'selected="selected"';
            } ?>>In Progress</option>
                                <option value="Finished" <?php if (strcmp($tasks['task_status'], 'Finished') == 0) {
                echo 'selected="selected"';
            } ?>>Finished</option>
                            </select>
                          </div> 
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="add-row" class="btn btn-success">Update</button>
                    </div>
                </form>
<script>
$(document).ready(function(){
    
     /* date picker */
        $('.duedate').datepicker({
            'format': 'yyyy-mm-dd',
             startDate: new Date()
        });
    
});
</script>