<?php if(!access('manage_admins')){ redirect(route('dashboard')); } ?>

<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body manage_users1">
                <h4 class="page-title">
                <i class="mdi mdi-account-group title_icon"></i> <?php echo get_phrase($page_title); ?>
                    <?php if(access('manage_user_button')){ ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/manage-users/create'); ?>', '<?php echo get_phrase('create_user'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_user'); ?></button>
                    <?php } ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class = "book_content">
                    <?php include 'list.php'; ?>
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


<script>
var showAllUsers = function () {
    var url = '<?php echo route('manage_admins/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.book_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
