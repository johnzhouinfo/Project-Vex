<?php
session_start();

//default returned color is black
$image = imagecreatetruecolor(100, 30);
//set the background color to white
$bgcolor = imagecolorallocate($image, 255, 255, 255);
//fill the white color into the whole image
imagefill($image, 0, 0, $bgcolor);

//add empty stings to the original strings after every loop
$captcha_code = '';

//captcha code is four randomized numbers
for ($i = 0; $i < 4; $i++) {
    $fontsize = 6;
    $fontcolor = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));

    //randomly generate number form 0-9
    $fontcontent = rand(0, 9);
    $captcha_code .= $fontcontent;
    //0's position is at the top left corner,incoindient causes incompletely display
    $x = ($i * 100 / 4) + rand(5, 10);
    $y = rand(5, 10);
    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
}


$_SESSION['authcode'] = $captcha_code;
//assign captcha interference element, gives better control on colors
//Dot
for ($i = 0; $i < 200; $i++) {
    $pointcolor = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
    imagesetpixel($image, rand(1, 99), rand(1, 29), $pointcolor);
}

//add interference element to captcha
//line
for ($i = 0; $i < 3; $i++) {
    $linecolor = imagecolorallocate($image, rand(80, 220), rand(80, 220), rand(80, 220));
    imageline($image, rand(1, 99), rand(1, 29), rand(1, 99), rand(1, 29), $linecolor);
}

header('content-type:image/png');
imagepng($image);

//delete the image
imagedestroy($image);
