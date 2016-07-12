      <form name="task" method="post" action="<?php echo base_url('update_task/'.$tasks['task_id']);?>" id="edit-row-form">

                    <div class="col-lg-12" >

                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Task name : </label>
                           
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['task_name'];?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Category : </label>

                          

                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['category_name'];?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">
                            <label>Assignee name : </label>

                           
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['assign_to_name'];?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Due date : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo (($tasks['task_due_date']!='' && $tasks['task_due_date']!='0000-00-00')? date('m/d/Y', strtotime($tasks['task_due_date'])):'N/A');?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Completed date : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo (($tasks['task_completed_date']!='' && $tasks['task_completed_date']!='0000-00-00')? date('m/d/Y', strtotime($tasks['task_completed_date'])):'Not Completed');?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Regarding : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo (!empty($tasks['task_regarding']))?$tasks['task_regarding']:"N/A";?>
                        </div>
                        </div>
                        
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Effort : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['task_effort'];?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Value : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['task_value'];?>
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