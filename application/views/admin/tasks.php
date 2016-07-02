<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="col-lg-6">
             
                     <div id="taskSuccess" class="pull-left alert alert-success hidden message"></div>
               
            </div>   

            
           <div class="col-lg-6 page-header text-right"><button  class="btn btn-custom" data-toggle="modal" data-target="#taskModal">Add Task</button></div>
          
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row" >


        <div class="col-lg-12" >


            <div class="col-lg-6">
                <div class="panel panel-default" >

                    <div class="panel-heading"  style=' background-color: #cccccc !important;'>
                        <b>Assigned To Me</b>
                    </div>

                    <div class='panel-body'>
                        <table class="table table-striped table-bordered table-hover"  style="width:100% !important;">
                            <thead
                                <tr>
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Due Date</th>
                                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($pending_task_to){
                                    foreach($pending_task_to as $task){?>
                                         <tr>
                                             <td><span style="color: #00aeef;"><i class="fa fa-circle"></i></span> <?php echo $task['category_name'];?></td>
                                        <td><?php echo $task['task_name'];?></td> 
                                        <td><?php echo $task['task_regarding'];?></td>
                                        <td><?php echo date('m/d/Y', strtotime($task['task_due_date']));?></td>
                                        <td><a class="btn btn-xs btn-success" href="#" class="btn btn-custom" data-toggle="modal" data-target="#editTaskModal"><i class="fa fa-eye"></i> View</a></td>

                                </tr>
                                
                                   <?php }
                                }else{
                                    echo "<tr><td colspan='4'>No record found!</td></tr>";
                                }
                                ?>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="panel panel-default">

                    <div class="panel-heading"  style=' background-color: #cccccc !important;'>
                        <b> Assigned By Me</b>
                    </div>

                    <div class='panel-body'>
                        <table class="table table-striped table-bordered table-hover"  style="width:100% !important;">
                            <thead
                                <tr>
                                    
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php  if($pending_task_by){
                                    foreach($pending_task_by as $task){?>
                                         <tr>
                                        <td><span style="color: #00aeef;"><i class="fa fa-circle"></i></span> <?php echo $task['category_name'];?></td>
                                        <td><?php echo $task['task_name'];?></td> 
                                        <td><?php echo $task['task_regarding'];?></td>
                                        <td><?php echo date('m/d/Y', strtotime($task['task_due_date']));?></td>
                                        <td><?php echo $task['assign_to_name'];?></td>

                                </tr>
                                
                                   <?php }
                                }else{
                                    echo "<tr><td colspan='5'>No record found!</td></tr>";
                                }
                                ?>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-6">
                <div class="panel panel-default">

                    <div class="panel-heading"  style='background-color: #cccccc !important;'>
                        <b>Completed Tasks</b>
                    </div>

                    <div class='panel-body'>
                        <table class="table table-striped table-bordered table-hover"  style="width:100% !important;">
                            <thead
                                <tr>
                                   
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    <?php if($completed_task_to){
                                    foreach($completed_task_to as $task){?>
                                         <tr>
                                        <td><span><i class="fa fa-check"></i></span> <?php echo $task['category_name'];?></td>
                                        <td><?php echo $task['task_name'];?></td> 
                                        <td><?php echo $task['task_regarding'];?></td>
                                        <td><?php echo date('m/d/Y', strtotime($task['task_due_date']));?></td>
                                         
                                </tr>
                                
                                   <?php }
                                }else{
                                    echo "<tr><td colspan='4'>No record found!</td></tr>";
                                }
                                ?>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default" >

                    <div class="panel-heading"  style='background-color: #cccccc !important;'>
                        <b>Completed Tasks</b>
                    </div>

                    <div class='panel-body'>
                        <table class="table table-striped table-bordered table-hover"  style="width:100% !important;">
                            <thead
                                <tr>
                                  
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                     
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   
                                 
                                    <?php if($completed_task_by){
                                    foreach($completed_task_by as $task){?>
                                         <tr>
                                             <td><span><i class="fa fa-check"></i></span> <?php echo $task['category_name'];?></td>
                                        <td><?php echo $task['task_name'];?></td> 
                                        <td><?php echo $task['task_regarding'];?></td>
                                        <td><?php echo date('m/d/Y', strtotime($task['task_due_date']));?></td>
                                         <td><?php echo $task['assign_to_name'];?></td>
                                         
                                </tr>
                                
                                   <?php }
                                }else{
                                    echo "<tr><td colspan='5'>No record found!</td></tr>";
                                }
                                ?>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--model box -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
    <div class="modal-dialog user-profile">
        <div class="modal-content">
            <form name="task" method="post" action="" id="edit-row-form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Task</h4>
            </div>
            <div class="modal-body profile-html">

               
                    <div class="col-lg-12" >


                        <div class="col-md-12 form-group">
                            <input type="text" name="cd-taskname" class="form-control" placeholder="* Task Name">
                            <span id="cd-taskname" class="text-danger"><?php echo form_error('cd-taskname'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">

                            <select  name="cd-category" class="form-control" >
                                <option value="">Select Category</option>
                                <?php if ($category) {
                                    foreach ($category as $name) {
                                        ?>

                                        <option value="<?php echo $name['cat_id']; ?>"><?php echo $name['cat_name']; ?></option>
                                    <?php }
                                }
                                ?>


                            </select>

                            <span id="cd-category" class="text-danger"><?php echo form_error('cd-category'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <select  name="cd-assignee" class="form-control">
                                <option value="">Select Assignee</option>
<?php if ($assignee) {
    foreach ($assignee as $name) {
        ?>

                                        <option value="<?php echo $name['id']; ?>"><?php echo $name['first_name'] . ' ' . $name['last_name'] . '(' . $name['user_role_type'] . ')'; ?></option>
    <?php }
}
?>

                            </select>
                            <span id="cd-assignee" class="text-danger"><?php echo form_error('cd-assignee'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" name="cd-duedate"  class="form-control duedate" placeholder="* Due Date" readonly="readonly" >
                            <span id="cd-duedate" class="text-danger"><?php echo form_error('cd-duedate'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" name="cd-regarding"  class="form-control" placeholder="* Regarding" id="cd-regarding">
                            <span id="cd-regarding" class="text-danger"><?php echo form_error('cd-regarding'); ?></span>
                        </div>
                
                       
                    </div>

            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" id="add-row" class="btn btn-success">Create</button>
            </div>
                            </form>

        </div>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>

</div>
<!--//-->
<!--edit model box -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);display: none;">
    <div class="modal-dialog user-profile">
        <div class="modal-content">
            <form name="task" method="post" action="<?php base_url('add_task'); ?>" id="add-row-form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Task</h4>
            </div>
            <div class="modal-body profile-html">

               
                    <div class="col-lg-12" >


                        <div class="col-md-12 form-group">
                            <label>Task name</label>
                           test
                        </div>
                        <div class="col-md-12 form-group">
                              <label>Category</label>
                       
                              test
                           
                        </div>
                        <div class="col-md-12 form-group">
                           <label>Assignee name</label>
                       
                              test
                        </div>
                        <div class="col-md-12 form-group">
                           
                            <label> Due date </label>
                       
                              test
                        </div>
                        <div class="col-md-12 form-group">
                           
                            <label> Regarding</label>
                       
                              test
                        </div>
                        <div class="col-md-12 form-group">
                            <select  name="cd-status" class="form-control">
                              
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Doing">Doing</option>
                            </select>
                            <span id="cd-assignee" class="text-danger"><?php echo form_error('cd-status'); ?></span>
                        </div>
                       
                    </div>

            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                 <button type="submit" id="add-row" class="btn btn-success">Update</button>
            </div>
                            </form>

        </div>
        <div class="checkout_loader hidden" id="form_loader">
            <div class="overlay new_loader"></div>
            <div class="new_loader_img"><img class="" src="<?php echo base_url('assets/images/chekout-loading.gif'); ?>" /></div>
        </div>
    </div>

</div>
<!--//-->
<script>
$(document).ready(function(){
    
      var base_url = $('body').find('#base_url').val();
    
        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#taskModal #form_loader').removeClass('hidden');
            },
            url: base_url+'add_task',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#taskModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#taskModal #" + index2).text(msg);
                            $("#taskModal #" + index2).removeClass('hidden');
                        });
                    });
                }
                else {
                    $('body').find('#taskModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#taskModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#taskSuccess").text(err.success);
                        $("#taskSuccess").removeClass('hidden');
                        $('body').find('#taskModal').modal('hide');
                         setTimeout(function () {
                             window.location.href=base_url+'tasks';
                        }, 500)
                       
                  }
                    else {
                        $('body').find('#usersModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        setTimeout(function () {
                            $('body').find('#usersModal').modal('hide');
                        }, 500)
                    }
                }
            }
        };
        $('body').find('#add-row-form').ajaxForm(options);
                
       
         /* date picker */
        $('.duedate').datepicker({
            'format': 'yyyy-mm-dd',
             startDate: new Date()
        });
        })
</script>