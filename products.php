<?php
$title = "Your Pets Deserve The Best";
$sub_title = "Explore our products for your pet.";
if (isset($_GET['c']) && isset($_GET['s'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $title = $cat_qry->fetch_assoc()['category'];
    }
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $sub_title = $sub_cat_qry->fetch_assoc()['sub_category'];
    }
} elseif (isset($_GET['c'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $title = $cat_qry->fetch_assoc()['category'];
    }
} elseif (isset($_GET['s'])) {
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $title = $sub_cat_qry->fetch_assoc()['sub_category'];
    }
}
?>
<!-- Header-->
<div class="container">
  <div class="row">
  <div class="col-md-3 mb-3 mt-3"><img src="./images/mienphivanchuyen.png" alt="Image 1" class="img-fluid"></div>

<div class="col-md-3 mb-3 mt-3"><img src="./images/sanphamchinhhang.png" alt="Image 1" class="img-fluid">
</div>
<div class="col-md-3 mb-3 mt-3"><img src="./images/thanhtoantienloi.png" alt="Image 1" class="img-fluid">
</div>
<div class="col-md-3 mb-3 mt-3"> <img src="./images/hotrochuyennghiep.png" alt="Image 1" class="img-fluid">
</div>


    <div class="col-md-6">
    <img src="./images/banner_dog.png" alt="Image 1" class="img-fluid">
    </div>
    <div class="col-md-6">
    <img src="./images/banner_cat.png" alt="Image 2" class="img-fluid">
    </div>
  </div>
</div>
<!-- Section-->
<section class="py-5">
    <div class="container">
        <?php
        if (isset($_GET['search'])) {
            echo "<h5 class='text-center; mb-5'><b>Kết quả tìm kiếm cho '" . $_GET['search'] . "'</b></h5>";
        }
        ?>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            $whereData = "";
            if (isset($_GET['search']))
                $whereData = " and (product_name LIKE '%{$_GET['search']}%' or description LIKE '%{$_GET['search']}%')";
            elseif (isset($_GET['c']) && isset($_GET['s']))
                $whereData = " and (md5(category_id) = '{$_GET['c']}' and md5(sub_category_id) = '{$_GET['s']}')";
            elseif (isset($_GET['c']))
                $whereData = " and md5(category_id) = '{$_GET['c']}' ";
            elseif (isset($_GET['s']))
                $whereData = " and md5(sub_category_id) = '{$_GET['s']}' ";
            $products = $conn->query("SELECT * FROM `products` where status = 1 {$whereData} order by rand() ");
            while ($row = $products->fetch_assoc()) :
                $upload_path = base_app . '/uploads/product_' . $row['id'];
                $img = "";
                if (is_dir($upload_path)) {
                    $fileO = scandir($upload_path);
                    if (isset($fileO[2]))
                        $img = "uploads/product_" . $row['id'] . "/" . $fileO[2];
                    // var_dump($fileO);
                }
                $inventory = $conn->query("SELECT MIN(price) AS price FROM inventory where product_id = " . $row['id'] . " ");
                if (mysqli_num_rows($inventory) > 0) {
                    while ($row2 = mysqli_fetch_assoc($inventory)) {
                        $price = $row2['price'];
                        $formatted_price = number_format($price, 0, '', '.') . ' ₫';
                    }
                }
            ?>
                                <div class="col mb-5">
                    <div class="card h-100 product-item">
                        <!-- Product image-->
                        <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <!-- Product name-->
                            <p class="text-dark"><?php echo $row['product_name'] ?></p>
                            <!-- Product price-->
                            <h5 class="text-danger text-bold"><?php echo  $formatted_price; ?></h5>
                            <div class="text-bold">
                                <div class="star-rating">
                                    <strong class="rating"></strong>
                                </div>
                            </div>

                            <style>
                                .star-rating {
                                    font-size: 18px;
                                    /* Kích thước ngôi sao */
                                }

                                .rating {
                                    width: 80%;
                                    /* Thay đổi chiều rộng để thể hiện số sao đánh giá */
                                }

                                .rating:before {
                                    content: "⭐⭐⭐⭐⭐";
                                }
                            </style>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-flat btn-primary " href="shop.php?p=view_product&id=<?php echo md5($row['id']) ?>">Xem thêm</a>
                            </div>

                        </div>
                    </div>
                </div>


            <?php endwhile; ?>
            <?php
            if ($products->num_rows <= 0) {
                echo "<h4 class='text-center'><b>Không có sản phẩm này</b></h4>";
            }
            ?>
        </div>
    </div>
</section>
