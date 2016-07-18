<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">

            <div class="col-lg-6">
             
                     <div id="taskSuccess" class="pull-left alert alert-success hidden message"></div>
                     <?php if($this->session->flashdata('success')){?>
                    
                     <div id="taskSuccess" class="pull-left alert alert-success  message"><?php echo $this->session->flashdata('success');?></div>
                     <?php } ?>
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
                        <table class="table table-striped table-bordered table-hover" id="task-assign-to-me-data" style="width:100% !important;">
                            <thead
                                <tr>
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Status</th>
                                    <th>Effort</th>
                                    <th>Value</th>
                                    <th>Due Date</th>
                                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                               
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
                        <table class="table table-striped table-bordered table-hover" id="task-assign-by-me-data"  style="width:100% !important;">
                            <thead
                                <tr>
                                    
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Status</th>
                                    <th>Effort</th>
                                    <th>Value</th>
                                    <th>Due Date</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
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
                        <table class="table table-striped table-bordered table-hover" id="task-completed-to-me-data"  style="width:100% !important;">
                            <thead
                                <tr>
                                   
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Status</th>
                                    <th>Complete Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                   
                               
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
                        <table class="table table-striped table-bordered table-hover" id="completed_task_assign_by_me-data"  style="width:100% !important;">
                            <thead
                                <tr>
                                  
                                    <th>Category</th>
                                    <th>Task Title</th>
                                    <th>Regarding</th>
                                    <th>Status</th>
                                    <th>Complete Date</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                     
                                </tr>
                            </thead>
                            <tbody>
                             
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
            <form name="task" method="post" action="" id="add-row-form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Task</h4>
            </div>
            <div class="modal-body profile-html">

               
                    <div class="col-lg-12" >


                        <div class="col-md-12 form-group">
                            <label>Task Name *</label>
                            <input type="text" name="cd-taskname" class="form-control" placeholder="Task Name -What to do">
                            <span id="cd-taskname" class="text-danger"><?php echo form_error('cd-taskname'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Select Category *</label>
                            <select  name="cd-category" class="form-control select_input" >
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
                            <label>Select Assignee </label><small><b> - who should Do this task</b></small>
                            <select  name="cd-assignee" class="form-control select_input">
                               
                                <?php if ($assignee) {
                                    foreach ($assignee as $name) {

                                        if($name['id']==$this->session->userdata['marbel_user']['user_id']){
                                        ?>

                                <option value="<?php echo $name['id']; ?>" selected="selected">Self - I will do it</option>
                                  <?php }else{ ?>
                                  
                                <option value="<?php echo $name['id']; ?>"><?php echo ucwords($name['first_name'] . ' ' . $name['last_name']) . '(' . $name['user_role_type'] . ')'; ?></option>
                                  <?php    } } }?>

                            </select>
                            <span id="cd-assignee" class="text-danger"><?php echo form_error('cd-assignee'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                             <label>Due Date</label>
                            <input type="text" name="cd-duedate"  class="form-control duedate" placeholder="Due Date" readonly="readonly" >
                            <span id="cd-duedate" class="text-danger"><?php echo form_error('cd-duedate'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Regarding</label>
                             <select  name="cd-regarding" class="form-control select_input">
                                <option value="">User name - who is this task about</option>
                                <?php if ($regarding) {
                                    foreach ($regarding as $name) {?>
                                <option value="<?php echo $name['id']; ?>"><?php echo ucwords($name['first_name'] . ' ' . $name['last_name']) . '(' . $name['user_role_type'] . ')'; ?></option>
                                  <?php     } }?>

                            </select>
                          
                            <span id="cd-regarding" class="text-danger"><?php echo form_error('cd-regarding'); ?></span>
                        </div>
                         <div class="col-md-12 form-group">
                             <label>Effort </label><small><b> - How difficult is this task</b></small>(1 = easy / 100 = full attention)
                            <select  name="cd-effort" class="form-control select_input">
                               <option value="">Effort</option>
                                <option value="1">1</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>

                            </select>
                            <span id="cd-effort" class="text-danger"><?php echo form_error('cd-effort'); ?></span>
                        </div>
                       <div class="col-md-12 form-group">
                             <label>Value </label><small><b> - How important is this task</b></small>(100 = low / 1000 = high)
                            <select  name="cd-value" class="form-control select_input">
                               <option value="">Value</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="1000">1000</option>

                            </select>
                            <span id="cd-value" class="text-danger"><?php echo form_error('cd-value'); ?></span>
                        </div>
                        <div class="col-md-12 form-group">
                             <label>Details -</label>
                             <textarea style="width: 510px; height: 216px;" placeholder="The specifics about this task...if any" class="form-control" name="cd-details"></textarea>
                            <span id="cd-detail" class="text-danger"><?php echo form_error('cd-detail'); ?></span>
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
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Task</h4>
            </div>
            <div class="modal-body profile-html edtttask">

               
                    

            </div>
           
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
         
          
         $('body').on('click', '.edit-task', function () {

            var task_id = $(this).attr('data-id');
            $('body').find('.edtttask').html('');
            $('body').find('.checkout_loader').removeClass('hidden');
            $('body').find('.edtttask').load("<?php echo base_url('edit_task'); ?>/" + task_id + "",function(response){
                if(response){
                    $('body').find('.checkout_loader').addClass('hidden');
                }
            });
        })
         /* date picker */
        $('.duedate').datepicker({
            'format': 'mm/dd/yyyy',
             startDate: new Date()
        });
        $('body').find(".select_input").chosen({no_results_text: "Oops, nothing found!"}); 
        })
</script>

<style>
    .pagination > li > a, .pagination > li > span{
        
        padding:0px 5px !important;
    }
    .chosen-container {
        width:100% !important;
    }
</style>