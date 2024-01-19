<?php require_once('config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Nhận Nuôi Thú Cưng - Dấu Chân Nhỏ </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">

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

</head>

<body>

<?php
$randomContents = array(
    "Xin chào, cảm ơn bạn vì đã có một trái tim thương yêu động vật",
    "Hãy cùng “Dấu Chân Nhỏ” chug tay bảo vệ các động vật bị bỏ rơi nhé ",
    "Lan tỏa tình yêu thương - cho đi và nhận lại",
    "Một hành động nhỏ cũng có thể đem lại những thay đổi lớn ",
    "Hãy là chỗ dựa cho cả những bạn nhỏ nữa nhé !",
);

$randomContent = $randomContents[array_rand($randomContents)];
?>
    <div class="wrap w-100">
        <div class="container">
                        <p class="mr-2 pl-md-2" style="font-size:14px; color: #ffff" ><marquee width="100%" direction="right"><?php echo $randomContent; ?></marquee>
                        </p>
 
        </div>
       </div>
      <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container" style="max-height: 88px;">
            <a class="navbar-brand" href="index.php"><span class="flaticon-pawprint-1 mr-2"></span>Dấu Chân Nhỏ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="index.php" class="nav-link">Trang Chủ</a></li>
                    <li class="nav-item"><a href="nhannuoi.php" class="nav-link">Nhận nuôi</a></li>
                    <li class="nav-item"><a href="shop.php" class="nav-link">Shop</a></li>
                    <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Liên hệ</a></li>
                    <li class="nav-item">

                        <?php if (!isset($_SESSION['userdata']['id'])) : ?>
                            <a class="nav-link" id="login-btn">Đăng nhập</a>
                        <?php else : ?>


                            <?php
                            $conn = mysqli_connect('localhost', 'root', '', 'pet_shop_db');
                            mysqli_set_charset($conn, 'UTF8');
                            if (!$conn) {
                                die("Kết nối thất bại. Vui lòng kiểm tra lại các thông tin máy chủ");
                            }
                            $id = $_settings->userdata('id');
                            $result = mysqli_query($conn, "SELECT * FROM messages WHERE to_user = '{$id}' and status = '0' ");
                            $check = mysqli_num_rows($result);
                            ?>

                    </li>
                    <li class="nav-item"><a href="/p1/chat" class="nav-link">Tin Nhắn  <span class="rounded-circle notif-count badge bg-danger text-light m-1"><?php echo $check ?></span></a>
                   
                </li>
      
                <li class="nav-item">
                  <p class="text-dark nav-link" data-toggle="dropdown">
                    <b> <?php echo $_settings->userdata('lastname') ?> </b>
                  </p>
                  <div class="dropdown-menu dropdown-menu-right mr-5" role="menu">
                    <a class="dropdown-item" href="./shop.php?p=edit_account"><span class="fas fa-user-circle mr-2"></span> Tài khoản </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="quanlythucung.php"><span class="fas fa-cat mr-2"></span> Quản lý thú cưng</a>
                    <div class="dropdown-divider"></div> 
                    <a class="dropdown-item" href="quanlybaiviet.php"><span class="fas fa-cat mr-2"></span> Quản lý bài viết</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><span class="fas fa-sign-out-alt mr-2"></span> Đăng xuất</a>
                  </div>
                        </li>
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
    <div class="hero-wrap js-fullheight" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center" data-scrollax-parent="true">
                <div class="col-md-11 ftco-animate text-center">
                    <h1 class="mb-4">“ Yêu thương mỗi hơi thở ” <br> Vì tình yêu không lý do </h1>
                    <p><a href="about.html" class="btn btn-primary mr-md-4 py-3 px-4">Tìm hiểu thêm <span class="ion-ios-arrow-forward"></span></a></p>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section bg-light ftco-no-pt ftco-intro">
        <div class="container">
            <div class="row">
                <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
                    <div class="d-block services active text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-blind"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">NHẬN NUÔI</h3>
                            <p>Hãy yêu thương mỗi dấu chân nhỏ, cưu mang, chăm sóc những động vật bị bỏ rơi.</p>
                            <a class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
                    <div class="d-block services text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-dog-eating"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Tình nguyện</h3>
                            <p>Hành động để thay đổi cuộc sống của chó, mèo và những thú cưng khác.</p>
                            <a href="#" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-self-stretch px-4 ftco-animate">
                    <div class="d-block services text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-grooming"></span>
                        </div>
                        <div class="media-body">
                            <h3 class="heading">Ủng hộ</h3>
                            <p>Giúp duy trì hoạt động của tổ chức thông qua hình thức quyên góp hoặc mua các sản phẩm tại Shop.</p>
                            <a href="#" class="btn-custom d-flex align-items-center justify-content-center"><span class="fa fa-chevron-right"></span><i class="sr-only">Read more</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row d-flex no-gutters">
                <div class="col-md-5 d-flex">
                    <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(images/about-1.jpg);">
                    </div>
                </div>
                <div class="col-md-7 pl-md-5 py-md-5">
                    <div class="heading-section pt-md-5">
                        <h2 class="mb-4">Nhận Nuôi Thú Cưng - Dấu Chân Nhỏ Adoption </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 services-2 w-100 d-flex">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-stethoscope"></span></div>
                            <div class="text pl-3">
                                <h4>Hoạt động phi lợi nhuận</h4>
                                <p>Hành động vì lợi ích của cộng đồng và tình yêu thương dành cho động vật</p>
                            </div>
                        </div>
                        <div class="col-md-6 services-2 w-100 d-flex">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-customer-service"></span></div>
                            <div class="text pl-3">
                                <h4>Tôn chỉ hoạt động</h4>
                                <p>Không từ bỏ nỗ lực với bất kỳ con vật nào, dù bé có ốm yếu hay tàn tật tới đâu </p>
                            </div>
                        </div>
                        <div class="col-md-6 services-2 w-100 d-flex">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-emergency-call"></span></div>
                            <div class="text pl-3">
                                <h4>Mục đích</h4>
                                <p>Nỗ lực tìm mái ấm yêu thương cho các bé bị bỏ rơi</p>
                            </div>
                        </div>
                        <div class="col-md-6 services-2 w-100 d-flex">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-veterinarian"></span></div>
                            <div class="text pl-3">
                                <h4>Tuyên truyền</h4>
                                <p>Nâng cao nhận thức về trách nhiệm của chủ nuôi thông qua mạng xã hội và các hoạt động thiện nguyện.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-counter" id="section-counter">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                        <div class="text">
                            <strong class="number" data-number="50"></strong>
                        </div>
                        <div class="text">
                            <span>Ca cứu hộ <span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                        <div class="text">
                            <strong class="number" data-number="232">0</strong>
                        </div>
                        <div class="text">
                            <span>Đã có chủ</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                        <div class="text">
                            <strong class="number" data-number="59">0</strong>
                        </div>
                        <div class="text">
                            <span>Chưa có chủ</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                        <div class="text">
                            <strong class="number" data-number="16">0</strong>
                        </div>
                        <div class="text">
                            <span>Chưa sẵn sàng nhận chủ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light ftco-faqs">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-md-last">
                    <div class="img img-video d-flex align-self-stretch align-items-center justify-content-center justify-content-md-center mb-4 mb-sm-0" style="background-image:url(images/about.jpg);">
                        <a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex justify-content-center align-items-center">
                            <span class="fa fa-play"></span>
                        </a>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="img img-2 mr-md-2" style="background-image:url(images/about-2.jpg);"></div>
                        <div class="img img-2 ml-md-2" style="background-image:url(images/about-3.jpg);"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="heading-section mb-5 mt-5 mt-lg-0">
                        <h2 class="mb-3">Những điều có thể bạn cần biết</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                    <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header p-0" id="headingOne">
                                <h2 class="mb-0">
                                    <button href="#collapseOne" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                        <p class="mb-0">Điều Kiện Nhận Nuôi Thú Cưng?</p>
                                        <i class="fa" aria-hidden="true"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="collapse show" id="collapseOne" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-body py-3 px-0">
                                    <ol>
                                        <li> 1️⃣ Tìm hiểu về thú cưng bạn muốn nhận nuôi trên trang web.</li>
                                        <li> 2️⃣Tài chính tự chủ và ổn định.</li>
                                        <li> 3️⃣ Có tình yêu động vật, chỗ ở cố định.</li>
                                        <li> 4️⃣ Cam kết tiêm phòng và triệt sản .</li>
                                        <li> 5️⃣ Không trục lợi cá nhân, thu lợi bất chính.</li>
                                        <li> 6️⃣ Thời gian nhận nuôi dài hạn.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header p-0" id="headingTwo" role="tab">
                                <h2 class="mb-0">
                                    <button href="#collapseTwo" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                        <p class="mb-0">Làm thế nào để nhận nuôi thú cưng ?</p>
                                        <i class="fa" aria-hidden="true"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="collapse" id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body py-3 px-0">
                                    <ol>
                                        <li> Trước khi quyết định nhận nuôi bé chó hay mèo nào, bạn hãy tự hỏi bản thân rằng mình đã sẵn sàng để chịu trách nhiệm cả đời cho bé chưa, cả về tài chính, nơi ở cũng như tinh thần. Việc nhận nuôi cần được sự đồng thuận lớn từ bản thân bạn cũng như gia đình và những người liên quan. Xin cân nhắc kỹ trước khi liên hệ với chủ vật nuôi.
                                            Nếu bạn đã sẵn sàng, hãy thực hiện các bước sau đây nhé :</li>

                                        <li>1️⃣ Tìm hiểu về thú cưng bạn muốn nhận nuôi trên trang web.</li>
                                        <li>2️⃣ Liên hệ với chủ sở hữu hiện tại của thú cưng để trao đổi thêm thông tin.</li>
                                        <li>3️⃣ Chuẩn bị cơ sở vật chất, đồ dùng, thức ăn trước khi đón bé về.</li>
                                        <li>4️⃣ Thường xuyên cập nhật về tình hình của bé, đặc biệt là khi có sự cố để được tư vấn kịp thời.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header p-0" id="headingThree" role="tab">
                                <h2 class="mb-0">
                                    <button href="#collapseThree" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
                                        <p class="mb-0">Bạn Muốn Tìm "Một Ngôi Nhà Mới" Thú Cưng ?</p>
                                        <i class="fa" aria-hidden="true"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="collapse" id="collapseThree" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body py-3 px-0">
                                    <ol>
                                        <li> Nếu như hiện tại bạn đang không có khả năng tiếp tục chăm sóc thú cưng của mình hay vô tình bắt gặp những bạn thú cưng bị bỏ rơi, đừng ngần ngại tìm cho các bé một ngôi nhà mới, một người chủ luôn yêu thương các bé nhé !
                                            Quy trình đăng tin vô cùng đơn giản :
                                        </li>
                                        <li>1️⃣ Đảm bảo rằng bạn đã có tài khoản trên website và tiến hành đăng nhập ( tiến hành đăng ký nếu bạn chưa mở tài khoản ) </li>
                                        <li>2️⃣ Tại trang chủ, chọn đăng tin tìm chủ cho thú cưng</li>
                                        <li>3️⃣ Điền thông tin, lưu lại tình trạng sức khỏe, hình ảnh va các thông tin liên quan khác về bé </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header p-0" id="headingFour" role="tab">
                                <h2 class="mb-0">
                                    <button href="#collapseFour" class="d-flex py-3 px-4 align-items-center justify-content-between btn btn-link" data-parent="#accordion" data-toggle="collapse" aria-expanded="false" aria-controls="collapseFour">
                                        <p class="mb-0">Bạn có câu hỏi khác ? </p>
                                        <i class="fa" aria-hidden="true"></i>
                                    </button>
                                </h2>
                            </div>
                            <div class="collapse" id="collapseFour" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body py-3 px-0">
                                    <p>Liên hệ với chúng tôi tại Fanpage / Dấu Chân Nhỏ.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <h1 class="m-heading text-3xl lg:text-6xl hover:shadow-2xl antialiased hover:subpixel-antialiased">
        Một ngôi nhà mới
    </h1>
    <section class="content-pet">

        <div class="split left">
            <img src="./images/cat.png" alt="cat" class="cat" />
            <div class="text-pet">
                <p class="subtitle"> Thú cưng cần một ngôi nhà mới ?</p>
                <a href="adopt.php"><button class="button" id="right-button">Đăng ngay</button></a>
            </div>
        </div>
        <div class="split right">
            <img src="./images/dog.png" alt="dog" class="dog" />
            <div class="text-pet">
                <p class="subtitle">Cùng chung tay bảo vệ thú cưng </p>
                <a href="adopt.php"><button class="button" id="right-button">Đăng ngay</button></a>
            </div>
        </div>
    </section>
    <script src="dist/js/script2.js"></script>

    <section class="pet-card-flex">
        
        <br />
        <br />
        <div>
            <h1 class="m-heading text-3xl lg:text-6xl hover:shadow-2xl antialiased hover:subpixel-antialiased">
                Những dấu chân nhỏ
            </h1>
        </div>
                <br />
                
                <div class="one-line-card" id="meet">
                    
                <?php
        $conn = mysqli_connect('localhost', 'root', '', 'pet_shop_db');
        mysqli_set_charset($conn, 'UTF8');
        if (!$conn) {
            die("Kết nối thất bại. Vui lòng kiểm tra lại các thông tin máy chủ");
        }
        // Bước 02: Thực hiện truy vấn
        $result = mysqli_query($conn, "SELECT * FROM adopt_pet ORDER BY pet_id DESC limit 4; ");

        // Bước 03: Xử lý kết quả truy vấn
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $ten = $row['ten'];
                $pet_id = $row['pet_id'];
                $giongloai = $row['giongloai'];
                $gioitinh = $row['gioitinh'];
                $cannang = $row['cannang'];
                $get_img = mysqli_query($conn, "SELECT image_url FROM image WHERE pet_id = '{$pet_id}' limit 1; ");
                $row2 = mysqli_fetch_assoc($get_img);
                $img_url = $row2["image_url"];

        ?>
                    <div class="main-card card-height shadow-2xl">
                        
                        <div class="main-img">
                            <div class="hv rounded-lg shadow-lg max-w-xs card-img-div">
                                <a href="#">
                                    <img class="card-img-size" src="./uploads/adopt_pet/<?php
                                    echo $img_url;
                                    ?>" alt="" />
                                </a>
                            </div>
                        </div>
                        <div class="main-text">
                            <div class="p-4 flex flex-col gap-2">
                                <h4 class="text_5 md:text-[36px] font-bold mb-2 text-center">
                                    <?php
                                    echo $ten;
                                    ?>
                                </h4>
                                <ul class="grid grid-cols-2 gap-5 fs-1 text-dark list-unstyled" style="font-size:16px; font-weight: 500;">
                                    <li class="flex gap-2 text-lg">
                                        <span><b>Giống :</b> <?php
                                    echo $giongloai;
                                    ?></span>
                                    </li>
                                    <li class="flex text-xl justify-self-center">
                                        <span><b>Giới tính :</b> <?php
                                    echo $gioitinh;
                                    ?></span>
                                    </li>
                                    <li class="flex text-xl justify-self-center">
                                        <span> <b>Cân nặng : </b> <?php
                                    echo $cannang;
                                    ?></span>
                                    </li>
                                </ul>
                                <a class="self-center pt-2" href="view_thucung.php?uid=<?php echo $pet_id; ?>">
                                    <button type="button" class="btn btn-outline-danger mr-md-3 py-3 px-4"><b>Nhận Nuôi</b></button></a>
                            </div>
                        </div>
                    </div>
                    <?php
            }
        }
        ?>
                 </div>
                   
        



    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-5 mb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2>Pets Gallery</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-1.jpg);">
                        <a href="images/gallery-1.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Cat</span>
                                <h2><a href="work-single.html">Persian Cat</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-2.jpg);">
                        <a href="images/gallery-2.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Dog</span>
                                <h2><a href="work-single.html">Pomeranian</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-3.jpg);">
                        <a href="images/gallery-3.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Cat</span>
                                <h2><a href="work-single.html">Sphynx Cat</a></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-4.jpg);">
                        <a href="images/gallery-4.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Cat</span>
                                <h2><a href="work-single.html">British Shorthair</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-5.jpg);">
                        <a href="images/gallery-5.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Dog</span>
                                <h2><a href="work-single.html">Beagle</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ftco-animate">
                    <div class="work mb-4 img d-flex align-items-end" style="background-image: url(images/gallery-6.jpg);">
                        <a href="images/gallery-6.jpg" class="icon image-popup d-flex justify-content-center align-items-center">
                            <span class="fa fa-expand"></span>
                        </a>
                        <div class="desc w-100 px-4">
                            <div class="text w-100 mb-3">
                                <span>Dog</span>
                                <h2><a href="work-single.html">Pug</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section testimony-section" style="background-image: url('images/bg_2.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center pb-5 mb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2>Đánh giá</h2>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel ftco-owl">
                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
                                <div class="text">
                                    <p class="mb-4">Dấu Chân Nhỏ thực sự là một tổ chức tốt nhất mà tôi biết, tôi nghĩ rằng mọi người cần phải yêu thương cả những thú cưng nhỏ bé này nữa</p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Nguyễn Tùng Dương</p>
                                            <span class="position">Blogger</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap py-4">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></span></div>
                                <div class="text">
                                    <p class="mb-4">Tôi khá bất ngờ với hoạt động mang lại, không chỉ giúp tìm được mái ấm cho thú cưng mà còn bảo vệ chúng trước các mối nguy hiểm.</p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                                        <div class="pl-3">
                                            <p class="name">Bùi Anh Ninh</p>
                                            <span class="position">Nhân viên văn phòng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mb-4 mb-md-0">
                    <h2 class="footer-heading">Dấu Chân Nhỏ</h2>
                    <p>Hoạt động vì tình yêu thương</p>

                </div>
                <div class="col-md-6 col-lg-6 mb-4 mb-md-0">
                    <h2 class="footer-heading">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon fa fa-map"></span><span class="text">121 Trần Phú, Hà Đông, Hà Nội, Việt Nam</span></li>
                            <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+84 365676025</span></a></li>
                            <li><a href="#"><span class="icon fa fa-paper-plane"></span><span class="text">info@dauchannho.site</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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
    <div id="ftco-loader" class="show fullscreen" ><svg class="circular" width="68px" height="68px">
            <circle class="path-bg" cx="32" cy="32" r="30" fill="none" stroke-width="4" stroke="#00c5c7" />
            <circle class="path" cx="32" cy="32" r="30" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ffff" />
        </svg></div>


    <!-- <script src="js/jquery.min.js"></script> -->
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
    <script src="js/main.js"></script>



</body>

</html>