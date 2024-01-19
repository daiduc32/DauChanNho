<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container ">
                <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <a class="navbar-brand" href="./">
                <img src="./images/logo-shop.png" width="52px" class="d-inline-block align-top mr-3" alt="" loading="lazy">
                <!-- Dấu Chân Nhỏ -->
                </a>

                <form class="form-inline" id="search-form">
                  <div class="input-group">
                    <input class="form-control form-control-sm form " style="height: 42px;" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search" name="search"  value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>"  aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-dark" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </form>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item mr-2 ml-2 text-bold "><a class="nav-link" aria-current="page" href="http://localhost:81/p1/shop.php" style="color: black !important">Trang chủ</a></li>
                        <?php 
                        $cat_qry = $conn->query("SELECT * FROM categories where status = 1 ");
                        while($crow = $cat_qry->fetch_assoc()):
                          $sub_qry = $conn->query("SELECT * FROM sub_categories where status = 1 and parent_id = '{$crow['id']}' ");
                          if($sub_qry->num_rows <= 0):
                        ?>
                        <li class="nav-item mr-2 ml-2 text-bold "><a class="nav-link" aria-current="page" href=".?p=products&c=<?php echo md5($crow['id']) ?>" style="color: black !important"><?php echo $crow['category'] ?> </a></li>
                        
                        <?php else: ?>
                        <li class="nav-item mr-2 ml-2 text-bold dropdown">
                          <a class="nav-link dropdown-toggle" id="navbarDropdown<?php echo $crow['id'] ?>" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="color: black !important"><?php echo $crow['category'] ?></a></a>
                            <ul class="dropdown-menu  p-0" aria-labelledby="navbarDropdown<?php echo $crow['id'] ?>">
                              <?php while($srow = $sub_qry->fetch_assoc()): ?>
                                <li><a class="dropdown-item border-bottom" href=".?p=products&c=<?php echo md5($crow['id']) ?>&s=<?php echo md5($srow['id']) ?>"><?php echo $srow['sub_category'] ?></a></li>
                            <?php endwhile; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                    <div class="d-flex align-items-center">
                      <?php if(!isset($_SESSION['userdata']['id'])): ?>
                        <button class="btn btn-outline-dark ml-2" id="login-btn" type="button">Đăng nhập</button>
                        <?php else: ?>
                        <a class="text-dark mr-2 nav-link" href="http://localhost:81/p1/shop.php?p=cart">
                            <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count">
                            <i class="bi bi-cart4" style="font-size:22px;"></i>
                              <?php 
                              if(isset($_SESSION['userdata']['id'])):
                                $count = $conn->query("SELECT SUM(quantity) as items from `cart` where client_id =".$_settings->userdata('id'))->fetch_assoc()['items'];
                                echo ($count > 0 ? $count : 0);
                              else:
                                echo "0";
                              endif;
                              ?>
                            </span>
                        </a>
                        
                            <a href="http://localhost:81/p1/shop.php?p=my_account" class="text-dark  nav-link"><i class="bi bi-person-circle"style="font-size:22px;"></i></a>
                            <a href="http://localhost:81/p1/logout.php" class="text-dark  nav-link"><i class="fa fa-sign-out-alt" style="font-size:22px;"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = 'http://localhost:81/p1/shop.php?p=products&search='+sTxt;
  })
</script>