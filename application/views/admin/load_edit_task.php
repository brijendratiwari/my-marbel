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
                            <?php echo date('m/d/Y' ,  strtotime($tasks['task_due_date']));?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                        <div class="col-md-6 form-group">

                            <label> Regarding : </label>

                            
                        </div>
                        <div class="col-md-6 form-group">
                            <?php echo $tasks['task_regarding'];?>
                        </div>
                        </div>
                        <div class="col-lg-12" >
                       
                            <div class="col-md-6 form-group">  
                           <label> Status : </label>
                            </div> 
                            <div class="col-md-6 form-group ">  
                            
                           <select  name="cd-status" class="form-control">
                                <option value="Completed">Completed</option>
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