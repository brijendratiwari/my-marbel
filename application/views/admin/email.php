<div id="page-wrapper">
    <div class="row">

        <div class='col-md-12' style='margin-top: 10px;'>
            <?php if (isset($users) && empty($users)) {
                echo '<div class="alert alert-warning">We could not find any users with the names or emails of <b>' . $to. '</b></div>';
            } ?>
<?php if ($this->session->flashdata('success')) {
    echo $this->session->flashdata('success');
} ?>
<?php if ($this->session->flashdata('error')) {
    echo $this->session->flashdata('error');
} ?>
        </div>

        <form action="" method="post">				
            <legend>Retrieve Email List</legend>
            <div class="col-md-6 form-group">
                <select class="form-control" name="custom_filters.country">
                    <option value="">Please select a country</option>
                    <option value="US">United States</option>
                    <option value="INTL">International</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <select class="form-control" name="custom_filters.status">
                    <option value="">Please select a status</option>
                    <option value="deposit">Deposit Paid</option>
                    <option value="balance">Balance Paid</option>
                    <option value="building">Building</option>
                    <option value="qa">Quality Assurance</option>
                    <option value="shipping">Shipping</option>
                    <option value="shipped">Shipped</option>
                    <option value="refunded">Refunded</option>
                    <option value="all_waiting">All Waiting</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <input type="text" id='start_date' placeholder="Start Date" class="form-control" name="custom_filters.start_date">
            </div>
            <div class="col-md-6 form-group">
                <input type="text" id='end_date' placeholder="End Date" class="form-control" name="custom_filters.end_date">
            </div>
            <div class="col-md-offset-10 col-md-2 form-group">
                <input class="btn btn-success" type="submit"> 
            </div>
        </form>

<?php if (isset($emails)) : ?> 
            <p>Emails based upon your search (Country: <?php echo $_POST['custom_filters_country']; ?>, <?php echo $_POST['custom_filters_start_date'] . ' to ' . $_POST['custom_filters_end_date']; ?>, Status: <?php echo $_POST['custom_filters_status']; ?>)</p>
            <pre>
    				<code><?php $i = 0;
    $str = '';
    foreach ($emails as $email) {
        if (empty($email['email'])) {
            continue;
        } if ($i > 0) {
            $str .= ', ';
        } $str .= $email['email'];
        $i += 1;
    } echo trim($str); ?></code>
            </pre>
<?php endif; ?>

        <form method="POST" onsubmit="return postForm()">
            <legend>Send Template</legend>
            <input type="hidden" name="template-only" id="template-only" value="true">

            <div class="col-md-6 form-group">
                <select id="template" class="form-control" name="template">
                    <option>Please select a template...</option>
<?php foreach ($templates as $template): ?>
                        <option value="<?php echo $template['slug']; ?>"><?php echo $template['name']; ?> (Sends from email address: <?php echo $template['from_email'] ?>)</option>
<?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject Line" required="">
            </div>


            <div class="col-md-12 form-group">
                <textarea class="form-control" name="to" id="to" placeholder="To" required=""></textarea>
            </div>

            <div class="col-md-offset-10 col-md-2 form-group">
                <input class="btn btn-success" type="submit"> 
            </div>
        </form>

        <form method="POST" onsubmit="return postForm()">
            <legend>Compose Email</legend>
            <input type="hidden" name="body-only" id="body-only" value="true">

            <div class="col-md-6 form-group">
                <select id="template" class="form-control" name="template">
                    <option>Please select a template...</option>
<?php foreach ($templates as $template): ?>
                        <option value="<?php echo $template['slug']; ?>"><?php echo $template['name']; ?> (Sends from email address: <?php echo $template['from_email'] ?>)</option>
<?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject Line" required="">
            </div>


            <div class="col-md-12 form-group">
                <textarea class="form-control" name="to" id="to" placeholder="To" required=""></textarea>
            </div>

            <div class="col-md-12 form-group">
                <textarea class="summernote" id="body" name="body" placeholder="Body Content"></textarea>
            </div>

            <div class="col-md-offset-10 col-md-2 form-group">
                <input class="btn btn-success" type="submit"> 
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.summernote').summernote({
            height: "250px"
        });
        var postForm = function () {
            var content = $('textarea[name="content"]').html($('.summernote').code());
        }
        
        
            $('#start_date').datepicker({'format' : 'yyyy-mm-dd' });
            $('#end_date').datepicker({'format' : 'yyyy-mm-dd' });
    });
</script>