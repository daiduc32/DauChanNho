<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thú cưng</title>
<?php require_once('inc/header.php') ?>
<body style="height: auto;">

    <div class="wrapper">
    <div class="col-12 pt-3 pl-3 pb-3">
        <a href="./index.php" class="btn btn-primary hs-5 fw-bold flex-grow-1 col-auto pe-3"><i class="bi bi-house-door-fill"></i></a>
    </div>
     <div style="min-height: 567.854px;">
        <section class="content text-dark">
          <div class="container-fluid">
          <div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Thông tin thú cưng</h3>
		<div class="card-tools">
			<a href="adopt.php" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Thêm mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped text-center">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="10%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Tên</th>
						<th>Tuổi</th>
						<th>Giống loại</th>
						<th>Giới tính</th>
						<th>Cân nặng</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
        $conn = mysqli_connect('localhost', 'root', '', 'pet_shop_db');
        mysqli_set_charset($conn, 'UTF8');
        if (!$conn) {
            die("Kết nối thất bại. Vui lòng kiểm tra lại các thông tin máy chủ");
        }
        $id = $_settings->userdata('id');
        $result = mysqli_query($conn, "SELECT * FROM adopt_pet WHERE user_id = '$id' ; ");
        $i =1;
        // Bước 03: Xử lý kết quả truy vấn
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pet_id = $row['pet_id'];
                $ten = $row['ten'];
                $tuoi = $row['tuoi'];
                $giongloai = $row['giongloai'];
                $gioitinh = $row['gioitinh'];
                $cannang = $row['cannang'];
                $mausac = $row['mausac'];
                $mota = $row['mota'];
                $trangthai = $row['trangthai'];
        
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $ten ?></td>
							<td><?php echo $tuoi ?></td>
							<td><?php echo $giongloai ?></td>
							<td><?php echo $gioitinh ?></td>
							<td><?php echo $cannang ?></td>
							<td align="center">
                            <!--  -->
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="manage_thucung.php?pet_id=<?php echo $pet_id ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $pet_id ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php
                    }
                 }
                  ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Bạn chắc chắn muốn xóa dữ liệu thú cưng này chứ ?","delete_adopt",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_adopt($pet_id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_adopt",
			method:"POST",
			data:{id: $pet_id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
          </div>
        </section>
        <!-- /.content -->
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
              </div>
    </div>
  </div>
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
  </body>
</html>


