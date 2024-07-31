<?phpinclude("../db.php");date_default_timezone_set("Asia/Kolkata");$datetime_at = date('Y-m-d H:i:s');require_once '../dompdf/autoload.inc.php';use Dompdf\Dompdf;$document = new Dompdf();$document->set_option('defaultFont', 'Courier');$snoid = $_POST['snoid'];$query1 = "SELECT * FROM st_application WHERE sno='$snoid'";$result1 = mysqli_query($con, $query1);$rowstr1 = mysqli_fetch_assoc($result1);$student_id = $rowstr1['student_id'];$gtitle = $rowstr1['gtitle'];$fname = $rowstr1['fname'];$lname = $rowstr1['lname'];$refid = $rowstr1['refid'];$email_address = $rowstr1['email_address'];$mobile = $rowstr1['mobile'];$address1 = $rowstr1['address1'];$address22 = $rowstr1['address2'];if($address22 !== ''){	$address2 = $address1.', '.$address22;}else{	$address2 = $address1;}$city = $rowstr1['city'];$state = $rowstr1['state'];$country = $rowstr1['country'];$pincode = $rowstr1['pincode'];$output = "<style>     @page { margin: 50px 45px 10px; font-family:Helvetica; font-weight:599; color:#333; font-size:14px; }       .header { position: fixed; top: -50px;  display: block;width:100%;}          h2{  width:705px;font-size:22px;margin-top:-50px; line-height:-60px;  font-weight:599;}       h3{ text-align:center; width:100%; font-size:20px; margin-bottom:60px; margin-top:30px;font-weight:599;}     .page h4{ text-align:left; width:100%; font-size:18px; margin-top:20px; margin-bottom:50px; font-weight:600;}     .page h5{ text-align:left; width:100%; font-size:16px; margin-top:50px; margin-bottom:0px;font-weight:600;}       .footer { position: fixed; bottom:200px; left: 0px; right: 0px;}               .page {/* page-break-after: always;*/ margin-top:0px;width:668px; line-height:15px; }          .check { margin-right:5px;}       	   .form_table {margin:5px 0px; width:100%;   border-collapse: collapse;}   .form_table td { border:1px solid #999;  padding:6px 10px; vertical-align:middle; margin-top:0px;  }       	.pt-3{ padding-top:30px;}       	.border-bottom { border-bottom:1px solid #333; min-height:50px ;}       	.float-left {float:left;}       	.float-right {float:right;}       	.form_table td table, .border-0 { border:0px !important);}   table {border-collapse: collapse;}   </style>";      $output .= '   <div class="header">              <img src="../images/logo_aol.png" width="170">                    </div>              <!-- Wrap the content of your PDF inside a main tag -->           <main class="page" style="padding-bottom:0px;">              <h2><span class="text-right float-right"><u><b>International Student Refund Request Form</b></u></span>              </h2>                  <br>   <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td colspan="4"><b>REFUND INFORMATION:</b></td>   </tr>      <tr>   <td width="95">Student First Name</td>   <td width="122">&nbsp;'.$fname.'</td>   <td width="95">Student Last Name</td>   <td width="122">&nbsp;'.$lname.'</td>   </tr>   <!---tr><td>Student ID/ V NO</td><td colspan="3">'.$student_id.'</td></tr--->   <tr><td rowspan="2">Mailing Address</td><td colspan="3">&nbsp;'.$address2.'</td></tr>   <tr><td colspan="3">&nbsp;'.$city.', '.$state.', '.$country.' - '.$pincode.'</td></tr>   <tr><td>Phone</td>      <td width="138">&nbsp;'.$mobile.'</td>   <td width="90">	Email</td>   <td width="138">&nbsp;'.$email_address.'</td>   </tr>   </table>   <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td style="border-right:0px;"></td><td style="border-left:0px;" >   <b style="margin-left:-35px;">REASON FOR REFUND: (Please select one reason and provide supporting documentation)</b></td>   </tr>      <tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="488">Visa Denial (Copy of your visa denial letter <b><u>must</u></b> accompany this form)</td>      </tr><tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="488">Attending another institution (Copy of Letter of Acceptance from institution <b><u>must</u></b> accompany this form)</td>      </tr><tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="488">Cancellation of Application (Written letter of cancellation <b><u>must</u></b> accompany this form)</td>      </tr>   </table>   <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td colspan="6"><b>DEPOSIT DETAILS:   (Please complete payment method and amount of your original deposit)</b></td>   </tr>      <tr>   <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="105">Credit Card</td>   <td width="105">   $ </td>   <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="105">Debit Card</td>   <td width="105">   $ </td>      </tr>   <tr>   <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="105">Bank Transfer</td>   <td width="105">   $ </td>   <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="105">Cash or Cheque</td>   <td width="105">   $ </td>      </tr>   </table>   <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td colspan="4"><b>REFUND RECIPIENT DETAILS:</b></td>   </tr>      <tr>   <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="180"><b>Refund payable to student</b></td>      <td><img src="../images/uncheck.jpg" width="10"></td>   <td width="272"><b>Refund payable to third party </b>(Complete Consent below)</td>   </tr>   <tr bgcolor="#ccc">   <td colspan="4"><b>CONSENT:<br>   To be completed if refund is payable to third party   </b></td>   </tr>   <tr>   <td colspan="4">      <p>I <span class="border-bottom" style="width:200px; display:inline-block">&nbsp;</span>hereby give permission to Academy of Learning College to refund all</p>   <p> monies due to me in the name of    <span class="border-bottom" style="width:200px; display:inline-block">&nbsp;</span></p>   <p style=" margin-bottom:0px;">Student Signature:  <span class="border-bottom" style="width:260px; display:inline-block">&nbsp;</span> &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; Date:    <span class="border-bottom" style="width:200px; display:inline-block">&nbsp;</span></p>   </table>      <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td style="border-right:0px;"></td><td style="border-left:0px;" ><b style="margin-left:-35px;">REFUND PAYMENT METHOD:   All refunds will be returned through the original payment method   </b></td>   </tr>      <tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="490"><b>Credit Card </b>(Please select one)    &nbsp; &nbsp; <img src="../images/uncheck.jpg" width="10"> Visa &nbsp; &nbsp; <img src="../images/uncheck.jpg" width="10"> MasterCard &nbsp; &nbsp; <img src="../images/uncheck.jpg" width="10"> American Express<br>   <br>   <table >   <tr>   <td style="border:0px; padding-left:0px;">Credit Card Number</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   <td>&nbsp;</td>   </tr>   </table>      <p style=" margin-bottom:0px;">Cardholder Name:  <span class="border-bottom" style="width:210px; display:inline-block">&nbsp;</span> &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; Expiry Date:          <span class="border-bottom" style="width:150px; display:inline-block">&nbsp;</span></p>   </td>      </tr><tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="490"><b>Bank Transfer</b>(Bank Transfer Form <b><u>must</u></b> accompany this form, $45 bank fee deducted from refund)</td>      </tr><tr>   <td width="10"><img src="../images/uncheck.jpg" width="10"></td>   <td width="490"><b>Cheque</b> (All Debit Card, Cash or Cheque payments will be refunded by Cheque)</td>      </tr>   </table>   <p style="width: 650px;">Please select delivery method:	&nbsp; &nbsp;  <img src="../images/uncheck.jpg" width="10">  Regular mail (no charge)	&nbsp; &nbsp;  <img src="../images/uncheck.jpg" width="10"> Courier- $100 (deducted from&nbsp;refund)</p>   <p><b>By signing below, I understand:</b></p>   <ul style="padding-left:20px;"><li> It is my responsibility to submit this form and supporting documents to refunds@aoltoronto.com</li><li> Upon submission of this form, it can take up to thirty (30) business days for processing</li><li> Any missing or incorrect information will result in delays in my refund processing   </li>   </ul><br>   <p style="height:25px; margin-bottom:0px;"><b>STUDENT SIGNATURE:     <span class="border-bottom" style="width:230px; display:inline-block">&nbsp;</span>    &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; DATE:      <span class="border-bottom" style="width:160px; display:inline-block">&nbsp;</span></b></p>    <br><br>              </main><!-- Wrap the content of your PDF inside a main tag -->           <main class="page" style="padding-bottom:0px;">               <h2 style="margin-top:20px;"><span class="text-right float-right"><u><b>Bank Transfer Form</b></u></span>              </h2>                  <br>                 <p style="margin:0px;"><b>To be completed only if refund is to be issued through bank transfer</b></p>   <table class="form_table" col-padding="0">      <tr bgcolor="#ccc"><td colspan="5"><b>BANK TRANSFER DETAILS:</b></td>   </tr>      <tr>   <td width="105">Student    First Name</td>   <td colspan="4">&nbsp;</td>   </tr>   <tr><td>Account Holder Name</td>   <td  width="68">First Name</td>   <td width="105">&nbsp;</td>   <td width="68">Last Name</td>   <td width="105">&nbsp;</td>   </tr>   <tr>   <td width="105">Bank Account Number</td>   <td colspan="4">&nbsp;</td>   </tr>   <tr><td rowspan="2">Account Holder Address </td>   <td  width="68">Street Name and Number</td>   <td width="105">&nbsp;</td>   <td width="68">City& Province</td>   <td width="105">&nbsp;</td>   </tr>   <tr>   <td  width="68">Postal Code or Zip Code</td>   <td width="105">&nbsp;</td>   <td width="68">Country</td>   <td width="105">&nbsp;</td>   </tr>   <tr>   <td width="105">Account Holder Telephone</td>   <td colspan="4">&nbsp;</td>   </tr>   <tr>   <td width="105">Bank Name</td>   <td colspan="4">&nbsp;</td>   </tr>   <tr><td rowspan="2">Branch Address </td>   <td  width="68">Street Name and Number</td>   <td width="105">&nbsp;</td>   <td width="68">City& Province</td>   <td width="105">&nbsp;</td>   </tr>   <tr>   <td  width="68">Postal Code or Zip Code</td>   <td width="105">&nbsp;</td>   <td width="68">Country</td>   <td width="105">&nbsp;</td>   </tr>   <tr>   <td width="105">Branch Telephone</td>   <td colspan="4">&nbsp;</td>   </tr><tr>   <td width="105">IBAN NO (if applicable)</td>   <td colspan="4">&nbsp;</td>   </tr><tr>   <td width="105">Swift code</td>   <td colspan="4">&nbsp;</td>   </tr>         </table><br>        <p style="font-size:15px;">  By signing below, I authorize Academy of Learning College to release my refund via banktransfer.   </p><br><br>         <p style="height:50px;"><b>STUDENT SIGNATURE:           <span class="border-bottom" style="width:230px; display:inline-block">&nbsp;</span> &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; DATE:             <span class="border-bottom" style="width:160px; display:inline-block">&nbsp;</span></b></p>                     <div class="footer">                            <table class="form_table">              <tr>              <td bgcolor="#ccc"><p><b>FOR OFFICE USE ONLY:</b></p>              <p>Verified by (Admissions  <span class="border-bottom" style="width:250px; display:inline-block">&nbsp;</span> &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; Date:    <span class="border-bottom" style="width:160px; display:inline-block">&nbsp;</span></p>                <p>Date of Issuance of Refund:    <span class="border-bottom" style="width:220px; display:inline-block">&nbsp;</span> &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; Amount:     <span class="border-bottom" style="width:160px; display:inline-block">&nbsp;</span></p>                 </td>              </table>           </div>           </main>   ';      $document->loadHtml($output);$document->setPaper('A4', 'potrait');$document->render();$generate_refund_form = $rowstr1['generate_refund_form'];if($generate_refund_form !==''){	unlink("../uploads/$generate_refund_form");}   $firstname = str_replace(' ', '', $fname);$olname = 'Refund_Form_'.$firstname.'_'.$refid;$filepath = "../uploads/$olname.pdf";$filepath2 = "$olname.pdf";file_put_contents($filepath, $document->output());   mysqli_query($con, "update `st_application` set `generate_refund_form`='$filepath2', `generate_refund_form_datetime`='$datetime_at' where `sno`='$snoid'");      $document->stream("$olname", array("Attachment"=>0));//1  = Download//0 = Preview   ?>