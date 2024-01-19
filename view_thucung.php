<?php require_once('config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nhận Nuôi Thú Cưng - Dấu Chân Nhỏ </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">


    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="dist/js/script.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    <p class="mb-0 phone pl-md-2">
                        <a href="#" class="mr-2"> Xin chào, cảm ơn bạn vì đã có một trái tim thương yêu động vật
                        </a>
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
                    <li class="nav-item">
                        <?php if (!isset($_SESSION['userdata']['id'])) : ?>
                            <a class="nav-link" id="login-btn">Đăng nhập</a>
                        <?php else : ?>
                    </li>
                    <li class="nav-item"><a href="/p1/chat" class="nav-link">Tin Nhắn</a></li>
                    <li class="nav-item">
                        <a href="./shop.php/?p=edit_account" class="text-dark  nav-link"><b> <?php echo $_settings->userdata('firstname') . ' ' . $_settings->userdata('middlename') . ' ' . $_settings->userdata('lastname') ?> </b></a>
                    </li>
                    <l class="nav-item"><a href="logout.php" class="nav-link"><i class="fa fa-sign-out-alt"></i></a>
                    <?php endif; ?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        $(function() {
            $('#login-btn').click(function() {
                uni_modal("", "login.php")
            })
            $('#navbarResponsive').on('show.bs.collapse', function() {
                $('#mainNav').addClass('navbar-shrink')
            })
            $('#navbarResponsive').on('hidden.bs.collapse', function() {
                if ($('body').offset.top == 0)
                    $('#mainNav').removeClass('navbar-shrink')
            })
        })

        $('#search-form').submit(function(e) {
            e.preventDefault()
            var sTxt = $('[name="search"]').val()
            if (sTxt != '')
                location.href = './?p=products&search=' + sTxt;
        })
    </script>

    <!-- END nav -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_2.jpg');" data-stellar-background-ratio="1">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Trang chủ | <i class="ion-ios-arrow-forward"></i></a></span> <span>Nhận nuôi <i class="ion-ios-arrow-forward"></i></span></p>

                    <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'pet_shop_db');
                    mysqli_set_charset($conn, 'UTF8');
                    if (!$conn) {
                        die("Kết nối thất bại. Vui lòng kiểm tra lại các thông tin máy chủ");
                    }
                    // Bước 02: Thực hiện truy vấn
                    $pet_id = $_GET['uid'];
                    $sql = mysqli_query($conn, "SELECT * FROM adopt_pet WHERE pet_id = '{$pet_id}' ; ");
                    // Bước 03: Xử lý kết quả truy vấn

                    if (mysqli_num_rows($sql) > 0) {
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $user_id = $row['user_id'];
                            $get_img = mysqli_query($conn, "SELECT image_url FROM image WHERE pet_id = '{$pet_id}'; ");
                            $image_urls = array();
                            while ($row2 = mysqli_fetch_assoc($get_img)) {
                                $image_urls[] = $row2["image_url"];
                            }

                    ?>
                            <h1 class="mb-0 bread"> <?php
                                                    echo $row['ten'];
                                                    ?> </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Thông tin vật nuôi</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-md-7">
                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4"><?php
                                                        echo $row['ten'];
                                                        ?></h3>
                                    <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                        <div class="row align-items-center" style="font-size: 16px !important;">
                                            <div class="col-md-12">
                                                <div class="form-group d-flex align-items-center">
                                                    <label class="text-dark font-weight-bold mr-2">Giống:</label>
                                                    <p class="mb-2"> <?php
                                                                        echo $row['giongloai'];
                                                                        ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-flex align-items-center">
                                                    <label class="text-dark font-weight-bold mr-2">Tuổi:</label>
                                                    <p class="mb-2"> <?php
                                                                        echo $row['tuoi'];
                                                                        ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-flex align-items-center">
                                                    <label class="text-dark font-weight-bold mr-2">Giới tính:</label>
                                                    <p class="mb-2"> <?php
                                                                        echo $row['gioitinh'];
                                                                        ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-flex align-items-center">
                                                    <label class="text-dark font-weight-bold mr-2">Cân nặng:</label>
                                                    <p class="mb-2"> <?php
                                                                        echo $row['cannang'];
                                                                        ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-flex align-items-center">
                                                    <label class="text-dark font-weight-bold mr-2">Màu sắc:</label>
                                                    <p class="mb-2"> <?php
                                                                        echo $row['mausac'];
                                                                        ?></p>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="label" for="#">Thông tin thêm :</label>
                                                    <p> <?php
                                                        echo $row['mota'];
                                                        ?></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                <a class="self-center pt-2" href="chat/?uid=<?php echo md5($user_id); ?>">
                                    <button type="button" class="btn btn-primary">Liên lạc nhận nuôi</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap w-100 p-5 img" id="imageContainer">
                                    <?php
                                    // Hiển thị tất cả ảnh
                                    foreach ($image_urls as $index => $img_url) {
                                        // Mặc định chỉ hiển thị ảnh đầu tiên, ẩn các ảnh khác
                                        $displayStyle = ($index === 0) ? 'block' : 'none';
                                        echo '<img src="uploads/adopt_pet/' . $img_url . '" alt="Pet Image" class="img-fluid" style="display:' . $displayStyle . ' ">';
                                    }
                                    ?>
                                    <button class="btn btn-outline-danger" id="prevBtn" > < </button>
                                    <button class="btn btn-outline-success" id="nextBtn" > > </button>
                                </div>
                                <div class="thumbnail-container">
                                    <?php
                                    // Hiển thị các ảnh nhỏ
                                    foreach ($image_urls as $index => $img_url) {
                                        echo '<img src="uploads/adopt_pet/' . $img_url . '" alt="Pet Image" class="thumbnail" data-index="' . $index . '">';
                                    }
                                    ?>
                                </div>
                            </div>
                            <script>
document.addEventListener("DOMContentLoaded", function() {
    var imageContainer = document.getElementById("imageContainer");
    var thumbnails = document.querySelectorAll(".thumbnail");
    var currentImageIndex = 0;

    function showImage(index) {
        // Ẩn tất cả ảnh
        for (var i = 0; i < thumbnails.length; i++) {
            thumbnails[i].classList.remove("active");
            imageContainer.children[i].style.display = "none";
        }

        // Hiển thị ảnh được chọn
        thumbnails[index].classList.add("active");
        imageContainer.children[index].style.display = "block";
        currentImageIndex = index;
    }

    // Hiển thị ảnh đầu tiên
    showImage(currentImageIndex);

    // Thêm sự kiện click cho các ảnh nhỏ
    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener("click", function() {
            var index = parseInt(this.getAttribute("data-index"), 10);
            showImage(index);
        });
    });

    // Thêm sự kiện click cho nút ">"
    document.getElementById("nextBtn").addEventListener("click", function() {
        currentImageIndex = (currentImageIndex + 1) % thumbnails.length;
        showImage(currentImageIndex);
    });

    // Thêm sự kiện click cho nút "<"
    document.getElementById("prevBtn").addEventListener("click", function() {
        currentImageIndex = (currentImageIndex - 1 + thumbnails.length) % thumbnails.length;
        showImage(currentImageIndex);
    });
});
</script>

