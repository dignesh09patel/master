<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CodeIgniter Framework with AJAX</title>
        <link href="<?php echo base_url('css/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('css/vendor/bootstrap/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
    </head>
    <body>

        <div class="container" id="tblreload">
        <center>    
            <h1>CodeIgniter Framework with AJAX Wama Softwere Practical Task</h1>
        </center>
        <h3>Employee Detail</h3>
        <br />
         <button class="btn btn-danger" id="del_all"  style="float: right;">Bulk Delete Delete</button> 
        <button class="btn btn-success" onclick="add_employee()" style="float: right;"><i class="glyphicon glyphicon-plus"></i> Add New Employee</button>
        
        <br />
        <br />
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Contact No</th>
                    <th>Hobby</th>
                    <th>Category</th>
                    <th>Profile Pic</th>
                    <th style="width:125px;">Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($employees as $employee) {
                    $i++;
                    ?>
                    <tr id="<?php echo $employee['id']; ?>">
                        <td><?php echo $i; ?></td>
                        <td><input class="checkbox1" id="checkbox[]" type="checkbox" name="ckbdelete[]" value="<?php echo $employee['id']; ?>"></td>
                        <td>
                            <span class="editSpan nme"><?php echo $employee['name']; ?></span>
                            <input class="editInput nme form-control input-sm" type="text" name="name" value="<?php echo $employee['name']; ?>" style="display: none;">
                        </td>
                        <td>
                            <span class="editSpan cnct"><?php echo $employee['contact_number']; ?></span>
                            <input class="editInput cnct form-control input-sm" type="text" name="contact" value="<?php echo $employee['contact_number']; ?>" style="display: none;">
                        </td>
                        <td>
                            <span class="editSpan hby"><?php echo $employee['hobby']; ?></span>
                            <input class="editInput hby form-control input-sm" type="text" name="hobby" value="<?php echo $employee['hobby']; ?>" style="display: none;">
                        </td>
                        <td>
                            <span class="editSpan cat catspan"><?php echo $employee['category_name']; ?></span>
                            <select name="category" class="form-control editInput cat"  id="cate" style="display: none;">
                                <option value="">Select Category</option>
                                    <?php foreach ($categorys as $category) { ?>
                                    <option value="<?php echo $category['cat_id']; ?>" <?php if($category['cat_id'] ==  $employee['category']){echo "selected";}?>>
										<?php echo $category['category_name']; ?>
									</option>
									<?php } ?>
                            </select>
                            <input type="hidden" class="editInput" name="cat_id" value="<?php echo $employee['category']; ?>" >
                        </td>
                        <td>
                            <img class="editSpan img" src="<?php echo base_url('uploads/profile/') . $employee['profile_picture']; ?>" width="140px" height="90px">
                            <form id="form">
                                <input type="file" name="image" id="imgs" class="editInput img" style="display: none;">
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-warning editBtn" style="float: none;">Edit</i></button>
                            <button class="btn btn-danger deleteBtn" style="float: none;" onclick="delete_employee(<?php echo $employee['id']; ?>)">Delete</button>
                            <button type="button" class="btn btn-sm btn-success saveBtn" style="float: none; display: none;">Save</button>
                        </td>
                    </tr>
					<?php } ?>
            </tbody>
        </table>
    </div>


    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Add New Employee</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Name</label>
                                <div class="col-md-9">
                                    <input name="name"  class="form-control" id="emp_name" type="text" required>
                                    <b class="text-danger" id="error_name"></b>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Contact No</label>
                                <div class="col-md-9">
                                    <input name="contact_number" class="form-control" id="emp_contact" type="text" required>
                                    <b class="text-danger" id="error_contact"></b>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Hobby</label>
                                <div class="col-md-9">
                                    <input name="hobby"  class="form-control" id="emp_hobby" type="text" required>
                                    <b class="text-danger" id="error_hobby"></b>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Category</label>
                                <div class="col-md-9">
                                    <select name="category" class="form-control"  id="catgry" required>
                                        <option value="">Select Category</option>
                                            <?php foreach ($categorys as $category) { ?>
                                            <option value="<?php echo $category['cat_id']; ?>">
                                            <?php echo $category['category_name']; ?></option>
                                            <?php } ?>
                                    </select>
                                    <b class="text-danger" id="error_cat"></b>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Profile Pic</label>
                                <div class="col-md-9">
                                    <input type="file" id="file" name="file" required/>
                                    <b class="text-danger" id="error_img"></b>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <script src="<?php echo base_url('css/vendor/jquery/jquery-3.1.0.min.js') ?>"></script>
    <script src="<?php echo base_url('css/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('css/vendor/bootstrap/js//jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('css/vendor/bootstrap/js/dataTables.bootstrap.js') ?>"></script>
    <script>
    $(document).ready(function () {
        $('.editBtn').on('click', function () {
            //hide edit span
            $(this).closest("tr").find(".editSpan").hide();

            //show edit input
            $(this).closest("tr").find(".editInput").show();

            //hide edit button
            $(this).closest("tr").find(".editBtn").hide();

            //show edit button
            $(this).closest("tr").find(".saveBtn").show();

            $(this).closest("tr").find(".deleteBtn").hide();

        });

$('.saveBtn').on('click', function () {
    var trObj = $(this).closest("tr");
    var ID = $(this).closest("tr").attr('id');
    var inputData = $(this).closest("tr").find(".editInput").serialize();
    var form_data = new FormData();
    var file_data = $('#imgs').prop('files')[0];
    form_data.append('file', file_data);
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('welcome/update_employee') ?>',
        dataType: "json",
        data: 'id=' + ID + '&' + inputData + '&' + form_data,
        success: function (response) {

            if (response.status == 'ok') {
                trObj.find(".editSpan.nme").text(response.name);
                trObj.find(".editSpan.cnct").text(response.contact_number);
                trObj.find(".editSpan.hby").text(response.hobby);

            //    trObj.find(".editSpan.cat").text(response.category_name);
           
                trObj.find(".editInput").hide();
                trObj.find(".saveBtn").hide();
                trObj.find(".editSpan").show();
                trObj.find(".editBtn").show();
                 trObj.find(".deleteBtn").show();
				//table.ajax.reload(null,false);
            } else {
                alert(response.msg);
            }
        }
    });
});                     
 });
    </script>	


