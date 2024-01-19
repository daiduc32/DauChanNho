<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Categories</h3>
		<div class="card-tools">
			<a href="?page=users/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Tạo tài khoản mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="35%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="text-center">
						<th>ID</th>
						<th>Họ</th>
						<th>Tên đệm</th>
						<th>Tên</th>
						<th>Email</th>
						<th>Giới tính</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$qry = $conn->query("SELECT * from `clients`");
						while($row = $qry->fetch_assoc()):
                            $id = $row['id'];
							$fname = $row['firstname'];
							$mname = $row['middlename'];
							$lname = $row['lastname'];
							$email = $row['email'];
							$gender = $row['gender'];
					?>
						<tr class="text-center">
							<td><?php echo $id ?></td>
							<td><?php echo $fname ?></td>
							<td><?php echo $mname ?></td>
							<td><?php echo $lname ?></td>
							<td><?php echo $email ?></td>
							<td><?php echo $gender ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=users/manage_user&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Bạn chắc chắn muốn xóa tài khoản này chứ ?","delete_user",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_user",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Error.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("error.",'error');
					end_loader();
				}
			}
		})
	}
</script>