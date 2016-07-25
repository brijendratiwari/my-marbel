<form name="task" method="post" action="" id="edit-row-form">

    <div class="col-lg-12" >

        <div class="col-lg-12 form-group" >

            <label>Task name : </label>


            <input type="text" name="cd-taskname" class="form-control" placeholder="Task Name -What to do" value="<?php echo $tasks['task_name']; ?>">
            <span id="cd-taskname" class="text-danger"><?php echo form_error('cd-taskname'); ?></span>

        </div>

        <div class="col-lg-12 form-group" >

            <label>Category  </label>




            <select  name="cd-category" class="form-control select_input" >
                <option value="">Select Category</option>
                <?php
                if ($category) {
                    foreach ($category as $name) {
                        ?>

                        <option value="<?php echo $name['cat_id']; ?>" <?php
                                if (strcmp($tasks['task_cat_id'], $name['cat_id']) == 0) {
                                    echo 'selected="selected"';
                                }
                                ?>><?php echo $name['cat_name']; ?></option>
    <?php
    }
}
?>


            </select>
            <span id="cd-category" class="text-danger"><?php echo form_error('cd-category'); ?></span>
        </div>

        <div class="col-lg-12 form-group" >

            <label>Assignee name  </label><small><b> - who should Do this task</b></small>

            <input type="hidden" name="cd-assign_by" value="<?php echo $tasks['task_assign_by']; ?>">


            <select  name="cd-assignee" class="form-control select_input">

                <?php
                if ($tasks['task_assign_by'] == $this->session->userdata['marbel_user']['user_id']) {
                    if ($assignee) {
                        foreach ($assignee as $name) {

                            if ($name['id'] == $this->session->userdata['marbel_user']['user_id']) {
                                ?>

                                <option value="<?php echo $name['id']; ?>" <?php
                        if (strcmp($tasks['task_assign_to'], $name['id']) == 0) {
                            echo 'selected="selected"';
                        }
                                ?>>Self - I will do it</option>
            <?php } else { ?>

                                <option value="<?php echo $name['id']; ?>" <?php
                if (strcmp($tasks['task_assign_to'], $name['id']) == 0) {
                    echo 'selected="selected"';
                }
                ?>><?php echo ucwords($name['first_name'] . ' ' . $name['last_name']) . '(' . $name['user_role_type'] . ')'; ?></option>
            <?php }
        }
    }
} else{   ?>
    
    <option value="<?php echo $this->session->userdata['marbel_user']['user_id']; ?>" ><?php echo ucwords($this->session->userdata['marbel_user']['first_name'] . ' ' . $this->session->userdata['marbel_user']['last_name']) . '(' . $this->session->userdata['marbel_user']['type'] . ')'; ?></option>
<?php } ?>

            </select>
            <span id="cd-assignee" class="text-danger"><?php echo form_error('cd-assignee'); ?></span>

        </div>

        <div class="col-lg-12 form-group" >


            <label> Due date  </label>



            <input type="text" name="cd-duedate"  class="form-control duedate" placeholder="Due Date" readonly="readonly" value=" <?php echo (($tasks['task_due_date'] != '' && $tasks['task_due_date'] != '0000-00-00') ? date('m/d/Y', strtotime($tasks['task_due_date'])) : ''); ?>">
            <span id="cd-duedate" class="text-danger"><?php echo form_error('cd-duedate'); ?></span>


        </div>

        <div class="col-lg-12 form-group" >

            <label> Regarding  </label>



            <select  name="cd-regarding" class="form-control select_input">
                <option value="">User name - who is this task about</option>
<?php if ($regarding) {
    foreach ($regarding as $name) {
        ?>
                        <option value="<?php echo $name['id']; ?>" <?php
        if (strcmp($tasks['task_regarding'], $name['id']) == 0) {
            echo 'selected="selected"';
        }
        ?>><?php echo ucwords($name['first_name'] . ' ' . $name['last_name']) . '(' . $name['user_role_type'] . ')'; ?></option>
    <?php }
} ?>

            </select>
            <span id="cd-regarding" class="text-danger"><?php echo form_error('cd-regarding'); ?></span>

        </div>


        <div class="col-lg-12 form-group" >


            <label> Effort </label><small><b> -  How difficult is this task</b></small>(1 = easy / 100 = full attention)




            <select  name="cd-effort" class="form-control select_input">
                <option value="">Effort</option>
                <option value="1" <?php
if (strcmp($tasks['task_effort'], '1') == 0) {
    echo 'selected="selected"';
}
?>>1</option>
                <option value="10"<?php
if (strcmp($tasks['task_effort'], '10') == 0) {
    echo 'selected="selected"';
}
?>>10</option>
                <option value="25"<?php