<style>
.thumbnail-container {
    margin-top: 10px;
    display: flex;
    justify-content: center;
}

.thumbnail {
    width: 40px;
    height: 40px;
    margin: 0 5px;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s;
}

.thumbnail.active {
    opacity: 1;
}

#prevBtn,
#nextBtn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 24px;
    cursor: pointer;
    opacity: 0.5;
}

#prevBtn {
    left: 10px;
}

#nextBtn {
    right: 85px;
}
</style>


                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
                        }
                    }
?>
    </section>

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
        <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered" role="document">
            <div class="modal-content  rounded-0">
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
        <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
            <div class="modal-content rounded-0">
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


    <script>
        $(document).ready(function() {
            $('#p_use').click(function() {
                uni_modal("Privacy Policy", "policy.php", "mid-large")
            })
            window.viewer_modal = function($src = '') {
                start_loader()
                var t = $src.split('.')
                t = t[1]
                if (t == 'mp4') {
                    var view = $("<video src='" + $src + "' controls autoplay></video>")
                } else {
                    var view = $("<img src='" + $src + "' />")
                }
                $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
                $('#viewer_modal .modal-content').append(view)
                $('#viewer_modal').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false,
                    focus: true
                })
                end_loader()

            }
            window.uni_modal = function($title = '', $url = '', $size = "") {
                start_loader()
                $.ajax({
                    url: $url,
                    error: err => {
                        console.log()
                        alert("An error occured")
                    },
                    success: function(resp) {
                        if (resp) {
                            $('#uni_modal .modal-title').html($title)
                            $('#uni_modal .modal-body').html(resp)
                            if ($size != '') {
                                $('#uni_modal .modal-dialog').addClass($size + '  modal-dialog-centered')
                            } else {
                                $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
                            }
                            $('#uni_modal').modal({
                                show: true,
                                backdrop: 'static',
                                keyboard: false,
                                focus: true
                            })
                            end_loader()
                        }
                    }
                })
            }
            window._conf = function($msg = '', $func = '', $params = []) {
                $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
                $('#confirm_modal .modal-body').html($msg)
                $('#confirm_modal').modal('show')
            }
        })
    </script>


    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>




    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>



</body>

</html>