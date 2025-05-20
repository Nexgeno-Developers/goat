<div class="card">
  <div class="card-body">
    <h4 class="header-title"><?php echo get_phrase('digits_settings') ;?></h4>
    <form method="POST" class="col-12 updateRecaptchaSettings" action="<?php echo route('update_digits_settings') ;?>" enctype="multipart/form-data">
      <div class="row justify-content-left">
        <div class="col-12">
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="printing_qrcode_digit"><?php echo get_phrase('printing_qrcode_digit'); ?></label>
            <div class="col-md-9">
              <input onwheel="this.blur()" onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}" type="number" name="printing_qrcode_digit" class="form-control" id="printing_qrcode_digit" value="<?php echo get_common_settings('printing_qrcode_digit');  ?>" required>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="printing_qrcode_version"><?php echo get_phrase('printing_qrcode_version'); ?></label>
            <div class="col-md-9">
              <input onwheel="this.blur()" onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}" type="number" name="printing_qrcode_version" class="form-control" id="printing_qrcode_version" value="<?php echo get_common_settings('printing_qrcode_version');  ?>" required>
            </div>
          </div>
          <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="validate_qrcode_digit"><?php echo get_phrase('validate_qrcode_digit'); ?></label>
            <div class="col-md-9">
              <input onwheel="this.blur()" onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}" type="number" name="validate_qrcode_digit" class="form-control" id="validate_qrcode_digit" value="<?php echo get_common_settings('validate_qrcode_digit');  ?>" required>
            </div>
          </div>          
          <div class="text-center">
            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateRecaptchaSettings()"><?php echo get_phrase('update_digits_settings') ;?></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
