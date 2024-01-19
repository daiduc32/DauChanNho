<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `clients` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Client</h3>
	</div>
	<div class="card-body">
		<form action="" id="user-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="form-group">
				<label for="firstname" class="control-label">Họ</label>
                <textarea name="firstname" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($firstname) ? $firstname : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="middlename" class="control-label">Tên đệm</label>
                <textarea name="middlename" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($middlename) ? $middlename : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="lastname" class="control-label">Tên</label>
                <textarea name="lastname" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($lastname) ? $lastname : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="gender" class="control-label">Giới tính</label>
                <select name="gender" id="" class="custom-select select" required>
                                    <option value="Nam" <?php echo isset($gender) && $gender == "Nam" ? 'selected' : '' ?>>Nam</option>
                                    <option value="Nữ" <?php echo isset($gender) && $gender == "Nữ" ? 'selected' : '' ?>>Nữ</option>
                                </select>
			</div>
            <div class="form-group">
				<label for="contact" class="control-label">Contact</label>
                <textarea name="contact" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($contact) ? $contact : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="email" class="control-label">Email</label>
                <textarea name="email" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($email) ? $email : ''; ?></textarea>
			</div>
            <div class="form-group">
                    <label for="password" class="control-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control form" value="" placeholder="(Enter value to change password)">
                    </div>

            <div class="form-group">
				<label for="address" class="control-label">Địa chỉ</label>
                <textarea name="address" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($address) ? $address : ''; ?></textarea>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="user-form">Lưu</button>
		<a class="btn btn-flat btn-default" href="?page=users/action">Hủy</a>
	</div>
</div>
<script>
  
	$(document).ready(function(){
		$('#user-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=manage_user",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Error",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=users/action";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader()
                    }else{
						alert_toast("error",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>