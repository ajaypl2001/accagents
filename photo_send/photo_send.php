<?php 
// $name3 = $_FILES['image_file']['name'];
// $tmp3 = $_FILES['image_file']['tmp_name'];

// $fullname1 = str_replace(' ', '', $fullname);
	
// $extension = pathinfo($name3, PATHINFO_EXTENSION);
$img_name3 = 'Baljit_Singh.jpg';			
$img_name13 = 'Lovepreet_Kaur.jpg';			
// move_uploaded_file($tmp3, 'uploads/'.$img_name3);


$message = "<table>
	 <tr>
		<th>Fullname:</th>
		<td>Sanjiv Modanwal</td>
		</tr>
	  </table>";


$file = "https://aoltorontoagents.ca/photo_send/" . $img_name3;
$file1 = "https://aoltorontoagents.ca/photo_send/" . $img_name13;

$subject = "Test File photo";

$content = file_get_contents($file);
$content = chunk_split(base64_encode($content));

$content1 = file_get_contents($file1);
$content1 = chunk_split(base64_encode($content1));

$separator = md5(time());
$eol = "\r\n";

// main header
$headers = "From: AOL <aol@aoltoronto.com>" . $eol;
//$headers .= 'Cc: avneet@essglobal.com' . $eol;
$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
$headers .= "This is a MIME encoded message." . $eol;

// message
$body = "--" . $separator . $eol;
$body .= "Content-Type: text/html; charset=\"UTF-8\"" . $eol;
$body .= "Content-Transfer-Encoding: 7bit" . $eol;
$body .= $message . $eol;

// attachment
$body .= "--" . $separator . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $img_name3 . "\"" . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $img_name13 . "\"" . $eol;
$body .= "Content-Transfer-Encoding: base64" . $eol;
$body .= "Content-Disposition: attachment" . $eol;
$body .= $content . $eol;
$body .= $content1 . $eol;
$body .= "--" . $separator . "--";

$to = 'sanjiv@essglobal.com';

mail ($to,$subject,$body,$headers);


?>