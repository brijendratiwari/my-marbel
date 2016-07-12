<div id="page-wrapper">
            <div class="row">
             <div class="col-lg-12">
           
    <?php if($this->session->flashdata('success')){ ?>
           <div class="alert alert-success message"><?php echo $this->session->flashdata('success'); ?></div>
    <?php } ?>
    <?php if($this->session->flashdata('error')){ ?>
           <div class="alert alert-danger message"><?php echo $this->session->flashdata('error'); ?></div>
    <?php } ?>
           </div>   
             
            </div>
            <div  class="col-lg-12">
            <div  class="col-lg-8 page-header pull-right">    
            <a href="<?php echo base_url().'inventory/add';?>" class="btn btn-custom pull-right">Add Part</a>
            <button class="btn btn-custom category-search" value="build">Build</button>
             <button class="btn btn-custom category-search" value="finishing">Finishing</button>
	     <button class="btn btn-custom category-search" value="layup">Layup</button>
	     <button class="btn btn-custom category-search" value="electronics">Electronics</button>
	     <button class="btn btn-custom category-search" value="logistics">Logistics</button>
	     <button class="btn btn-custom category-search" value="office">Office</button>
	     <button class="btn btn-custom category-search" value="R&D">R&D</button>
            </div>
            </div>
          
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         Part List  
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="part_data" style="width:100% !important;">
                                    <thead>
                                        <tr>
                                            
						<th style="text-align: center">View Part</th>
						<th>Part Name</th>
						<th>Category</th>
						<th>Type</th>
						<th>Quantity</th>
						<th>Cost</th>
						<th>Manufacturer</th>
                                                <th style="text-align: center">Action</th>
                                                
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

