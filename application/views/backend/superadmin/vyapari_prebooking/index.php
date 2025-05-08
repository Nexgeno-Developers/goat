<?php if(!access('manage_vyapari')){ redirect(route('dashboard')); } ?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card manvyap">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
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
                    <div class="col-md-2 mb-1 hidden">
                        <input type="text" name="vyapari_id" class="form-control" placeholder="Vyapari ID">
                    </div>
                    <div class="col-md-2 mb-1 hidden">
                        <input type="text" name="name" class="form-control" placeholder="Vyapari Name">
                    </div> 
                    <div class="col-md-2 mb-1 hidden">
                        <input type="text" name="aadhar_no" class="form-control" placeholder="Vyapari Aadhar">
                    </div>      
                    <div class="col-md-4 col-6 mb-1">
                        <label>Search</label>
                        <input type="text" name="advanceSearch" class="form-control" placeholder="Search">
                    </div>    
                    <div class="col-md-2 col-6 mb-1">
                        <label>From Date</label>
                        <input type="date" name="from" class="form-control" placeholder="From Date">
                    </div>  
                    <div class="col-md-2 col-6 mb-1">
                        <label>To Date</label>
                        <input type="date" name="to" class="form-control" placeholder="To Date">
                    </div>                    
                    <div class="col-md-2 col-3 repot-btn1">
                        <button class="btn btn-block btn-secondary" onclick="filter()" ><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>                                                           
                    <div class="col-md-2 col-3 repot-btn1">
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
        var url = '<?php echo route('manage_vyapari_prebooking/list'); ?>';

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
        var url = '<?php echo route('manage_vyapari_prebooking/list'); ?>';

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
        $('input[name="name"]').val("");    
        $('input[name="advanceSearch"]').val("");  
        $('input[name="aadhar_no"]').val(""); 
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