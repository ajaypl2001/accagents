<?php
include("../db.php");

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$document->set_option('defaultFont', 'Courier');

$pdfid = $_GET['sno'];

$query = "SELECT * FROM st_application where sno='$pdfid'";
$result = mysqli_query($con, $query);

$output = "<style>
	.firstrow{width:100%;float:left;}
	.headertop{width:700px;float:left;font-size:24px;font-weight:bold;margin-top:0px;}
	.logo{width:200px;height:70px;float:right;margin-top:0px;margin-right:40px;}
	
	.firstrow #heading{float:left;margin-top:90px;background:#810000;color:#fff;width:100%;font-size:13px;font-weight: 700;text-align:center;padding:2px 0;}
	.three1{float:left;width:260px;margin-top:115px;border-bottom:2px solid #000;}
	.three11{float:left;width:200px;margin-top:135px;}
	.three2{float:left;width:260px;margin-left:33%;margin-top:115px;border-bottom:2px solid #000;}
	.three22{float:left;width:200px;margin-top:135px;margin-left:33%;}
	.three3{float:left;width:260px;margin-left:66%;margin-top:115px;border-bottom:2px solid #000;}
	.three33{float:left;width:200px;margin-top:135px;margin-left:66%;}
	
	.threeSec{float:left;width:260px;margin-top:165px;border-bottom:2px solid #000;}
	.threeSec1{float:left;width:200px;margin-top:185px;}
	.threeSec2{float:left;width:260px;margin-left:33%;margin-top:165px;border-bottom:2px solid #000;}
	.threeSec22{float:left;width:200px;margin-top:185px;margin-left:33%;}
	.threeSec3{float:left;width:260px;margin-left:66%;margin-top:165px;border-bottom:2px solid #000;}
	.threeSec33{float:left;width:200px;margin-top:185px;margin-left:66%;}	
	
	.firstrow #heading1{float:left;margin-top:210px;width:100%;font-size:13px;font-weight: 700;}
	.firstrow .address{float:left;margin-top:230px;width:30%;font-size:12px;}
	.firstrow .address1{float:left;margin-top:245px;width:30%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;padding-left:4px;}
	.firstrow .address2{float:left;margin-top:230px;margin-left:31%;width:30%;font-size:12px;}
	.firstrow .address22{float:left;margin-top:245px;margin-left:30.5%;width:30%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
	.firstrow .dob{float:left;margin-top:230px;margin-left:61.5%;width:20%;font-size:12px;}
	.firstrow .dob1{float:left;margin-top:245px;margin-left:61%;width:20%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
	.firstrow .pn{float:left;margin-top:230px;margin-left:82%;width:20%;font-size:12px;}
	.firstrow .pn1{float:left;margin-top:245px;margin-left:81.5%;width:18%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
		
	.firstrow .country{float:left;margin-top:270px;width:24%;font-size:12px;}
	.firstrow .country1{float:left;margin-top:285px;width:24%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;padding-left:4px;}
	.firstrow .state{float:left;margin-top:270px;margin-left:25%;width:24%;font-size:12px;}
	.firstrow .state1{float:left;margin-top:285px;margin-left:24.5%;width:24%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
	.firstrow .city{float:left;margin-top:270px;margin-left:49.5%;width:35%;font-size:12px;}
	.firstrow .city1{float:left;margin-top:285px;margin-left:49%;width:35%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
	.firstrow .pincode{float:left;margin-top:270px;margin-left:85%;width:15%;font-size:12px;}
	.firstrow .pincode1{float:left;margin-top:285px;margin-left:84.5%;width:15%;font-size:12px;border-bottom:1px solid #000;border-right:1px solid #000;padding-left:4px;}
	
	.firstrow #heading2{float:left;margin-top:310px;background:#810000;color:#fff;width:100%;font-size:13px;font-weight:700;text-align:center;padding:1px 0;}
	.firstrow .pi_pn{float:left;margin-top:335px;width:20%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .pi_pn1{float:left;width:20%;margin-top:346px;}
	.firstrow .pi_issued{float:left;margin-top:335px;width:22%;margin-left:22%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .pi_issued1{float:left;width:22%;margin-top:346px;margin-left:22%;}
	.firstrow .pi_expiry{float:left;margin-top:335px;margin-left:46%;width:25%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .pi_expiry1{float:left;width:23%;margin-top:346px;margin-left:46%;}
	.firstrow .pi_dob{float:left;margin-top:335px;margin-left:73%;width:27%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .pi_dob1{float:left;width:27%;margin-top:346px;margin-left:73%;}
			
	.firstrow #heading3{float:left;margin-top:371px;background:#810000;color:#fff;width:100%;font-size:13px;font-weight:700;text-align:center;padding:1px 0;}
	.firstrow .li1{float:left;width:15%;margin-top:379px;}
	.firstrow .li2{float:left;width:65%;margin-top:379px;margin-left:20%;}
	.firstrow .li3{float:left;width:20%;margin-top:379px;margin-left:65%;}
	
	.firstrow #heading4{float:left;margin-top:415px;background:#810000;color:#fff;width:100%;font-size:13px;font-weight:700;text-align:center;padding:1px 0;}
	.firstrow .qualification{float:left;margin-top:435px;width:20%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .qualification1{float:left;width:20%;margin-top:446px;}
	.firstrow .edut_type{float:left;margin-top:435px;width:38%;font-size:12px;border-bottom:1px solid #000;margin-left:22%;}
	.firstrow .edut_type1{float:left;width:38%;margin-top:446px;margin-left:22%;}
	.firstrow .marks{float:left;margin-top:435px;width:15%;font-size:12px;border-bottom:1px solid #000;margin-left:62%;}
	.firstrow .marks1{float:left;width:18%;margin-top:446px;margin-left:62%;}
	.firstrow .pass_year{float:left;margin-top:435px;width:18%;font-size:12px;border-bottom:1px solid #000;margin-left:82%;}
	.firstrow .pass_year1{float:left;width:18%;margin-top:446px;margin-left:82%;}
	
	.firstrow .unicountry{float:left;margin-top:470px;width:18%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .unicountry1{float:left;width:18%;margin-top:480px;}
	.firstrow .uniname{float:left;margin-top:470px;width:50%;font-size:12px;border-bottom:1px solid #000;margin-left:20%;}
	.firstrow .uniname1{float:left;width:80%;margin-top:480px;margin-left:20%;}
	
	.firstrow #heading5{float:left;margin-top:500px;width:100%;font-size:13px;font-weight: 700;}
	.firstrow .qualification2{float:left;margin-top:520px;width:20%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .qualification22{float:left;width:20%;margin-top:532px;}
	.firstrow .edut_type2{float:left;margin-top:520px;width:38%;font-size:12px;border-bottom:1px solid #000;margin-left:22%;}
	.firstrow .edut_type22{float:left;width:38%;margin-top:532px;margin-left:22%;}
	.firstrow .marks2{float:left;margin-top:520px;width:15%;font-size:12px;border-bottom:1px solid #000;margin-left:62%;}
	.firstrow .marks22{float:left;width:18%;margin-top:532px;margin-left:62%;}
	.firstrow .pass_year2{float:left;margin-top:520px;width:18%;font-size:12px;border-bottom:1px solid #000;margin-left:82%;}
	.firstrow .pass_year22{float:left;width:18%;margin-top:532px;margin-left:82%;}
	
	.firstrow .unicountry2{float:left;margin-top:552px;width:18%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .unicountry22{float:left;width:18%;margin-top:563px;}
	.firstrow .uniname2{float:left;margin-top:552px;width:50%;font-size:12px;border-bottom:1px solid #000;margin-left:20%;}
	.firstrow .uniname22{float:left;width:80%;margin-top:563px;margin-left:20%;}
	
	.firstrow #heading6{float:left;margin-top:583px;width:100%;font-size:13px;font-weight: 700;}
	.firstrow .qualification3{float:left;margin-top:596px;width:20%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .qualification33{float:left;width:20%;margin-top:608px;}
	.firstrow .edut_type3{float:left;margin-top:596px;width:38%;font-size:12px;border-bottom:1px solid #000;margin-left:22%;}
	.firstrow .edut_type33{float:left;width:38%;margin-top:608px;margin-left:22%;}
	.firstrow .marks3{float:left;margin-top:596px;width:15%;font-size:12px;border-bottom:1px solid #000;margin-left:62%;}
	.firstrow .marks33{float:left;width:18%;margin-top:608px;margin-left:62%;}
	.firstrow .pass_year3{float:left;margin-top:596px;width:18%;font-size:12px;border-bottom:1px solid #000;margin-left:82%;}
	.firstrow .pass_year33{float:left;width:18%;margin-top:608px;margin-left:82%;}
	
	.firstrow .unicountry3{float:left;margin-top:630px;width:18%;font-size:12px;border-bottom:1px solid #000;}
	.firstrow .unicountry33{float:left;width:18%;margin-top:640px;}
	.firstrow .uniname3{float:left;margin-top:630px;width:50%;font-size:12px;border-bottom:1px solid #000;margin-left:20%;}
	.firstrow .uniname33{float:left;width:80%;margin-top:640px;margin-left:20%;}
	
	.footer{float:left;margin-top:660px;width:100%;border:1px solid #000;height:40px;background:#D9D9D9;}
	.footer .heading7{float:left;width:50%;font-size:12px;font-weight:bold;padding-left:5px;}
	.footer .footer_add{float:left;width:50%;font-size:12px;font-weight:400;padding-left:5px;margin-top:13px;}
	.footer .footer_add1{float:left;width:50%;font-size:12px;font-weight:400;padding-left:5px;margin-top:25px;}
	
	.footer .heading8{float:left;width:50%;font-size:12px;font-weight:bold;margin-left:50%;}
	.footer .email_add{float:left;width:50%;font-size:12px;font-weight:bold;margin-left:50%;margin-top:13px;}
	.footer .emailaol{float:left;width:50%;font-size:12px;font-weight:bold;margin-left:50%;margin-top:25px;}
	.footer .mid{font-size:12px;font-weight:bold;color:#828282;}
	
	
</style>";
$firstrow = mysqli_fetch_assoc($result);
$dateofbirth = $firstrow["dob"];
$dtob = date("jS F, Y", strtotime("$dateofbirth")); 
$dtob1 = date("jS F, Y", strtotime("$dateofbirth")); 

$output .= '<div class="firstrow">
	<span class="headertop">Intermnational Student Application Form</span>
	<img src="logo.png" class="logo">
	<span id="heading">PERSONAL INFORMATION</span>
	<span class="three1">'.$firstrow["fname"].'</span>
	<span class="three11">First/Given Name</span>
	<span class="three2">'.$firstrow["lname"].'</span>
	<span class="three22">Last/Given Name</span>
	<span class="three3">'.$firstrow["email_address"].'</span>
	<span class="three33">Email Address</span>
	<span class="threeSec">'.$firstrow["gender"].'</span>
	<span class="threeSec1">gender</span>
	<span class="threeSec2">'.$firstrow["mobile"].'</span>
	<span class="threeSec22">Mobile Number</span>
	<span class="threeSec3">'.$firstrow["martial_status"].'</span>
	<span class="threeSec33">Martial Status</span>	
	<span id="heading1">Full Mailing Address</span>
	<span class="address">Addess1</span>
	<span class="address1">'.$firstrow["address1"].'</span>
	<span class="address2">Addess2</span>
	<span class="address22">'.$firstrow["address2"].'</span>
	<span class="dob">Date Of Birth</span>
	<span class="dob1">'.$dtob.'</span>
	<span class="pn">Passport Number</span>
	<span class="pn1">'.$firstrow["passport_no"].'</span>
	<span class="country">Country</span>
	<span class="country1">'.$firstrow["country"].'</span>
	<span class="state">State</span>
	<span class="state1">'.$firstrow["state"].'</span>
	<span class="city">CityTown</span>
	<span class="city1">'.$firstrow["city"].'</span>
	<span class="pincode">PIN Code</span>
	<span class="pincode1">'.$firstrow["pincode"].'</span>
	<span id="heading2">PASSPORT INFORMATION</span>
	<span class="pi_pn">'.$firstrow["passport_no"].'</span>
	<span class="pi_pn1">Passport Number</span>
	<span class="pi_issued">'.$firstrow["pp_issue_date"].'</span>
	<span class="pi_issued1">Date Of Issue</span>
	<span class="pi_expiry">'.$firstrow["pp_expire_date"].'</span>
	<span class="pi_expiry1">Date Of Expiry</span>	
	<span class="pi_dob">' .$dtob1.'</span>
	<span class="pi_dob1">Date Of Birth</span>
	<span id="heading3">PROGRAM OF INTEREST</span>
	<span class="li1"><b style="font-size:30px;">.</b> '.$firstrow["prg_name1"].'</span>
	<span class="li2"><b style="font-size:30px;">.</b> '.$firstrow["prg_type1"].'</span>
	<span class="li3"><b style="font-size:30px;">.</b> '.$firstrow["prg_intake"].'</span>
	<span id="heading4">Education Details</span>
	<span class="qualification">'.$firstrow["qualification1"].'</span>
	<span class="qualification1">Qualifications</span>
	<span class="edut_type">'.$firstrow["stream1"].'</span>
	<span class="edut_type1">Education Type</span>
	<span class="marks">'.$firstrow["marks1"].'</span>
	<span class="marks1">Marks(%)</span>
	<span class="pass_year">'.$firstrow["passing_year1"].'</span>
	<span class="pass_year1">Passing Year</span>
	<span class="unicountry">'.$firstrow["unicountry1"].'</span>
	<span class="unicountry1">University Country</span>
	<span class="uniname">'.$firstrow["uni_name1"].'</span>
	<span class="uniname1">University Name</span>';
	if($firstrow["qualification2"] !== ''){
	$output .= '<span id="heading5">Education Details(Optional)</span>
			<span class="qualification2">'.$firstrow["qualification2"].'</span>
			<span class="qualification22">Qualifications</span>
			<span class="edut_type2">'.$firstrow["stream2"].'</span>
			<span class="edut_type22">Education Type</span>
			<span class="marks2">'.$firstrow["marks2"].'</span>
			<span class="marks22">Marks(%)</span>
			<span class="pass_year2">'.$firstrow["passing_year2"].'</span>
			<span class="pass_year22">Passing Year</span>
			<span class="unicountry2">'.$firstrow["unicountry2"].'</span>
			<span class="unicountry22">University Country</span>
			<span class="uniname2">'.$firstrow["uni_name2"].'</span>
			<span class="uniname22">University Name</span>
	';
	}
	if($firstrow["qualification3"] !== ''){
	$output .= '<span id="heading6">Education Details(Optional)</span>
			<span class="qualification3">'.$firstrow["qualification3"].'</span>
			<span class="qualification33">Qualifications</span>
			<span class="edut_type3">'.$firstrow["stream3"].'</span>
			<span class="edut_type33">Education Type</span>
			<span class="marks3">'.$firstrow["marks3"].'</span>
			<span class="marks33">Marks(%)</span>
			<span class="pass_year3">'.$firstrow["passing_year3"].'</span>
			<span class="pass_year33">Passing Year</span>
			<span class="unicountry3">'.$firstrow["unicountry3"].'</span>
			<span class="unicountry33">University Country</span>
			<span class="uniname3">'.$firstrow["uni_name3"].'</span>
			<span class="uniname33">University Name</span>
	';
	}
	$output .= '<span class="footer">
				<span class="heading7">For more information, please contact:</span>
				<span class="footer_add">Academy of Learning College</span>
				<span class="footer_add1">123, xyz, AOL, Canada</span>
				<span class="heading8">Tel.No.:123-456-7891  Fax: 098-765-4321</span>
				<span class="email_add">Website: www.aol.com</span>
				<span class="emailaol">Email: <span class="mid">info@aol.com</span></span>
			</span>
	
	';
	$output .= '</div>';	


$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'landscape');

//Render the HTML as PDF

$document->render();

//Get output of generated pdf in Browser

$document->stream("Student-details", array("Attachment"=>0));
//1  = Download
//0 = Preview


?>