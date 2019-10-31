<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Blog</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add New Blog</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php if (!empty($error)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <br />
                        <?php echo form_open_multipart('admin/master/add_blog','class="form-horizontal form-label-left"'); ?> 
                                
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Title <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input class="form-control col-md-7 col-xs-12"  name="title"  value="<?php echo set_value('title',$this->input->post('title')); ?>"  type="text">
									<div class="text-danger"><?php echo form_error('title'); ?></div>
								</div>
                            </div>    
                             
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Blog Description <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="form-control col-md-7 col-xs-12 tinymce-enabled-message"  id="description1" name="content" ><?php echo set_value('content',$this->input->post('content')); ?></textarea>
                                       <div class="text-danger"><?php echo form_error('content'); ?></div>
                                </div>
                            </div> 
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Blog Image <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="file" name="image">
                                    <div class="text-danger"><?php echo form_error('image'); ?></div>
                                </div>
                            </div>   	
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Active?<span class="required"> *</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                   <select name="is_active" class="form-control">
                                       <option value="">Select Status</option>
                                        <option value="1"> Active</option>
                                        <option value="0"> In Active</option>
                                    </select>
									<div class="text-danger"><?php echo form_error('is_active'); ?></div>
                                </div>
                            </div> 
                        
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <a href="<?php echo base_url()?>admin/master/blog"> <button type="button" class="btn btn-primary">Cancel</button></a>
                                    <button id="send" type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                      <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    $(document ).ready(function() {
            function applyMCE() {
                    tinyMCE.init({
                            mode : "textareas",
							toolbar: 'fontselect',
                            editor_selector : "tinymce-enabled-message",     
                    });        
            }
            function AddRemoveTinyMce(editorId) {
                    if(tinyMCE.get(editorId)) 
                    {
                            tinyMCE.EditorManager.execCommand('mceFocus', false, editorId);                    
                            tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, editorId);

                    } else {
                            tinymce.EditorManager.execCommand('mceAddEditor', false, editorId);				
                    }
            }
            		applyMCE();
		$('a.toggle-tinymce').die('click').live('click', function(e) {
			AddRemoveTinyMce('description1');
			var lbl = $(this).text() == 'Off' ? 'On' : 'Off';
			$(this).text(lbl);
		});
        });
</script>        