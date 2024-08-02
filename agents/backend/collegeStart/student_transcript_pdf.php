<?php
include("../../db.php");
date_default_timezone_set("America/Toronto");

require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$document = new Dompdf();
$document->set_option('/defaultFont', '/Courier');

// print_r($_GET['snoApp']);
// die;

if(!empty($_GET['snoApp'])){
	$snoApp = $_GET['snoApp'];	
	$qryModule_5 = "SELECT * FROM student_transcript WHERE app_id='$snoApp'";
	$rsltModule_5 = mysqli_query($con, $qryModule_5);
	$rowModule_5 = mysqli_fetch_assoc($rsltModule_5);
	$class_crs = $rowModule_5['class'];
	$date_of_issue = $rowModule_5['date_of_issue'];
	if(empty($date_of_issue)){
		$date_issue = $date_of_issue;	
	}else{
		$date_issue = date('Y/m/d');
	}
	$ipstatus = $rowModule_5['status_ip'];
	$expected_date = $rowModule_5['end_date'];
	$official_unofficail = $rowModule_5['official_unofficail'];	
}else{
	$class_crs = $_POST['class_crs'];
	$date_issue = $_POST['date_issue'];
	$ipstatus = $_POST['ipstatus'];
	$snoApp = $_POST['snoApp'];
	$official_unofficail = $_POST['official_unofficail'];
	$expected_date = $_POST['end_date'];
}

$qryModule = "SELECT sno, student_id, fname, lname, prg_name1, prg_intake FROM st_application WHERE sno='$snoApp' AND student_id!=''";
$rsltModule = mysqli_query($con, $qryModule);
$rowModule = mysqli_fetch_assoc($rsltModule);
$snoApp2 = $rowModule['sno'];
$student_id = $rowModule['student_id'];
$fname = $rowModule['fname'];
$lname = $rowModule['lname'];
$fullname = $fname.' '.$lname;
$prg_name1 = $rowModule['prg_name1'];
$prg_intake = $rowModule['prg_intake'];

$qryModule_2 = "SELECT sno, commenc_date, expected_date FROM contract_courses WHERE program_name='$prg_name1' AND intake='$prg_intake'";
$rsltModule_2 = mysqli_query($con, $qryModule_2);
$rowModule_2 = mysqli_fetch_assoc($rsltModule_2);
$commenc_date = $rowModule_2['commenc_date'];
// $expected_date = $rowModule_2['expected_date'];

$output = "<style> 

main { position:relative;width:100%; }
   .page {width:100%;   font-size:13px;  margin-top:0px; padding:0px 0px 0px; page-break-after: always; position:relative;line-height:16px; }
      .page:last-child {page-break-after:never;}
          footer {position: fixed;bottom:30px; width:100%;text-align:left; padding:0px 40px 0px;height:200px; font-size:14px; }
 .header { position: fixed; top: -0px;width:100%;  padding:0px 50px 0px;height:0px; display: block; }
