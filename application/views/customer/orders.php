<div id="page-wrapper">
    <div class="row">

        <?php if ($this->session->flashdata('error')) { ?>
            <div class="col-md-12 alert alert-danger" style="margin-top: 5px;">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="col-md-12 alert alert-success" style="margin-top: 5px;">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }
        ?>
        <div class="col-md-12" style="margin-top: 5px;">
            
            <div class="col-md-12 text-center"><h4>Your Order Details</h4></div>
            <div class="col-md-12 text-center">Sort By</div>
            <div class="col-md-12 text-center form-group" style="margin-top: 5px;"><input type="text" value="Most Recent"></div>
               
            
            <?php if(!empty($orders)){ 
                
     foreach ($orders as $order){
                ?>
            <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
            <div class="col-md-6"><label>Order Number</label> <a style='color:#00aeef;' href='<?php echo base_url('order_edit/'.$order['id'].'') ?>'><?php echo $order['order_number']; ?></a></div>
            <div class="col-md-6 text-right"><b><?php echo ucwords($order['order_friendly_status']); ?></b></div>
             <div class="col-md-12">
            <div class="panel panel-default" style='border:1px solid black;'>
                
            <div class="panel-heading"  style='border-bottom:1px solid black;'>
              Order Date<br><?php echo date('F j, Y', $order['order_date']); ?>
              <span class='pull-right'>Total<?php echo '$'.number_format($order['order_total'], 2, '.', ','); ?></span>
            </div>
                
                <div class='panel-body'>
                    <div class='col-md-2'> <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTUzYTg2ZDE2MyB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NTNhODZkMTYzIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjUiIHk9Ijc0LjgiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" style="width: 40px; height: 40px;" data-src="holder.js/140x140" class="img-circle">
</div>
                    <div class='col-md-10 text-center'> <span style='color:#00aeef'><?php echo $order['product']; ?></span></div>
                </div>
            </div>
            </div>
            </div>
            </div>
            <?php } } ?>

        </div>
    </div>
</div>