<script type="text/javascript">
var table;
        $(document).ready(function () {
          table =  $('#table_id').DataTable({
		  "autoWidth": true,
		  "deferRender": true,
		  "info":true,
		  "lengthChange":true,
		  "paging": true,
		  "ordering":true,
		  "searching":true,
		  "pageLength":5,
		  "stateSave" : true,
		  },
        )
		});
        var save_method;
  

        function add_employee()
        {
            save_method = 'add';
            $('#form')[0].reset();
            $('#modal_form').modal('show');
            $('.modal-title').text('Add New Employee');
        }

        function save()
        {
            var url;
            if (save_method == 'add')
            {
                url = "<?php echo site_url('welcome/add_employee') ?>";
            } 

            var inpObj_name = document.getElementById("emp_name");
            var inpObj_contact = document.getElementById("emp_contact");
            var inpObj_hobby = document.getElementById("emp_hobby");
            var inpObj_cate = document.getElementById("catgry");
            var inpObj_img = document.getElementById("file");

            if (inpObj_name.checkValidity() === false) {
                document.getElementById("error_name").innerHTML = inpObj_name.validationMessage;
            } else if (inpObj_contact.checkValidity() === false) {
                document.getElementById("error_contact").innerHTML = inpObj_contact.validationMessage;
            } else if (inpObj_hobby.checkValidity() === false) {
                document.getElementById("error_hobby").innerHTML = inpObj_hobby.validationMessage;
            } else if (inpObj_cate.checkValidity() === false) {
                document.getElementById("error_cat").innerHTML = inpObj_cate.validationMessage;
            } else if (inpObj_img.checkValidity() === false) {
                document.getElementById("error_img").innerHTML = inpObj_img.validationMessage;
            } else {
				
                var name = $('#emp_name').val();
                var contact = $('#emp_contact').val();
                var hobby = $('#emp_hobby').val();
                var category = $('#catgry').val();

                var form_data = new FormData();
                var file_data = $('#file').prop('files')[0];
				
                form_data.append('file', file_data);

                form_data.append('name', name);
                form_data.append('contact', contact);
                form_data.append('hobby', hobby);
                form_data.append('category', category);

                // ajax adding data to database
                $.ajax({
                    url: url,
                    type: "POST",
                    data: form_data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (data)
                    {
                        //if success close modal and reload ajax table
                        $('#modal_form').modal('hide');
                      //  $('#table_id').load(' #table_id');

						 $('form').trigger("reset");
                        location.reload();// for reload a page
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {

                        alert('Error adding / update data');
                    }
                });
            }
        }

        function delete_employee(id)
        {
            if (confirm('Are you sure delete this employee?'))
            {
                // ajax delete data from database
                $.ajax({
                    url: "<?php echo site_url('welcome/delete_employee/'); ?>" + id,
                    type: "POST",
                    dataType: "JSON",
                    cache: false,
                    success: function (data)
                    {
                        //$('#table_id').load(' #table_id');
						 location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
                return false;
            }
        }
        
        $("#del_all").on('click', function(e) {
                    e.preventDefault();
                    var checkValues = $('.checkbox1:checked').map(function()
                    {
                        return $(this).val();
                    }).get();
                   
                    $.each( checkValues, function( i, val ) {
                        $("#"+val).remove();
                        });
                    $.ajax({
                        url: "<?php echo site_url('welcome/delete_checked_employee') ?>",
                        type: 'post',
                        data: 'ids=' + checkValues

                    }).done(function() {
                        location.reload();

                    });

        });
    </script>
</body>
</html>
