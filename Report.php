<?php 
require_once ("assets/controler/ReportClass.php");
$Report = new Report();

if (isset($_GET["action"])) {
    $dataR = "";
    if ($_GET["action"] == "Gender") {
        $dataR = "Gender";
        $Report->ReportGender();
    }
    if ($_GET["action"] == "provinces") {
        $dataR = "provinces";
        $Report->Reportprovinces();
    }
    if ($_GET["action"] == "city") {
        $dataR = "city";
        $Report->ReportCity();
    }
    if ($_GET["action"] == "Exel") {
        $type = $_GET["dataR"];
        $Report->exportExel($Report->listReport, $type);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/public/css/style.css">
    <title>گزارش گیری</title>
</head>
<body>
<?php if(isset($_SESSION["ID_User"])) {
    if($_SESSION["LevelID"] >= 3) {
        echo  '<script type="text/javascript">alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>';
        header("Refresh: 0; url=Login.php");
    } elseif($_SESSION["LevelID"] <= 3) { ?>
    <!-- نوبار -->
    <nav class="navbar">
        <ul>
            <li><a href="login.php">داشبورد</a></li>
            <li><a href="profile.php">پروفایل</a></li>
            <li><a href="users.php">لیست کاربران</a></li>
            <li><a href="maneger.php">لیست مدیران </a></li>
            <li><a href="state.php">لیست استان ها</a></li>
            <li><a href="Report.php"> گزارش گیری</a></li>
            <li><a href="log.php">مشاهده تغییرات کاربران</a></li>
            <li><a href="?action=exit">خروج</a></li>
        </ul>
    </nav>
    <?php } else { ?>
    <nav class="navbar">
        <ul>
            <li><a href="login.php">داشبورد</a></li>
            <li><a href="profile.php">پروفایل</a></li>
            <li><a href="?action=exit">خروج</a></li>
        </ul>
    </nav>
    <?php } ?>
    <nav class="navbar" style="background:gray">
        <h2 style="color:white; margin: 22px 16px 0 0;">لیست گزارش ها</h2>
        <ul>
            <li><a href="Report.php?action=Gender">گزارش کاربران بر اساس جنسیت</a></li>
            <li><a href="Report.php?action=provinces">گزارش کاربران بر اساس نام استان</a></li>
            <li><a href="Report.php?action=city">گزارش کاربران بر اساس شهرستان</a></li>
        </ul>
    </nav>

    <!-- جدول اطلاعات کاربر -->
    <div class="table-container">
        <h2>گزارش گیری</h2>
        <a href="chart.php">گزارش میله ای از تعداد ثبت نامی ها</a><br>
        <?php if (isset($_GET['message']) && $_GET['type'] == "success"): ?>
            <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($dataR)) {
            if($dataR == "Gender") { ?>
                <a href="Report.php?action=Exel&dataR=Gender">خروجی به صورت اکسل</a>
                <table>
                    <tr>
                        <th>جنسیت</th>
                        <th>ثبت نامی ها</th>
                    </tr>
                    <?php foreach($Report->listReport as $value): ?>
                    <tr>
                        <td><?php echo $value["gender"] == "male" ? "مرد" : "زن"; ?></td>
                        <td><?php echo $value["count"]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php } elseif($dataR == "provinces") { ?>
                <a href="Report.php?action=Exel&dataR=provinces">خروجی به صورت اکسل</a>
                <table>
                    <tr>
                        <th>استان</th>
                        <th>ثبت نامی ها</th>
                    </tr>
                    <?php foreach($Report->listReport as $value): ?>
                    <tr>
                        <td><?php echo $value["Province"]; ?></td>
                        <td><?php echo $value["count"]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php } elseif($dataR == "city") { ?>
                <a href="Report.php?action=Exel&dataR=city">خروجی به صورت اکسل</a>
                <table>
                    <tr>
                        <th>استان</th>
                        <th>شهرستان</th>
                        <th>ثبت نامی ها</th>
                    </tr>
                    <?php foreach($Report->listReport as $value): ?>
                    <tr>
                        <td><?php echo $value["Province"]; ?></td>
                        <td><?php echo $value["City"]; ?></td>
                        <td><?php echo $value["count"]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php }
        } ?>
    </div>
<?php } ?>
</body>
</html>
