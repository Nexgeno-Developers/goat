<?php if(!access('manage_vyapari')){ redirect(route('dashboard')); } ?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card manvyap">
      <div class="card-body">
        <h4 class="page-title">
           <i class="mdi mdi-book title_icon"></i> <?php echo get_phrase($page_title); ?>
            <?php if(access('registration_button')){ ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/create'); ?>', '<?php echo get_phrase('Registration'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('Add Vyapari'); ?></button>
            <?php } ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="row mb-1">
                    <div class="col-md-2 mb-2">
                        <label>Vyapari ID</label>
                        <input type="text" name="vyapari_id" class="form-control" placeholder="Vyapari ID">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label>Vyapari Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Vyapari Name">
                    </div>                    
                    <div class="col-md-2 mb-2 hidden">
                        <input type="text" name="name" class="form-control" placeholder="Vyapari Name">
                    </div> 
                    <div class="col-md-2 mb-2">
                        <label>Aadhar Number</label>
                        <input type="text" name="aadhar_no" class="form-control" placeholder="Vyapari Aadhar">
                    </div>
                    <!-- <div class="col-md-2 mb-2">
                        <label>Receipt Number</label>
                        <input type="text" name="receipt_no" class="form-control" placeholder="Receipt Number">
                    </div> --> 
                    <div class="col-md-2 col-6 mb-2">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Vyapari Phone">
                    </div>   
                    <div class="col-md-2 col-6 mb-2">
                        <label>Receipt Number</label>
                        <input type="text" name="receipt_no" class="form-control" placeholder="Receipt Number">
                    </div>                     
                    <div class="col-md-2 col-6 mb-2">
                        <label>Pandol Number</label>
                        <input type="text" name="pandaal_no" class="form-control" placeholder="Pandol Number">
                    </div>    
                    <div class="col-md-2 col-6 mb-2">
                        <label>From Date</label>
                        <input type="date" name="from" class="form-control" placeholder="From Date">
                    </div>  
                    <div class="col-md-2 col-6 mb-2">
                        <label>To Date</label>
                        <input type="date" name="to" class="form-control" placeholder="To Date">
                    </div>                    
                    <div class="col-md-1 col-3 repot-btn1">
                        <button class="btn btn-block btn-secondary" onclick="filter()" ><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>                                                           
                    <div class="col-md-1 col-3 repot-btn1">
                        <button class="btn btn-block btn-danger" onclick="reset_filter()" ><i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </div>                    
                </div> 
                <div class="vyapari_content block-rep1">
                    <?php include 'list.php'; ?>
                </div>              
            </div>
        </div>
    </div>
</div>

<script>
    var showAllVyapari = function () {
        var url = '<?php echo route('manage_vyapari/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.vyapari_content').html(response);
                initDataTable('basic-datatable');
                //submit_webcam_image();
            }
        });
    }
    
    var SubmitImage = function () {
        var url = '<?php echo route('manage_vyapari/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.vyapari_content').html(response);
                initDataTable('basic-datatable');
                submit_webcam_image();
            }
        });
    }

    function reset_filter()
    {
        $('input[name="vyapari_id"]').val("");    
        $('input[name="receipt_no"]').val("");    
        $('input[name="pandaal_no"]').val("");    
        $('input[name="name"]').val("");    
        $('input[name="phone"]').val("");  
        $('input[name="aadhar_no"]').val(""); 
        $('input[name="receipt_no"]').val(""); 
        $('input[name="from"]').val("");
        $('input[name="to"]').val("");
        showAllVyapari();    
    }

    function filter()
    {
        showAllVyapari();
    }    
</script>
<style>
   div#basic-datatable-1_filter {
    display: none;
}
/* div#basic-datatable-1_length {
    display: none;
}*/
</style>