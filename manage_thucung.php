<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý thú cưng</title>
<?php require_once('inc/header.php') ?>

<body style="height: auto;">

    <div class="wrapper">
        <div class="col-12 pt-3 pl-5 pb-3">
            <a href="./index.php" class="btn btn-primary hs-5 fw-bold flex-grow-1 col-auto pe-3"><i class="bi bi-house-door-fill"></i></a>
        </div>
        <div style="min-height: 567.854px;">
            <section class="content text-dark">
                <div class="container-fluid">
                    <?php
                    $id = $_settings->userdata('id');
                    if (isset($_GET['pet_id']) && $_GET['pet_id'] > 0) {
                        $qry = $conn->query("SELECT * FROM `adopt_pet` WHERE pet_id = '{$_GET['pet_id']}' AND user_id = '$id'");
                        if ($qry->num_rows > 0) {
                            // Lặp qua kết quả và gán giá trị cho các biến
                            foreach ($qry->fetch_assoc() as $k => $v) {
                                $$k = $v;
                            }
                        } else {
                            die("Không tìm thấy dữ liệu phù hợp");
                        }
                    } else {
                        die("Thiếu thông tin pet_id hoặc giá trị không hợp lệ");
                    }

                    ?>

                    <div class="col-6 mx-auto card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Cập nhật thông tin thú cưng</h3>
                        </div>
                        <div class="card-body">
                            <form action="" id="adopt-form">
                                <input type="hidden" name="pet_id" value="<?php echo $pet_id ?>">
                                <div class="form-group">
                                    <label for="ten" class="control-label">Tên</label>
                                    <textarea name="ten" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $ten ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tuoi" class="control-label">Tuổi</label>
                                    <textarea name="tuoi" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $tuoi ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="giongloai" class="control-label">Giống loại</label>
                                    <textarea name="giongloai" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $giongloai ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="mausac" class="control-label">Màu sắc</label>
                                    <textarea name="mausac" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $mausac ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gioitinh" class="control-label">Giới tính</label>
                                    <textarea name="gioitinh" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $gioitinh ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cannang" class="control-label">Cân nặng</label>
                                    <textarea name="cannang" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $cannang ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="mota" class="control-label">Thông tin thêm</label>
                                    <textarea name="mota" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $mota ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="trangthai" class="control-label">Trạng thái</label>
                                    <select name="trangthai" id="" class="custom-select select" required>
                                        <option value="Đang tìm chủ" <?php echo isset($trangthai) && $trangthai == "Đang tìm chủ" ? 'selected' : '' ?>>
                                        Đang tìm chủ</option>
                                        <option value="Đã tìm được chủ" <?php echo isset($trangthai) && $trangthai == "Đã tìm được chủ" ? 'selected' : '' ?>>
                                            Đã tìm được chủ</option>
                                    </select>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-flat btn-primary" form="adopt-form">Lưu</button>
                            <a class="btn btn-flat btn-default" href="?page=blog/index">Hủy</a>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#adopt-form').submit(function(e) {
                                e.preventDefault();
                                var _this = $(this)
                                $('.err-msg').remove();
                                start_loader();
                                $.ajax({
                                    url: _base_url_ + "classes/Master.php?f=manage_adopt",
                                    data: new FormData($(this)[0]),
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: 'POST',
                                    type: 'POST',
                                    dataType: 'json',
                                    error: err => {
                                        console.log(err)
                                        alert_toast("Error", 'error');
                                        end_loader();
                                    },
                                    success: function(resp) {
                                        if (typeof resp == 'object' && resp.status ==
                                            'success') {
                                            location.href = "quanlythucung.php";
                                        } else if (resp.status == 'failed' && !!resp.msg) {
                                            var el = $('<div>')
                                            el.addClass("alert alert-danger err-msg").text(resp
                                                .msg)
                                            _this.prepend(el)
                                            el.show('slow')
                                            $("html, body").animate({
                                                scrollTop: _this.closest('.card')
                                                    .offset().top
                                            }, "fast");
                                            end_loader()
                                        } else {
                                            alert_toast("error", 'error');
                                            end_loader();
                                            console.log(resp)
                                        }
                                    }
                                })
                            })
                        })
                    </script>
                </div>
            </section>
        </div>
</body>

</html>