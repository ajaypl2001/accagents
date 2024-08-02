<?php
// include("../../db.php");
date_default_timezone_set("Asia/Kolkata");
require_once '../../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
//initialize dompdf class
$document = new Dompdf();
// $document->set_option('/defaultFont', '/Courier');


$output = "<style>

footer p { text-align:center;}
main { position:relative;width:100%;background:transparents !important;}
   .page {width:100%;   font-size:16px;  margin-top:130px; padding:0px 100px 5px; page-break-after: never; position:relative;line-height:24px;background:transparents !important;
   .page:last-child {page-break-after:never;}
 @page { margin:0px; padding:90px 10px 10px;font-weight:599;width:100%;  color:#333;     font-family: poppins,helvetica neue,Arial,sans-serif;font-size:14px; height:100%; letter-spacing:-0.6; }
.float-left { float:left;}
.float-right { float:right;}
.mt-5 { margin-top:50px;}
.mt-3 { margin-top:30px;}
.text-center { text-align:center;}
p { width:100%; margin:0px 0px 5px; }
h4 { font-size:19px; text-align:center}
.m-0 { margin:0px;}
  .lower-roman {list-style-type: lower-roman}
  .list-alfa { list-style-type: lower-alpha;}
  ol li { margin-top:5px;}
  .header { position: fixed; top:50px;width:100%;  padding:0px 100px 25px;height:80px; z-index:999; display: block; }
 footer {position: fixed;bottom:80px; width:100%; z-index:999; padding:0px 100px 0px;height:25px; }

</style>";

$output .= '    <!-- Wrap the content of your PDF inside a main tag --> 

<div class="header">   
  <p><span class="float-left"> <img src="../../images/logo.jpg" width="70"></span> <span class="float-right mt-3"><b>DLI NO -</b> O150186247152</span>  
</p>
  </div><footer>
<p><strong> Address:</strong> #201 – 155 Skinner Street, Nanaimo, Nanaimo, BC V9R 5E8<br>
w: <a>www.avaloncommunitycollege.ca </a>| p: 1-250-824-1545 | e: <a> info@avaloncommunitycollege.ca</a> </p>
</footer>

          <main class="page">   
          <h4>Fees Receipt</h4>
          <p><br>
          <b>June 24<sup>th</sup> 2022</b><br><br><br>
<b>#Student ID – 2206001  </b><br>
Receipt No. – {XXXXX}<br><br><br>
Dear <b>[Student Name],</b><br><br>
<b>Avalon Community College, British Columbia, </b> hereby confirms that we have 
received the tuition fee amount of - $13500.00 CAD {amount}<br><br><br>
<b>Mode of Transfer </b> - Telegraphic Transfer</p><br><br>

<p> Thank you!
   <br>Yours Faithfully<br><br><br><br>
   <img src="images/Sig_Cham1.jpg" style="height:60px;">   <br><b>
Chamara Perera<br>
Regional Director</b>
<p>
</main> </div>';
$document->loadHtml($output);
//set page size and orientation
$document->setPaper('A4', 'potrait');
//Render the HTML as PDF
$document->render();
$document->stream("Fees Receipt", array("Attachment"=>0));
//1  = Download
//0 = Preview
?>