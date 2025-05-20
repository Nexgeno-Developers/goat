<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-settings title_icon"></i><?php echo ucfirst(get_phrase('application_settings')); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->
<div class="row">
  <div class="col-xl-2 col-lg-3 col-md-12 col-sm-12">
    <a href="<?php echo route('website_settings/other_settings'); ?>" class="btn <?php if ($page_content == 'other_settings'): ?> btn-dark <?php else: ?> btn-secondary <?php endif; ?> btn-rounded btn-block"><?php echo get_phrase('others'); ?></a>
  </div>
  <div class="col-xl-10 col-lg-9 col-md-12 col-sm-12 page_content">
    <?php include $page_content.'.php'; ?>
  </div>
</div>

<script type="text/javascript">
// FRONTEND FORM SUBMISSION STRATS FROM HERE
function updateGeneralSettings() {
  $(".generalSettingsAjaxForm").validate({});
  $(".generalSettingsAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateAboutUsSettings() {
  $(".aboutUsSettings").validate({});
  $(".aboutUsSettings").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updatePrivactPolicySettings() {
  $(".privacyPolicySettings").validate({});
  $(".privacyPolicySettings").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, doNothing);
  });
}

function updateTermsAndConditionSettings() {
  $(".termsAndConditionSettings").validate({});
  $(".termsAndConditionSettings").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, doNothing);
  });
}

function updateHomepageSliderSettings() {
  $(".homepageSliderSettings").validate({});
  $(".homepageSliderSettings").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateOtherSettings() {
  $(".otherSettingsAjaxForm").validate({});
  $(".otherSettingsAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateRecaptchaSettings() {
  $(".updateRecaptchaSettings").validate({});
  $(".updateRecaptchaSettings").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

// Show All The Events
var showAllEvents = function () {
    var url = '<?php echo route('events/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.page_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

function reload() {
  setTimeout(
    function()
    {
      location.reload();
    }, 1000);
}
function doNothing() {

}
</script>
