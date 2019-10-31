<!-- page content -->
<div class="right_col" role="main">
        <div class="page-title">
            <div class="title_left">
                <h3>Blog</h3>
            </div>
        </div>
        <div class="clearfix"></div>

  <div class="tab-content">
    <div id="collection_category" class="tab-pane  in active">
             <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Blog</h2>     
						<?php echo form_open('admin/master/search'); ?>
							<input type="text" name="search" placeholder="Search">
								<button id="send" type="submit" class="btn btn-success">Submit</button>
						<?php echo form_close();?>
						<?php echo form_error('search'); ?>
                        <div style="float:right">
						
                            <a href="<?php echo base_url()?>admin/master/add_blog"><button class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add Blog</button></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php $errorMsg =  $this->session->flashdata('error_message'); ?>

                    <?php $successmsg =  $this->session->flashdata('succ_message'); ?>

                            <?php if(!empty($successmsg)){ ?>

                             <div class="alert alert-success">

                               <button type="button" class="close close-sm" data-dismiss="alert"> <i class="fa fa-times"></i> </button>

                               <strong><?php echo $successmsg;?>

                               </strong> 
                             </div>

                            <?php } ?>

                            <?php if(!empty($errorMsg)){ ?>

                             <div class="alert alert-error">

                               <button type="button" class="close close-sm" data-dismiss="alert"> <i class="fa fa-times"></i> </button>

                               <strong><?php echo $errorMsg;?>

                               </strong>
                             </div>

                            <?php } ?>
                    
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Is Active</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								if(isset($blogs) && !empty($blogs)){
								if($this->uri->segment(3)=='serach_result'){
									 $i = $this->uri->segment(5);
								}else{
									 $i = $this->uri->segment(4);
								}	
                               // $i = $this->uri->segment(4);
                                foreach ($blogs as $blog):
                                    if($blog['is_active']==1){
										$status = 0;
										$icon_name = 'Active';
										$class = 'btn-success';
									}else{
										 $status = 1;
										 $icon_name = 'Inactive';
										 $class = 'btn-warning';

										}
                                    $i++;
                                    ?>
									<?php ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $blog['title']; ?></td>
                                        <td><a href="<?php echo base_url().'admin/master/change_blog_status/'.$blog['id'].'/'.$status?>" class="btn <?php echo $class ; ?> btn-xs" type="button"><?php echo $icon_name ; ?> </a></td>
                                        <td>
                                            <a class="btn btn-primary btn-md" href="<?php echo base_url('admin/master/edit_blog/'.$blog['id']); ?>">Edit</a>
                                            <a class="btn btn-danger btn-md" href="<?php echo base_url('admin/master/delete_blog/'.$blog['id']); ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
								<?php
								} else{ 
								?>
									<tr>
										<td colspan="4">
											No Record Found
										</td>
									</tr>
								<?php } ?>		
                            </tbody>
                        </table>
							<?php echo $this->pagination->create_links(); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>  
