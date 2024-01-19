<?php
require_once('./config.php');
$total = 0;
$qry = $conn->query("SELECT c.*,p.product_name,i.size,i.price,p.id as pid from `cart` c inner join `inventory` i on i.id=c.inventory_id inner join products p on p.id = i.product_id where c.client_id = " . $_settings->userdata('id'));
while ($row = $qry->fetch_assoc()) :
    $total += $row['price'] * $row['quantity'];
endwhile;
if (isset($_GET['vnp_SecureHash'])) {
    $info_vnpay_return = $_GET;
    $vnp_HashSecret = "NCCKOMUNIMIBORJBFINSUIRTBYGOUMWX";
    $inputData = array();
    foreach ($info_vnpay_return as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash_ = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    $conn = mysqli_connect('localhost', 'root', '', 'pet_shop_db');
    mysqli_set_charset($conn, 'UTF8');
    if (!$conn) {
        die("Kết nối thất bại. Vui lòng kiểm tra lại các thông tin máy chủ");
    }
    if ($secureHash_ == $_GET['vnp_SecureHash']) {
        if ($_GET['vnp_ResponseCode'] == '00') {
            $status = 'success';
            $msg = 'Giao dịch thành công';
            // Xử lý thêm dữ liệu vào sql
            $amount = ($_GET['vnp_Amount'] / 100);
            $delivery_address = $_settings->userdata('address');
            $client_id = $_settings->userdata('id');

            $data = " client_id = '{$client_id}' ";
            $data .= " ,payment_method = 'ATM' ";
            $data .= " ,amount = '{$amount}' ";
            $data .= " ,paid = '1' ";
            $data .= " ,delivery_address = '{$delivery_address}' ";

            $order_sql = "INSERT INTO `orders` set $data";
            $save_order = mysqli_query($conn, $order_sql);


            if ($save_order) {

                $order_id = mysqli_insert_id($conn);
                $data = '';

                $cart = mysqli_query($conn, "SELECT c.*,p.product_name,i.size,i.price,p.id as pid,i.unit 
                             FROM `cart` c 
                             INNER JOIN `inventory` i ON i.id=c.inventory_id 
                             INNER JOIN products p ON p.id = i.product_id 
                             WHERE c.client_id ='{$client_id}'");

                while ($row = mysqli_fetch_assoc($cart)) {
                    if (!empty($data)) $data .= ", ";
                    $total = $row['price'] * $row['quantity'];
                    $data .= "('{$order_id}','{$row['pid']}','{$row['size']}','{$row['unit']}','{$row['quantity']}','{$row['price']}', $total)";
                }

                // Thực hiện chèn dữ liệu chi tiết đơn hàng vào bảng order_list
                if (!empty($data)) {
                    $list_sql = "INSERT INTO `order_list` (order_id, product_id, size, unit, quantity, price, total) VALUES {$data}";
                    $save_olist = mysqli_query($conn, $list_sql);

                    if (!$save_olist) {
                        die("Lỗi: " . mysqli_error($conn));
                    }
                    if ($save_olist) {
                        $empty_cart = mysqli_query($conn, "DELETE FROM `cart` where client_id = '{$client_id}'");
                        $data = " order_id = '{$order_id}'";
                        $data .= " ,total_amount = '{$amount}'";
                    } else {
                        $status = 'danger';
                        $msg = 'Error';
                    }
                }
            } else {
                $status = 'danger';
                $msg = 'Error';
            } 

?>

            <script>
                alert_toast("Đặt hàng thành công ! ", "success")
                setTimeout(function() {
                    window.location.href = 'shop.php'; // 
                }, 3000);
            </script>
<?php

        } else {
            $status = 'danger';
            $msg = 'Giao dịch không thành công';
        }
    } else {
        $status = 'danger';
        $msg = 'Lỗi chữ ký không hợp lệ';
    }
}
mysqli_close($conn);
?>
<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body"></div>
            <h3 class="text-center"><b>Thanh toán</b></h3>
            <hr class="border-dark">
            <form action="" id="place_order">
                <input type="hidden" name="amount" value="<?php echo $total ?>">
                <input type="hidden" name="payment_method" value="cod">
                <input type="hidden" name="paid" value="0">
                <div class="row row-col-1 justify-content-center">
                    <div class="col-6">
                        <div class="form-group col">
                            <label for="" class="control-label">Địa chỉ nhận hàng</label>
                            <textarea require id="" cols="30" rows="3" name="delivery_address" class="form-control" style="resize:none"><?php echo $_settings->userdata('address') ?></textarea>
                        </div>
                        <div class="col">
                            <span>
                                <h4><b>Thành tiền :</b> <?php echo number_format($total) ?></h4>
                            </span>
                        </div>
                        <hr>
                        <div class="col my-3 mb-5" style="font-size: 14px !important">
                            <label for="" class="control-label">Phương thức thanh toán </label>

                            <div class="d-flex w-100 justify-content-between mb-2">
                                <button class="btn btn-flat btn-dark">Ship COD</button>

                                <a href="?payment_method=atm&amount=<?php echo $total ?>&paid=0&delivery_address=<?php echo $_settings->userdata('address') ?>&client_id=<?php echo $_settings->userdata('id') ?>" class="btn btn-flat btn-dark">ATM</a>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    $(function() {
        $('#place_order').submit(function(e) {
            e.preventDefault()
            start_loader();

            $.ajax({
                url: 'classes/Master.php?f=place_order',
                method: 'POST',
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("Error", "error")
                    end_loader();

                },
                success: function(resp) {
                    if (!!resp.status && resp.status == 'success') {
                        alert_toast("Đặt hàng thành công !", "success")
                        setTimeout(function() {
                            location.replace('./shop.php')
                        }, 2000)
                    } else {
                        console.log(resp)
                        alert_toast("error", "error")
                        end_loader();
                    }
                }
            })
        })
    })
</script>