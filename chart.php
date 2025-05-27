<?php 
require_once ("assets/controler/ReportClass.php");
$Report = new Report();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>نمودار میله ای</title>
</head>
<body>
    
<?php if(isset($_SESSION["ID_User"])) {
    if($_SESSION["LevelID"] >= 3) {
        echo '<script type="text/javascript">alert(" شما اجازه ورود به این صفحه را ندارید ");</script>';
        header("Refresh: 0; url=Login.php");
    } elseif($_SESSION["LevelID"] <= 3) {
?>

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

<canvas id="myChart" width="400" height="200"></canvas>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        var chartData = <?php echo json_encode($Report->getUsersOfState()); ?>;
        var labels = chartData.map(function(item) { return item.state; });
        var data = chartData.map(function(item) { return item.count; });

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'تعداد کاربران',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php } ?>
</body>
</html>
