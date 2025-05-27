<?php
require 'assets/controler/DBConnection.php';

$connInstance = new connection();
$conn = $connInstance->connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['province_id'])) {
    $province_id = intval($_POST['province_id']);

    if ($province_id > 0) {
        $stmt = $conn->prepare("SELECT * FROM cities WHERE province_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $province_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $options = "<option value=''>انتخاب شهرستان</option>";
            while ($city = $result->fetch_assoc()) {
                $options .= "<option value='{$city['IDCity']}'>{$city['CityName']}</option>";
            }
            echo $options;
        } else {
            echo "<option value=''>خطا در آماده‌سازی کوئری</option>";
        }
    } else {
        echo "<option value=''>انتخاب شهرستان</option>";
    }
} else {
    echo "<option value=''>انتخاب شهرستان</option>";
}
?>
