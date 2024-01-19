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
                    $user_id = $_settings->userdata('id');
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $qry = $conn->query("SELECT * FROM `blog` WHERE id = '{$_GET['id']}' AND user_id = '$user_id'");
                        if ($qry->num_rows > 0) {
                            // Lặp qua kết quả và gán giá trị cho các biến
                            foreach ($qry->fetch_assoc() as $k => $v) {
                                $$k = $v;
                            }
                        } else {
                            die("Không tìm thấy bài viết");
                        }
                    } else {
                        die("Thiếu thông tin id hoặc giá trị không hợp lệ");
                    }

                    ?>

                    <div class="col-6 mx-auto card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Chỉnh sửa bài viết</h3>
                        </div>
                        <div class="card-body">
                            <form action="" id="blog-form">
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <div class="form-group">
                                    <label for="title" class="control-label">Tiêu đề</label>
                                    <textarea name="title" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo $title ?></textarea>
                                </div>
                                <div class="form-group">
				<label for="category" class="control-label">Category</label>
                <select name="category" id="" class="custom-select select" required>
                                    <option value="Chia sẻ cuộc sống" <?php echo isset($category) && $category == "Chia sẻ cuộc sống" ? 'selected' : '' ?>>Chia sẻ cuộc sống</option>
                                    <option value="Tin tức và sự kiện" <?php echo isset($category) && $category == "Tin tức và sự kiện" ? 'selected' : '' ?>>Tin tức và sự kiện</option>
                                    <option value="Hoạt động tình nguyện" <?php echo isset($category) && $category == "Hoạt động tình nguyện" ? 'selected' : '' ?>>Hoạt động tình nguyện</option>
                                    <option value="Kiến thức nuôi boss" <?php echo isset($category) && $category == "Kiến thức nuôi boss" ? 'selected' : '' ?>>Kiến thức nuôi boss</option>
                                </select>
			</div>
                                <div class="form-group">
                                    <label for="content" class="control-label"></label>
                                    <textarea name="content" id="" cols="30" rows="4" class="form-control form no-resize"><?php echo $content ?></textarea>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-flat btn-primary" form="blog-form">Lưu</button>
                            <a class="btn btn-flat btn-default" href="quanlybaiviet.php">Hủy</a>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#blog-form').submit(function(e) {
                                e.preventDefault();
                                var _this = $(this)
                                $('.err-msg').remove();
                                start_loader();
                                $.ajax({
                                    url: _base_url_ + "classes/Master.php?f=manage_blog",
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
                                            location.href = "quanlybaiviet.php";
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