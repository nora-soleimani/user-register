<?php 
require_once ("assets/controler/LoginClass.php");
require_once ("assets/controler/SearchClass.php");
require_once ("assets/controler/ProvincesClass.php");


 $Search=new Search();
 $Provinces=new Provinces();

 $Provinces->Show_Provinces();

 if(isset($_POST["search"])){
    $list=true;
    $Search->search($_POST);
    

}
 if (isset($_GET["action"])) {

    if($_GET["action"]=="exit"){
        session_destroy();
        header("location:login.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/public/css/style.css">
    <link rel="stylesheet" href="./assets/public/css/pikaday.css">
    <link rel="stylesheet" href="./assets/public/css/persian-datepicker.min.css">
    <title>جست وجو</title>

</head>

<body>

<?php if(isset($_SESSION["ID_User"])){
  
        if($_SESSION["LevelID"]>=3){
       
             echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
            
            header("Refresh: 0 ;http:Login.php");
        } 
        elseif($_SESSION["LevelID"]<=3){
   
      ?>
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
    <?php 
        }else{ 
           
                ?>
    <nav class="navbar">
    <ul>
        <li><a href="login.php">داشبورد</a></li>
        <li><a href="profile.php">پروفایل</a></li>
        <li><a href="?action=exit">خروج</a></li>
    </ul>
    </nav>
    <?php
        }
        ?>

    <div class="form-container">

        <h2>فرم جست و جو</h2>

        <?php if (isset($_GET['message'])): 
            if($_GET['type']=="success"){?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php
            }
            ?>      
        <?php endif; ?>
        <?php if (isset($_GET['message'])): ?>
        <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <form action="" method="post" >
            <div class="form-group">
                <label for="firstName">نام:</label>
                <input type="text" id="firstName" name="firstName" >
            </div>
            <div class="form-group">
                <label for="lastName">نام خانوادگی:</label>
                <input type="text" id="lastName" name="lastName" >
            </div>   
            <div class="form-group">
                <label for="province">استان:</label>
                <select id="province" name="province" > 
                    <?php foreach ($Provinces->provinceslist as $value){ ?>
                    <option value="<?php echo $value["IDProvince"];?>"><?php echo $value["ProvinceName"];?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="city">شهرستان:</label>
                <select id="city" name="city" >
                <option value="">انتخاب شهرستان</option>

                </select>
            </div>
            
            <button type="submit"  name="search">جست و جو</button>
        </form>     

    </div>    
    <?php
        if(isset($list)){
            ?>
    <!-- جدول اطلاعات کاربر -->
    <div class="table-container">
    <h2>نمایش جست و جو اطلاعات  کاربر</h2>
        <table>
            <tr>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>شماره همراه</th>
                <th>تاریخ تولد</th>
                <th>جنسیت</th>
                <th>ایمیل</th>
                <th>استان</th>
                <th>شهرستان</th>
            </tr>
            <?php
            
                foreach($Search->listsearch as $value){ 
                    ?>
                <tr>
                   
                    <td><?php echo $value["first_name"]; ?></td>
                    <td><?php  echo $value["last_name"]; ?></td>
                    <td><?php  echo $value["national_code"]; ?></td>
                    <td><?php  echo $value["phone_number"]; ?></td>
                    <td><?php  echo $value["birth_date"]; ?></td>
                    <td><?php if($value["gender"]=="male"){ echo "مرد";}else{ echo "زن" ;} ?></td>
                    <td><?php  echo $value["email"]; ?></td>
                    <td><?php  echo $value["ProvinceName"]; ?></td>
                    <td><?php  echo $value["CityName"]; ?></td>
                </tr>
                <?php
                }
            }
            ?>
        </table>
    </div>
           
        <?php

        }
    else{
        echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
        header("Refresh: 0;location:login.php");
    }?>
    <script src="./assets/public/js/jquery.min.js"></script>
    <script src="./assets/public/js/pikaday.js"></script>
    <script src="./assets/public/js/persian-date.js"></script>
    <script src="./assets/public/js/persian-datepicker.js"></script>

    <script>
       $(document).ready(function() {
        

            $('#province').change(function() {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        type: 'POST',
                        url: 'getCitiesByProvince.php',
                        data: {province_id: provinceId},
                        success: function(response) {
                            $('#city').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error in AJAX request:', status, error);
                            alert('خطا در بارگذاری شهرستان‌ها');
                        }
                    });
                } else {
                    $('#city').html('<option value="">انتخاب شهرستان</option>');
                }
            });
        });
    </script>
</body>

</html>