if (strcmp($tasks['task_effort'], '25') == 0) {
    echo 'selected="selected"';
}
?>>25</option>
                <option value="50"<?php
                        if (strcmp($tasks['task_effort'], '50') == 0) {
                            echo 'selected="selected"';
                        }
                        ?>>50</option>
                <option value="100"<?php
                if (strcmp($tasks['task_effort'], '100') == 0) {
                    echo 'selected="selected"';
                }
                ?>>100</option>

            </select>
            <span id="cd-effort" class="text-danger"><?php echo form_error('cd-effort'); ?></span>

        </div>

        <div class="col-lg-12 form-group" >

            <label> Value  </label><small><b> - How important is this task</b></small>(100 = low / 1000 = high)



            <select  name="cd-value" class="form-control select_input">
                <option value="">Value</option>
                <option value="100" <?php
                        if (strcmp($tasks['task_value'], '100') == 0) {
                            echo 'selected="selected"';
                        }
                        ?>>100</option>
                <option value="200" <?php
                if (strcmp($tasks['task_value'], '200') == 0) {
                    echo 'selected="selected"';
                }
                        ?>>200</option>
                <option value="300" <?php
                if (strcmp($tasks['task_value'], '300') == 0) {
                    echo 'selected="selected"';
                }
                        ?>>300</option>
                <option value="400" <?php
                if (strcmp($tasks['task_value'], '400') == 0) {
                    echo 'selected="selected"';
                }
                        ?>>400</option>
                <option value="500" <?php
                        if (strcmp($tasks['task_value'], '500') == 0) {
                            echo 'selected="selected"';
                        }
                        ?>>500</option>
                <option value="600" <?php
                if (strcmp($tasks['task_value'], '600') == 0) {
                    echo 'selected="selected"';
                }
                ?>>600</option>
                <option value="700" <?php
                if (strcmp($tasks['task_value'], '700') == 0) {
                    echo 'selected="selected"';
                }
                ?>>700</option>
                <option value="800" <?php
                if (strcmp($tasks['task_value'], '800') == 0) {
                    echo 'selected="selected"';
                }
                ?>>800</option>
                <option value="900" <?php
                if (strcmp($tasks['task_value'], '900') == 0) {
                    echo 'selected="selected"';
                }
                ?>>900</option>
                <option value="1000" <?php
        if (strcmp($tasks['task_value'], '1000') == 0) {
            echo 'selected="selected"';
        }
        ?>>1000</option>

            </select>
            <span id="cd-value" class="text-danger"><?php echo form_error('cd-value'); ?></span>
        </div>

        <div class="col-lg-12" form-group>


            <label> Status : </label>

            <select  name="cd-status" class="form-control select_input">
                <option value="To Do" <?php
        if (strcmp($tasks['task_status'], 'To Do') == 0) {
            echo 'selected="selected"';
        }
        ?>>To Do</option>
                <option value="Testing" <?php
        if (strcmp($tasks['task_status'], 'Testing') == 0) {
            echo 'selected="selected"';
        }
        ?>>Testing</option>
                <option value="In Progress" <?php
        if (strcmp($tasks['task_status'], 'In Progress') == 0) {
            echo 'selected="selected"';
        }
        ?>>In Progress</option>
                <option value="Finished" <?php
        if (strcmp($tasks['task_status'], 'Finished') == 0) {
            echo 'selected="selected"';
        }
        ?>>Finished</option>
            </select>

        </div>
        <div class="col-lg-12 form-group" >


            <label> Details : </label>

            <textarea style="width: 510px; height: 197px;" placeholder="The specifics about this task...if any" class="form-control" name="cd-details"><?php echo (!empty($tasks['task_details'])) ? $tasks['task_details'] : ""; ?></textarea>



        </div>

    </div>
    <div class="clearfix"></div>
    <div class="modal-footer">
        <input type="hidden" name="task_id" value="<?php echo $tasks['task_id']; ?>">
<?php if ($tasks['task_assign_by'] == $this->session->userdata['marbel_user']['user_id']) { ?>
            <a href="<?php echo base_url('delete_tasks/' . $tasks['task_id']) ?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-danger pull-left">Delete</a>
<?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="add-row" class="btn btn-success">Update</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        var base_url = $('body').find('#base_url').val();
        //edit task
        // Script for validate and submit remind form by AJAX...
        var options = {
            beforeSerialize: function () {
                // return false to cancel submit 
                $('body').find('#editTaskModal #form_loader').removeClass('hidden');
            },
            url: base_url + 'update_task',
            success: function (data) {
                var err = $.parseJSON(data);
                if (err.result == false) {
                    $('body').find('#editTaskModal #form_loader').addClass('hidden');
                    $(err.error).each(function (index, value) {
                        $.each(value, function (index2, msg) {
                            $("#editTaskModal #" + index2).text(msg);
                            $("#editTaskModal #" + index2).removeClass('hidden');
                        });
                    });
                } else {
                    $('body').find('#editTaskModal #form_loader').addClass('hidden');
                    if (err.success) {

                        $('body').find('#editTaskModal input select').each(function () {

                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        $("#taskSuccess").text(err.success);
                        $("#taskSuccess").removeClass('hidden');
                        $('body').find('#editTaskModal').modal('hide');
                        setTimeout(function () {
                            window.location.href = base_url + 'tasks';
                        }, 500)

                    } else {
                        $('body').find('#editTaskModal input select').each(function () {
                            $(this).siblings('.text-danger').addClass('hidden');
                        })
                        setTimeout(function () {
                            $('body').find('#editTaskModal').modal('hide');
                        }, 500)
                    }
                }
            }
        };
        $('body').find('#edit-row-form').ajaxForm(options);
        /* date picker */
        $('.duedate').datepicker({
            'format': 'mm/dd/yyyy',
            startDate: new Date()
        });
        $('body').find(".select_input").chosen({no_results_text: "Oops, nothing found!"});
    });
</script>
<style>

    .chosen-container {
        width:100% !important;
    }
</style>