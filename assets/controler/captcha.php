<?php
session_start();

// تنظیمات تصویر
$image_width = 200;
$image_height = 70;
$font_size = 24;

// تولید رشته تصادفی برای CAPTCHA (فقط اعداد با طول 6 تا 8 رقم)
$captcha_length = rand(6, 8); // طول تصادفی بین 6 تا 8 رقم
$captcha_text = '';
for ($i = 0; $i < $captcha_length; $i++) {
    $captcha_text .= rand(0, 9);
}

// تابع تبدیل اعداد انگلیسی به فارسی
// function convertToPersianNumbers($string) {
//     $persian_numbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
//     $english_numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
//     return str_replace($english_numbers, $persian_numbers, $string);
// }

// تبدیل اعداد CAPTCHA به فارسی
$captcha_text_persian = $captcha_text;

// ذخیره رشته CAPTCHA در سشن
$_SESSION['captcha_text'] = $captcha_text;

// ایجاد تصویر
$image = imagecreatetruecolor($image_width, $image_height);

// تنظیم رنگ‌ها
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 64, 64, 64);

// پر کردن پس‌زمینه
imagefilledrectangle($image, 0, 0, $image_width, $image_height, $background_color);

// اضافه کردن خطوط نویز
for ($i = 0; $i < 10; $i++) {
    imageline($image, 0, rand() % $image_height, $image_width, rand() % $image_height, $line_color);
}

// اضافه کردن متن CAPTCHA
$font = __DIR__ . '/arial.ttf'; // مسیر به فونت TrueType (TTF) خود
if (file_exists($font)) {
    imagettftext($image, $font_size, 0, 15, 50, $text_color, $font, $captcha_text_persian);
} else {
    // در صورتی که فایل فونت وجود نداشته باشد از فونت داخلی استفاده می‌کنیم
    imagestring($image, 5, 30, 25, $captcha_text_persian, $text_color);
}

// تنظیم هدر HTTP برای ارسال تصویر
header('Content-Type: image/png');

// خروجی تصویر
imagepng($image);

// آزادسازی حافظه
imagedestroy($image);
?>
