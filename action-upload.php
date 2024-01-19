<?php require_once('config.php'); ?>
<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "pet_shop_db");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $uploadsDir = "uploads/adopt_pet/";
    $allowedFileType = array('jpg', 'png', 'jpeg');
    $ten = $_POST['ten'];
    $loai = $_POST['loai'];
    $tuoi = $_POST['tuoi'];
    $giongloai = $_POST['giongloai'];
    $mausac = $_POST['mausac'];
    $gioitinh = $_POST['gioitinh'];
    $cannang = $_POST['cannang'];
    $mota = $_POST['mota'];
    $user_id =  $_settings->userdata('id');

    $sqlInsertPet = "INSERT INTO adopt_pet (ten, user_id, loai, tuoi, giongloai, mausac, gioitinh, cannang, mota, trangthai) VALUES ('$ten', '$user_id','$loai','$tuoi', '$giongloai', '$mausac','$gioitinh', '$cannang', '$mota', 'Đang tìm chủ')";

    // Velidate if files exist
    if (!empty(array_filter($_FILES['fileUpload']['name']))) {
        if ($conn->query($sqlInsertPet) === TRUE) {
            // Lấy pet_id mới được tạo
            $petId = $conn->insert_id;
        }
        // Loop through file items
        foreach ($_FILES['fileUpload']['name'] as $id => $val) {
            // Get files upload path
            $fileName        = $_FILES['fileUpload']['name'][$id];
            $tempLocation    = $_FILES['fileUpload']['tmp_name'][$id];
            $targetFilePath  = $uploadsDir . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $uploadDate      = date('Y-m-d H:i:s');
            $uploadOk = 1;
            if (in_array($fileType, $allowedFileType)) {
                if (move_uploaded_file($tempLocation, $targetFilePath)) {
                    $sqlVal = "('" . $petId . "' , '" . $fileName . "', '" . $uploadDate . "')";
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "File coud not be uploaded."
                    );
                }
            } else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Chỉ được upload ảnh có định dạng .jpg, .jpeg và .png"
                );
            }
            // Add into MySQL database
            if (!empty($sqlVal)) {
                $insert = $conn->query("INSERT INTO image (pet_id, image_url, date_time) VALUES $sqlVal");
                if ($insert) {
                    echo '<script>alert("Đăng ký thông tin thú cưng thành công ! ");</script>';
                    echo '<script>window.location.href = "adopt.php"; </script>';
                } else {
                    echo '<script>alert("Đã xảy ra lỗi ! ");</script>';
                    echo '<script>window.location.href = "adopt.php"; </script>';
                }
            }
        }
    } else {
        // Error
        echo '<script>alert("Bạn cần tải lên ít nhất 1 hình ảnh về vật nuôi ! ");</script>';
        echo '<script>window.location.href = "adopt.php"; </script>';
        exit();
    }
}
// Đóng kết nối
$conn->close();
?>