footer p { text-align:center;}
 @page { margin:15px 15px 0px; font-weight:599;width:100%;    font-family: 'Helvetica'  ;color:#333;  }
.float-left { float:left;}
.float-right { float:right;}
.mt-5 { margin-top:50px;}
.text-center { text-align:center;}
p { width:100%; margin:0px; }
h5 { font-size:18px; font-weight:550; margin-top:6px; line-height:22px;}
h2 { font-size:24px; color:#3a7f3e}
h4 { font-size:22px;}
.m-0 { margin:0px;}
.my-0 { margin-top:10px; margin-bottom:10px;}
  .border-bottom { border-bottom:1px solid #333; min-height:50px ;}
  .border-top { border-top:1px solid #333; min-height:50px ;}
  .border-bottom-dotted{ border-bottom:1px dotted #333; min-height:50px ;}
  .sign_table td.border-bottom  {height:30px;}
  .sign_table td  { vertical-align:bottom;height:24px;}
   .sign_table { width:100%}
  .out-border-dotted { border-collapse:collapse;}
   .out-border .table-bordered,
  .out-border { border:5px double #3a7f3e;height:1040px; width:100%;  padding:20px;
box-shadow: 0 0 0 1px #3a7f3e, 0 0 0 2px #fff, 0 0 0 3px #3a7f3e, 0 0 0 4px #fff, 0 0 0 5px #3a7f3e;}
.dashed-border { border:1px dashed #333; padding:15px; height:1005px; }
.line { height:1px; background:#333; width:100%;  margin:20px 0px;}
.borderless td { padding:3px 10px;}
</style>";


$output .= '
<div class="header"></div>

<main class="page" style=" margin-top:-10px;"> 

<div class="out-border mt-05">
<div class="dashed-border">
 <h2 class=" my-0 text-center text-success">GRANVILLE COLLEGE</h2>
 <h4 class=" my-0 text-center">'.$official_unofficail.' STUDENT TRANSCRIPT</h4>
<table width="100%" class="sign_table" style="margin-top:10px;">
<tr> <td class="ps-1" valign="top" width="180"><b>Student:</b> &nbsp; '.$fullname.'</td>
<td width="30">&nbsp;</td><td class="ps-1" valign="top"  width="48%"><b>Program:</b> &nbsp; '.$prg_name1.'</td>
</tr> 
 

<tr> <td class="ps-1" width="48%" valign="top"><b>Student ID:</b> &nbsp; GC'.$student_id.'</td>
<td width="30">&nbsp;</td>
<td class="ps-1" valign="top" ><b>StartDate:</b> &nbsp; '.$commenc_date.'</td>
</tr> 

<tr> <td class="ps-1" valign="top" > <b>Class:</b> &nbsp; '.$class_crs.'</td>
<td width="30">&nbsp;</td>
<td class="ps-1" valign="top" ><b>End Date:</b> &nbsp; '.$expected_date.'</td>
</tr>

<tr>
	<td class="ps-1" valign="top" ><b>Date of Issue:</b> &nbsp; '.$date_issue.'</td>
<td width="10">  </td><td  align="center" width="290">&nbsp;</td>
</tr> 
</table>  
<div class="line"></div>
 <table class="table borderless" width="100%" border="0">
    <tr>
        <th width="80%">COURSE</th>
        <th align="center">GRADE</th>
      </tr>';

if(!empty($_GET['snoApp'])){
	
	if($prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(1)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(2)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(3)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(4)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality(5)' || $prg_name1 == 'Business Administration / Global Supply Chain Management Speciality'){
	$getPName3 = " program2='BA / GSCMS'";	
		
	}elseif($prg_name1 == 'Business Administration / Human Resources Management Speciality(1)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(2)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(3)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(4)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality(5)' || $prg_name1 == 'Business Administration / Human Resources Management Speciality'){
		$getPName3 = " program2='BA / HRM'";
		
	}elseif($prg_name1 == 'Business Administration Diploma(1)' || $prg_name1 == 'Business Administration Diploma(2)' || $prg_name1 == 'Business Administration Diploma(3)' || $prg_name1 == 'Business Administration Diploma(4)' || $prg_name1 == 'Business Administration Diploma(5)' || $prg_name1 == 'Business Administration Diploma'){
		$getPName3 = " program2='Business Administration'";	
		
	}elseif($prg_name1 == 'Diploma in Hospitality Management(1)' || $prg_name1 == 'Diploma in Hospitality Management(2)' || $prg_name1 == 'Diploma in Hospitality Management(3)' || $prg_name1 == 'Diploma in Hospitality Management(4)' || $prg_name1 == 'Diploma in Hospitality Management(5)' || $prg_name1 == 'Diploma in Hospitality Management'){
		$getPName3 = " program2='Hospitality'";
		
	}elseif($prg_name1 == 'Diploma in Hospitality Management with CO-OP(1)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(2)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(3)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(4)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP(5)' || $prg_name1 == 'Diploma in Hospitality Management with CO-OP'){
		$getPName3 = " program2='Hospitality'";	
		
	}elseif($prg_name1 == 'Global Supply Chain Management Diploma(1)' || $prg_name1 == 'Global Supply Chain Management Diploma(2)' || $prg_name1 == 'Global Supply Chain Management Diploma(3)' || $prg_name1 == 'Global Supply Chain Management Diploma(4)' || $prg_name1 == 'Global Supply Chain Management Diploma(5)' || $prg_name1 == 'Global Supply Chain Management Diploma'){
		$getPName3 = " program2='Global Supply Chain'";	
		
	}elseif($prg_name1 == 'Healthcare Office Administration Diploma(1)' || $prg_name1 == 'Healthcare Office Administration Diploma(2)' || $prg_name1 == 'Healthcare Office Administration Diploma(3)' || $prg_name1 == 'Healthcare Office Administration Diploma(4)' || $prg_name1 == 'Healthcare Office Administration Diploma(5)' || $prg_name1 == 'Healthcare Office Administration Diploma'){
		$getPName3 = " program2='HCOA'";
		
	}elseif($prg_name1 == 'Human Resources Management Speciality(1)' || $prg_name1 == 'Human Resources Management Speciality(2)' || $prg_name1 == 'Human Resources Management Speciality(3)' || $prg_name1 == 'Human Resources Management Speciality(4)' || $prg_name1 == 'Human Resources Management Speciality(5)' || $prg_name1 == 'Human Resources Management Speciality'){
		$getPName3 = " program2='Human Resources'";
		
	}else{
		$getPName3 = " program2='$prg_name1'";	
	}
	
	$qryModule_3 = "SELECT sno, module_name FROM m_program_lists WHERE module_name!='' AND $getPName3 order by sno desc";
	$rsltModule_3 = mysqli_query($con, $qryModule_3);
	if(mysqli_num_rows($rsltModule_3)){	
	$srnoCnt=1;	
	$prcntgInputCnt = 0;
	while($rowModule_3 = mysqli_fetch_assoc($rsltModule_3)){
		$getModuleName = $rowModule_3['module_name'];
		$getCnt = $srnoCnt++;
		$getCnt1 = $getCnt;	
		$getModuleData = mysqli_query($con,"SELECT * FROM student_transcript WHERE app_id='$snoApp'");
		$getModuleDataRow = mysqli_fetch_assoc($getModuleData);
		$dynamicMod = $module.$getCnt1 = $getModuleDataRow['module'.$getCnt1];
		
		if(($dynamicMod != 'IP' && $dynamicMod != 'IC' && $dynamicMod != 'Complete')){
			$prcntgSymbol = '%';
			$prcntgInputCnt += number_format((float)$dynamicMod, 2, '.', '');
		}else{
			$prcntgSymbol = '';
		}
	
		$output .= '<tr>
			<td>'.$getModuleName.'</td>
			<td align="center">'.$dynamicMod.''.$prcntgSymbol.'</td>
		  </tr>';
		}
		$getRoundDecimal = $prcntgInputCnt/$getCnt;
		
		$output .= '<tr>
        <td align="right"><b>Program Average</b></td>
        <td style="border-top:1px solid #333" align="center">'.number_format((float)$getRoundDecimal, 2, '.', '').'%</td>
      </tr>';
	}
}else{
	
	$a = count($_POST['module']);
	$prcntgInputCnt = 0;
	for($i=0;$i<$a;$i++){
		$getModule = $_POST['module'][$i];
		$getModuleName = $_POST['module_name_hidden'][$i];
		if($getModule == '%'){
			$prcntgInput = $_POST['prcntg_input'][$i];
			$prcntgInputD[] = $_POST['prcntg_input'][$i];
		}else{
			$prcntgInput = $getModule;
			$prcntgInputD[] = $getModule;
		}
		if(($prcntgInput != 'IP' && $prcntgInput != 'IC' && $prcntgInput != 'Complete')){
			$prcntgSymbol = '%';
			$prcntgInputCnt += number_format((float)$prcntgInput, 2, '.', '');
		}else{
			$prcntgSymbol = '';
		}

		$output .= '<tr>
			<td>'.$getModuleName.'</td>
			<td align="center">'.$prcntgInput.''.$prcntgSymbol.'</td>
		  </tr>';
		}
		$getRoundDecimal = $prcntgInputCnt/$a;

	  
    $output .= '<tr>
        <td align="right"><b>Program Average</b></td>
        <td style="border-top:1px solid #333" align="center">'.number_format((float)$getRoundDecimal, 2, '.', '').'%</td>
      </tr>';
}
      
    $output .= '</table>
<div class="line"></div>
<footer class="footer1">
<table width="100%" class="sign_table" style="margin:0px;">
<tr> 
	<td class="border-bottom ps-1" width="49%" >&nbsp; <b>'.$ipstatus.'</b></td>
	<td width="30">&nbsp;</td>
	<td class=" ps-1" vertical-align="top" align="right" rowspan="4">
	<img src="../../granville_pdf/images/Granville-New-logo.jpg" width="110" class="img-fluid ml-sm-5">
	</td>
</tr>';
if($official_unofficail == 'OFFICIAL'){
$output .= '<tr> 
	<td class="ps-1" valign="top" width="49%" style="height:10px;">&nbsp;Completion Status
	<br><br></td>
	<td width="30">&nbsp;</td>
</tr>
<tr> 
	<td class="border-bottom ps-1" width="49%" ><br>&nbsp;
	<img src="img/JustynaMatracki.png" width="150"></td>
	<td width="30">&nbsp;</td>
</tr>';
}
$output .= '<tr> 
	<td class="ps-1" valign="top" width="49%" style="height:10px;">&nbsp;Senior Education Administrator<br><br></td>
	<td width="30">&nbsp;</td>
</tr>
</table>
</footer>
</div>
</main>
';

$document->loadHtml($output);       
$document->setPaper('A4', 'potrait');
$document->render();

if(!empty($_GET['snoApp'])){
	
}else{

	$qryModule_4 = "SELECT * FROM `student_transcript` WHERE app_id='$snoApp'";
	$getRslt = mysqli_query($con, $qryModule_4);
	if(mysqli_num_rows($getRslt)){
		$qryUpdate = "UPDATE `student_transcript` SET official_unofficail='$official_unofficail', class='$class_crs', date_of_issue='$date_issue', module1='$prcntgInputD[0]', module2='$prcntgInputD[1]', module3='$prcntgInputD[2]', module4='$prcntgInputD[3]', module5='$prcntgInputD[4]', module6='$prcntgInputD[5]', module7='$prcntgInputD[6]', module8='$prcntgInputD[7]', module9='$prcntgInputD[8]', module10='$prcntgInputD[9]', module11='$prcntgInputD[10]', module12='$prcntgInputD[11]', module13='$prcntgInputD[12]', module14='$prcntgInputD[13]', module15='$prcntgInputD[14]', module16='$prcntgInputD[15]', module17='$prcntgInputD[16]', module18='$prcntgInputD[17]', module19='$prcntgInputD[18]', module20='$prcntgInputD[19]', status_ip='$ipstatus', end_date='$expected_date' WHERE app_id='$snoApp'";
		mysqli_query($con, $qryUpdate);
	}else{
		$qryInsert = "INSERT INTO `student_transcript` (`app_id`, `official_unofficail`, `class`, `date_of_issue`, `module1`, `module2`, `module3`, `module4`, `module5`, `module6`, `module7`, `module8`, `module9`, `module10`, `module11`, `module12`, `module13`, `module14`, `module15`, `module16`, `module17`, `module18`, `module19`, `module20`, `status_ip`, `end_date`) VALUES ('$snoApp', '$official_unofficail', '$class_crs', '$date_issue', '$prcntgInputD[0]', '$prcntgInputD[1]', '$prcntgInputD[2]', '$prcntgInputD[3]', '$prcntgInputD[4]', '$prcntgInputD[5]', '$prcntgInputD[6]', '$prcntgInputD[7]', '$prcntgInputD[8]', '$prcntgInputD[9]', '$prcntgInputD[10]', '$prcntgInputD[11]', '$prcntgInputD[12]', '$prcntgInputD[13]', '$prcntgInputD[14]', '$prcntgInputD[15]', '$prcntgInputD[16]', '$prcntgInputD[17]', '$prcntgInputD[18]', '$prcntgInputD[19]', '$ipstatus', '$expected_date')";
		mysqli_query($con, $qryInsert);
	}
}

$firstname = str_replace(' ', '', $fname);
$olname = 'TRANSCRIPT_'.$firstname.'_GC'.$student_id;

$document->stream("$olname", array("Attachment"=>1));
//1  = Download
//0 = Preview
?>