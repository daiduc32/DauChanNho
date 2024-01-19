<?php require_once('config.php'); ?>
<?php
if (!isset($_SESSION['userdata']['id'])) {
    echo '<script>alert("Bạn cần phải đăng nhập trước khi sử dụng chức năng này ! ");</script>';
    echo '<script>window.location.href = "index.php"; </script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nhận Nuôi Thú Cưng - Dấu Chân Nhỏ </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">


    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="dist/js/script.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Tìm nhà mới cho thú cưng </title>
    <style>
        .container-post {
            height: 100%;
            max-width: 62%;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .imgGallery img {
            padding: 8px;
            max-width: 100px;
        }
    </style>

</head>

<body>


    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <p class="mb-0 phone pl-md-2">
                        <a href="#" class="mr-2"> Xin chào, cảm ơn bạn vì đã có một trái tim thương yêu động vật </a>
                    </p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <p class="mb-0 phone pl-md-2">

                    </p>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><span class="flaticon-pawprint-1 mr-2"></span>Dấu Chân Nhỏ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Trang Chủ</a></li>
                    <li class="nav-item"><a href="nhannuoi.php" class="nav-link">Nhận nuôi</a></li>
                    <li class="nav-item"><a href="index.php" class="nav-link">Shop</a></li>
                    <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="contact.html" class="nav-link">Liên hệ</a></li>
                    <li class="nav-item"><a href="/p1/chat" class="nav-link">Tin Nhắn</a></li>
                    <li class="nav-item">
                        <a href="./shop.php/?p=edit_account" class="text-dark  nav-link"><b> <?php echo $_settings->userdata('firstname') . ' ' . $_settings->userdata('middlename') . ' ' . $_settings->userdata('lastname') ?>!</b></a>
                    </li>
                    <l class="nav-item"><a href="logout.php" class="nav-link"><i class="fa fa-sign-out-alt"></i></a>
                        </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "pet_shop_db");

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra xem đã upload file chưa
        if (isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"] == 0) {
            // Thông tin về file
            $fileName = $_FILES["fileUpload"]["name"];
            $fileTmp = $_FILES["fileUpload"]["tmp_name"];
            $fileType = $_FILES["fileUpload"]["type"];
            $fileSize = $_FILES["fileUpload"]["size"];

            // Đường dẫn lưu trữ file (thay đổi đường dẫn tùy theo nơi bạn muốn lưu trữ)
            $uploadDir = "uploads/blog/";
            $uploadDate      = date('Y-m-d H:i:s');
            // Kiểm tra định dạng file (chỉ cho phép ảnh)
            $allowedFormats = ["image/jpeg", "image/png", "image/jpg"];
            if (in_array($fileType, $allowedFormats)) {
                // Tạo tên file mới để tránh trùng lặp
                $newFileName = uniqid() . "_" . $fileName;

                // Di chuyển file vào thư mục lưu trữ
                $uploadPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmp, $uploadPath)) {
                    // File đã được upload thành công

                    // Lấy dữ liệu từ form
                    $title = $_POST['title'];
                    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
                    $category = $_POST['category'];
                    $content = $_POST['content'];
                    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
                    $user_id =  $_settings->userdata('id');


                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $sql = "INSERT INTO blog (user_id, title, category, content, image, date_time) VALUES ('$user_id', '$title', '$category', '$content', '$uploadPath', '$uploadDate')";
                    if ($conn->query($sql) === TRUE) {
                        echo "Đăng bài thành công!";
                    } else {
                        echo "Có lỗi xảy ra: " . $conn->error;
                    }
                } else {
                    echo "Có lỗi xảy ra khi lưu trữ file.";
                }
            } else {
                echo "Chỉ được upload ảnh có định dạng .jpeg, .jpg và .png";
            }
        } else {
            echo "Bạn cần chọn một file ảnh để upload.";
        }
    }

    // Đóng kết nối
    $conn->close();
    ?>
    <div class="container-post">
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data" class="mb-3">
            <h4 class="text-center mt-5">Bài đăng mới </h4>

            <div class="form-group">
                <label>Tiêu đề : </label>
                <textarea class="form-control" name="title" rows="1" required></textarea>
            </div>
            <div class="form-group">
                <label>Chuyên mục :</label>
                <select class="form-control" name="category">
                    <option value="Chia sẻ cuộc sống">Chia sẻ cuộc sống</option>
                    <option value="Tin tức và sự kiện">Tin tức và sự kiện</option>
                    <option value="Hoạt động tình nguyện">Hoạt động tình nguyện</option>
                    <option value="Kiến thức nuôi boss">Kiến thức nuôi boss</option>
                   
                </select>
            </div>

            <div class="form-group">
                <label>Nội dung : </label>
                <textarea class="form-control" name="content" rows="5"></textarea>
            </div>
            <label> Hình ảnh tiêu đề bài đăng</label>
            <div class="user-image mb-3 text-center">
                <div class="imgGallery">
                    <!-- Image preview -->
                </div>
            </div>

            <div class="custom-file">
                <input type="file" name="fileUpload" class="custom-file-input" id="chooseFile" multiple>
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
               Đăng bài
            </button>
        </form>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#chooseFile').on('change', function() {
                multiImgPreview(this, 'div.imgGallery');
            });
        });
    </script>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                    <h2 class="footer-heading">Petsitting</h2>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                    <ul class="ftco-footer-social p-0">
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><span class="fa fa-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><span class="fa fa-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><span class="fa fa-instagram"></span></a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                    <h2 class="footer-heading">Latest News</h2>
                    <div class="block-21 mb-4 d-flex">
                        <a class="img mr-4 rounded" style="background-image: url(images/image_1.jpg);"></a>
                        <div class="text">
                            <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="icon-calendar"></span> April 7, 2020</a></div>
                                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="block-21 mb-4 d-flex">
                        <a class="img mr-4 rounded" style="background-image: url(images/image_2.jpg);"></a>
                        <div class="text">
                            <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                            <div class="meta">
                                <div><a href="#"><span class="icon-calendar"></span> April 7, 2020</a></div>
                                <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                                <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 pl-lg-5 mb-4 mb-md-0">
                    <h2 class="footer-heading">Quick Links</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Home</a></li>
                        <li><a href="#" class="py-2 d-block">About</a></li>
                        <li><a href="#" class="py-2 d-block">Services</a></li>
                        <li><a href="#" class="py-2 d-block">Works</a></li>
                        <li><a href="#" class="py-2 d-block">Blog</a></li>
                        <li><a href="#" class="py-2 d-block">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                    <h2 class="footer-heading">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon fa fa-map"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                            <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                            <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">info@yourdomain.com</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">


                </div>
            </div>
        </div>
    </footer>



</body>

</html>