<?php
$body_msg3 = '<!DOCTYPE html PUBLIC "">
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Student Referral Program</title>
        <style type="text/css">

        body {margin: 0; padding: 0; min-width: 100%!important; }
        .content {width: 100%; padding:0px; max-width: 600px; font-family:arial; box-shadow: 0px 0px 10px #999; margin:10px auto;}
        .content h3 { padding:20px 15px; margin:20px; border:10px solid #92c272; font-size: 28px; text-align:center; }
        .content table { width:100%; }
        .content table td { font-size: 15px;vertical-align: top }
        .logo { width:100%; margin:-40px  0px 0px !important; }      
        .contact_text img{float:left; margin-right:10px;}
        .contact_text a { line-height: 40px; color:#002060; font-weight:700; font-size:16px;text-decoration: none; }
        .footer_img { max-width:600px; width:100%;} 
        .img2 {width:100%; }
        .img3 {
            max-width: 87%;
            margin: 26px 0;
        }
        .contact_text {
            margin: 13px 0 10px;
        }
 
        </style>
    </head>
    <body yahoo bgcolor="#d3d3d3">
       
       
 <table align="center" class="content"  border="0">
  <tr>
  <td style="padding: 1px;">
   <table align="center" width="100%" style="margin:0px; background: #fff;" cellpadding="0" cellspacing="0" border="0">
                      
                        <tr>
                            <td style="background: #fff" >
                                <p style="text-align:center;font-size: 37px;">Student <br/>Referral Program </p>
                                <img src="https://aoltorontoagents.ca/mailer_images/img1.png" class="img2" >                                
                            </td>
         
                            <td style="padding: 10px; background:#fff; line-height:26px;text-align: justify;">
                            <p style="text-align:center;font-size: 22px;background:#ed7d31;padding:30px 0; border-radius: 20px;">When you share <br/>your success  </p>
                            <p style="text-align:center;font-size: 22px;background:#92d050;padding:30px 0; border-radius: 20px;">We share cash rewards <br/> with you!*</p>
                            
                            
                            </td>
                        </tr>

                    <tr>
                        <td colspan="2" align="center">
                        <p style="font-size:16px;">Are you a current student following a program with us?<br><br>
                        or<br><br>
                        Have you already completed a program successfully with us?<br><br>
                        If so, join our referral program by introducing new students and getting them enrolled in any of our study programs. The more you get enrolled, the more cash rewards you receive.</p>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="2" bgcolor="#000" style="margin:0 10px;" align="center">
                        <p style="font-size:15px;color:#fff;margin: 6px 2px;">For the first three students, you earn $750 each. Any student thereafter, you earn$1000</p>
                        </td>
                    </tr>
                    
                     <tr>
                            <td style="background: #fff">                               
                                <img src="https://aoltorontoagents.ca/mailer_images/img4.png" class="img3">                             
                            </td>
         
                            <td style="padding: 30px 0; background:#fff; line-height:26px;font-size: 18px;padding-right: 6px;">
                                <p>1. Reaching out to your contacts</p>
                                <p>2. Introducing them to an <br/> Admissions Advisor</p>
                                <p>3. Getting them enrolled&  <br/> start earning cash!</p>
                            </td>
                        </tr>
                        
                        <tr>
                        <td colspan="2" bgcolor="#000" style="margin:0 10px;" align="center">
                        <p style="font-size:15px;color:#fff;margin:6px 0">Talk to us now for more information</p>
                        </td>
                    </tr>
                    
                    <tr>
                            <td style="background: #fff" align="center">                                
                                <img src="https://aoltorontoagents.ca/mailer_images/logo.png" class="img3">                             
                            </td>
         
                            <td style=" background:#fff;font-size: 18px;">
                            <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/phone.png" width="40px;"><a style="font-size: 17px;" href="tel:4169698845">(416) 969 8845</a></p>
                                <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/mail.png" width="40px;"><a href="mailto:info@aoltoronto.com">info@aoltoronto.com</a></p> 
                            <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/globe.png" width="40px;"><a href="https://aoltoronto.com/" target="blank">www.aoltoronto.com</a></p> 
                            
                            </td>
                    </tr>


<tr><td colspan="2" align="center"><br><b style="font-size: 13px;">Registered as a Private Career College under the Private Career Colleges Act, 2005</b><img src="https://aoltorontoagents.ca/mailer_images/header-top.png" class="footer_img"></td></tr>
                    </table>
                            </td>
                        </tr>
                    </table>
              
    </body>
</html>';

$subject3 = 'Email Template1 Pushpa';
$headers3 = "MIME-Version: 1.0" . "\r\n";
$headers3 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers3 .= 'From: Testing<no-reply@aoltorontoagents.ca>' . "\r\n";
// $headers3 .= 'Cc: pushpa@leadmagnet.co.in' . "\r\n";
// $headers3 .= 'Cc: preety.singal@yahoo.in' . "\r\n";
$headers3 .= 'Cc: pushpa@essglobal.com' . "\r\n";

$to3 = 'pushpa@leadmagnet.co.in';	
mail ($to3,$subject3,$body_msg3,$headers3);
?>