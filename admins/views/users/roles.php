<style type="text/css">
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
					<h5 class="font-weight-bold text-dark"><i class="fa fa-database mr-2"></i>Roles</h5>
				<?php }else{ ?>
					<h5 class="text-danger font-weight-bold"><i class="fa fa-trash mr-2"></i>Deleted Roles</h5>
				<?php } ?>
			</div>
			<div class="col-md-8">
				<div class="float-sm-right">
					<?php if($delete_flag == 0){ ?>
					<a href="<?php echo url.'admins/controllers/User.php?action=roles&delete_flag='.$deleteFlag; ?>" class="btn btn-warning btn-sm"><i class="fa fa-trash mr-2"></i>Trash</a>
					<button type="button" onclick="moveToTrashAll()" class="btn btn-sm btn-danger"><i class="fa fa-trash mr-2"></i>Delete</button>
					<?php }else{ ?>
					<a href="<?php echo url.'admins/controllers/User.php?action=roles&delete_flag='.$deleteFlag; ?>" class="btn btn-success btn-sm"><i class="fa fa-list mr-2"></i>Roles</a>
					<button type="button" onclick="restoreAll()" class="btn btn-sm btn-warning"><i class="fa fa-undo mr-2"></i>Restore</button>
					<button type="button" onclick="deleteAll()" class="btn btn-sm btn-danger"><i class="fa fa-trash mr-2"></i>Delete</button>
					<?php } ?>
					<button type="button" class="btn btn-sm btn-success" onclick="openForm()"><i class="fa fa-plus mr-2"></i>New Role</button>
					<a href="<?php echo url.'admins/controllers/Dashboard.php?action=dashboard'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-home mr-2"></i>Home</a>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?php getAlertMessage(); ?>
			<table class="table table-bordered" id="data-table">
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
					<th class="w-100">Description</th>
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
							<td><?php echo $key['role_name']; ?></td>
							<td><?php echo $key['description']; ?></td>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header py-2 my-bg-light">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i class="fa fa-database mr-2"></i>Role Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="action-form" action="<?php echo url.'admins/controllers/User.php'; ?>" method="post">
      <div class="modal-body">
				<div class="form-group">
					<label for="role_name">Name</label>
					<input type="text" name="role_name" id="role_name" class="form-control" autocomplete="off" required>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<input type="text" name="description" id="description" class="form-control" autocomplete="off">
				</div>
      </div>
      <div class="modal-footer py-2 my-bg-light">
        <input type="hidden" name="id" id="id">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Close</button>
				<button type="submit" name="action" value="roleAdd" id="btn-add" class="btn btn-success btn-sm"><i class="fa fa-save mr-2"></i>Submit</button>
				<button type="submit" name="action" value="roleUpdate" id="btn-update" class="btn btn-primary btn-sm"><i class="fa fa-edit mr-2"></i>Update</button>
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
	var width2 = $(window).width();
	if(width2 <= 668){
		$('table').addClass('table-responsive');
	}
	else{
		$('table').removeClass('table-responsive');
	}

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
			data: {action: 'role', id:id},
			success: function(data){
				// alert(data);
				var res = JSON.parse(data);
				$('#role_name').val(res.role_name);
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
			window.location.href="<?php echo url.'admins/controllers/User.php?action=roleActive&id='; ?>"+id+"&active="+active;
		}
	}

	function deleteData(id){
		var ans = confirm("Are you sure you want to delete permanently?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=roleDelete&id='; ?>"+id;	
		}
	}

	function moveToTrash(id){
		var ans = confirm("Are you sure you want to delete?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=roleMoveToTrash&id='; ?>"+id;	
		}
	}

	function restoreDeleteData(id){
		var ans = confirm("Are you sure you want to restore?");
		if(ans){
			window.location.href="<?php echo url.'admins/controllers/User.php?action=roleRestore&id='; ?>"+id;	
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
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=roleDeleteAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("Role must be selected, Please try again!");
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
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=roleMoveToTrashAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("Role must be selected, Please try again!");
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
	    		window.location.href="<?php echo url.'admins/controllers/User.php?action=roleRestoreAll&id='; ?>"+selected_value;
	    	}
			}
			else{
				alert("Role must be selected, Please try again!");
			}
  }
</script>