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
     <div class="container px-4 px-lg-5 mt-5">
         <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
             <?php
                $products = $conn->query("SELECT * FROM `products` where status = 1 order by rand() limit 16 ");
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
                             <h5 class="text-danger text-bold" ><?php echo  $formatted_price; ?></h5>
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
         </div>
     </div>
 </section>