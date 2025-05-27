<?php
require_once ("assets/controler/VerifyClass.php");

$Verify=new Vrify();

if(isset($_POST["verify"])){
    $dat=true;
    $Verify->checkCode($_POST["cod"]);
    
}

if(isset($_GET["type"])){
    if($_GET["type"]=="error"){
        $Verify->SendEmail();
    } 
    if($_GET["type"]=="successemail"){
        header("Refresh: 2 ;http:Login.php");
    }

}
?>
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="./assets/public/css/style.css">
</head>

<body>
    <!-- فرم ورود -->
    <div class="form-container">
        <h2>فرم تایید ایمیل</h2>
        <?php if (isset($_GET['message'])): ?>
        <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <form action="" method="post">
            
            <div class="form-group">
                <label for="verifycod">کد ارسال شده به ایمیل را وارد کنید:</label>
                <input type="text"  name="cod" required>
            </div>
            <button type="submit" name="verify">ورود</button>
            
        </form>
    </div>



</body>

</html>