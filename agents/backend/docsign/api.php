<?php
include("../db.php");
header('Content-type: application/json');

if ($_GET['tag'] == "styleImg") {
	$id=$_POST['id'];
    $query="SELECT sno, fname, lname, student_no, contract_student_signature from ppp_form WHERE sno='$id'";
	$result=mysqli_query($con, $query);	
	$row2 = mysqli_fetch_assoc($result);
	$fname = $row2['fname'];
	$lname = $row2['lname'];
	$student_no = $row2['student_no'];
	$contract_student_signature = $row2['contract_student_signature'];
	if(!empty($contract_student_signature)){
		unlink("../Student_Sign/$contract_student_signature");
	}
	$fname2 = str_replace(' ', '', $fname);
	$fileName='Fix_'.$student_no.'_'."$fname2.png";
	$text = $fname.' '.$lname;

    $folderPath = "../Student_Sign/";
    $height = 130; // Canvas Height
    $width = 700;   //  Canvas Width 
 
    $x = 10;
    $y = 90;
    // size of the font to be written 
    $rotation = 0; // angle of rotation of text 

    if ($_POST['fid'] == 1) {
        $font_f = dirname(__FILE__) . '/PaulSignature-WEJY.ttf';
         $font_size = 70;
    }else if($_POST['fid'] == 2){
        $font_f = dirname(__FILE__) . '/Amadgone-BW1ax.otf';
        $font_size = 40;
    }else if($_POST['fid'] == 3){
        $font_f = dirname(__FILE__) . '/Heatwood-GOKPO.ttf';
        $font_size = 40;
    }else if($_POST['fid'] == 4){
        $font_f = dirname(__FILE__) . '/MaradonaSignature-DOMv0.otf';
        $font_size = 38;
    }else if($_POST['fid'] == 5){
        $font_f = dirname(__FILE__) . '/PandemiDemo-6Ygqx.ttf';
        $font_size = 70;
    }else if($_POST['fid'] == 6){
        $font_f = dirname(__FILE__) . '/SouthSand-qZ611.ttf';
        $font_size = 70;
    }

    // font family , set the path to arial.ttf file
    ///// Create the image ////////

    $im = @ImageCreate($width, $height) or die("Cannot Initialize new GD image stream");

    $background_color = ImageColorAllocate($im, 255, 255, 255);
    $text_color = ImageColorAllocate($im, 0, 0, 0);
    // imagestring($im, 5, 5, 5, $text, $text_color);
    imagettftext($im, $font_size, $rotation, $x, $y, $text_color, $font_f, $text);
    imagepng($im, $folderPath . $fileName);
    imagedestroy($im); // Memory allocation for the image is removed.     

    if(mysqli_num_rows($result)){
        $sql = "UPDATE ppp_form SET contract_student_signature='$fileName' WHERE sno='$id'";
        mysqli_query($con, $sql);
		$res = ['status' => 200];
    } else {
		$res = ['status' => 500];
    }    
    echo json_encode($res);
}