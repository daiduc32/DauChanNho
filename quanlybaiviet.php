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
		<h3 class="card-title">Thông tin bài bài viết</h3>
		<div class="card-tools">
			<a href="post.php" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Thêm mới</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped text-center">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="20%">
					<col width="35%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Tiêu đề</th>
						<th>Chuyên mục</th>
						<th>Nội dung</th>
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
        $user_id = $_settings->userdata('id');
        $result = mysqli_query($conn, "SELECT * FROM blog WHERE user_id = '$user_id' ; ");
        $i =1;
        // Bước 03: Xử lý kết quả truy vấn
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = $row['title'];
                $category = $row['category'];
                $content = $row['content'];              
        
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $title ?></td>
							<td><?php echo $category ?></td>
							<td><?php echo $content ?></td>
							<td align="center">
                            <!--  -->
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="manage_blog.php?id=<?php echo $id ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $id ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
			_conf("Bạn chắc chắn muốn xóa dữ liệu bài viết này chứ ?","delete_blog",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_blog($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_blog",
			method:"POST",
			data:{id: $id},
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


