   <section>
		<div class="container mar-top-45"> 	
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Change Your Password</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <?php
                    if ($this->session->flashdata('message_eroor') != '')
                        echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('message_eroor') . '</div>';
                    ?>
                    <?php
                    if ($this->session->flashdata('message') != '')
                        echo '<div class="alert alert-success" role="alert">' . $this->session->flashdata('message') . '</div>';
                    ?>
                  <div class="x_content">
                    <br />
                    <?php echo form_open('admin/dashboard/change_password','class="form-horizontal form-label-left" autocomplete="off"'); ?> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="old_password"  required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >New Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="new_password" id="password" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Confirm New Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="confirm_password" id="confirm_password" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    <?php echo form_close();?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>           
	</div> 	
 </section>
<script> 
   var password = document.getElementById("password");
   var confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("New Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>