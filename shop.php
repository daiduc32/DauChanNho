<?php require_once('config.php'); ?>
<?php 
  if(isset($_GET['payment_method'])){
      $amount = $_GET['amount'];
      $paid = $_GET['paid'];
      $delivery_address = $_GET['delivery_address'];
      $client_id = $_GET['client_id'];

      $vnp_TxnRef = rand(1,10000); 
      $vnp_Amount =  $amount*100; 
      $vnp_BankCode = 'atm';
      $vnp_Locale = 'vn'; 
      $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; 
      date_default_timezone_set('Asia/Ho_Chi_Minh');
      $vnp_TmnCode = "2EXE1VOI"; 
      $vnp_HashSecret = "NCCKOMUNIMIBORJBFINSUIRTBYGOUMWX"; 
      $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
      $vnp_Returnurl = 'http://localhost:81/p1/shop.php?p=checkout';
      $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
      $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
      $startTime = date("YmdHis");
      $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
      $inputData = array(
          "vnp_Version" => "2.1.0",
          "vnp_TmnCode" => $vnp_TmnCode,
          "vnp_Amount" => $vnp_Amount,
          "vnp_Command" => "pay",
          "vnp_CreateDate" => date('YmdHis'),
          "vnp_CurrCode" => "VND",
          "vnp_IpAddr" => $vnp_IpAddr,
          "vnp_Locale" => $vnp_Locale,
          "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
          "vnp_OrderType" => "other",
          "vnp_ReturnUrl" => $vnp_Returnurl,
          "vnp_TxnRef" => $vnp_TxnRef,
          "vnp_ExpireDate"=>$expire
      );
      if(isset($request->bankCode) && $request->bankCode != ''){
          $inputData['vnp_BankCode'] = $request->bankCode;
      }
      ksort($inputData);
      $query = "";
      $i = 0;
      $hashdata = "";
      foreach ($inputData as $key => $value) {
          if ($i == 1) {
              $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
          } else {
              $hashdata .= urlencode($key) . "=" . urlencode($value);
              $i = 1;
          }
          $query .= urlencode($key) . "=" . urlencode($value) . '&';
      }

      $vnp_Url = $vnp_Url . "?" . $query;
      if (isset($vnp_HashSecret)) {
          $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
          $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
      }
      header('Location: ' . $vnp_Url);
      die();
  }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body>
<?php require_once('inc/topBarNav.php') ?>
<?php $page = isset($_GET['p']) ? $_GET['p'] : 'home';  ?>
<?php 
    if(!file_exists($page.".php") && !is_dir($page)){
        include '404.html';
    }else{
    if(is_dir($page))
        include $page.'/index.php';
    else
        include $page.'.php';

    }
?>
<?php require_once('inc/footer.php') ?>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Thông báo</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Đồng ý</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
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
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Lưu</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
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

</body>
</html>