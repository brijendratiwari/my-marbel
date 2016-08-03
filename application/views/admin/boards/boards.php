<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div class="col-lg-6">
                    
                    <?php if($this->session->flashdata('success')){ ?>
                    
                    <div class="pull-left alert alert-success message">
                        <?php echo $this->session->flashdata('success');?>
                    </div>
                    <?php } ?>
                    
                    <?php if($this->session->flashdata('error')){ ?>
                    
                    <div class="pull-left alert alert-danger message">
                        <?php echo $this->session->flashdata('error');?>
                    </div>
                    <?php } ?>
    
           <div id="orderSuccess" class="pull-left alert alert-success hidden message"></div>
           <div id="orderError" class="pull-left alert alert-danger hidden message"></div>
                 </div>   
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" style="margin-top: 5%;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Boards List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover table-responsive" id="boards-data">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>views</th>
                                            <th>Odometer</th>
                                            <th># of rides</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>SN</th>
                                            <th>firmware version</th>
                                            <th>Updated</th>
                                            <th>Wheel</th>
                                            <th>Charge Count</th>
                                            <th>Lock</th>
                                            <th>Parent Lock</th>
                                            <th>Batt SN </th>
                                            <th>Motor Version</th>
                                            <th>AIO Version</th>
                                            <th>Deck Version</th>
                                            <th>Production</th>
                                        
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
           
        </div>





<script>
/* js function for delete order */

  function deleteOrder(order_number){
      
      
       if (confirm('Are you sure you want to delete?'))
        {
            window.location.href = "<?php echo base_url() ?>delete_order/" + order_number;
        }
      
  }
</script>
    


