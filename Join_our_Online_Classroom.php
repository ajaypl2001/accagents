<?php
$body_msg3 = '<!DOCTYPE html PUBLIC "">
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Join our Online Classroom</title>
        <style type="text/css">

@media only screen and (max-device-width: 768px) {
    .content { max-width: 920px !important;
        width: 100% !important;  margin:10px 0px; font-size: 14px;
    }.footer_img { max-width:920px !important;}
}
@media only screen and (max-device-width: 480px){
    .content table td{ line-height: 15px !important;
     font-size: 10px !important;
    }.content h3 {  font-size: 18px !important;padding:20px 10px !important;}
    .contact_text a { font-size:9px !important; line-height:16px !important;}
    .contact_text img { width:16px !important; margin-right:2px !important;}
    .contact_text {padding: 3px !important;}
}
        body {margin: 0; padding: 0; min-width: 100%!important; }
        .content {width: 100%; padding:0px; max-width: 600px; font-family:arial; box-shadow: 0px 0px 10px #999; margin:10px auto;}.content h3 { padding:20px; margin:20px; border:10px solid #f8b651; font-size: 32px; text-align:center; }
        .content table { width:100%; }
              .content table td { font-size: 15px;vertical-align: top }
        .logo { width:100%; margin:-40px  0px 0px !important; }
        .contact_text {padding: 10px;}
        .contact_text img{float:left; margin-right:10px;}
        .contact_text a { line-height: 40px; color:#002060; font-weight:700; font-size:16px;text-decoration: none; }
.footer_img { max-width:600px; width:100%;} 
.img2 {width:100%; }

        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
       
 <table align="center" class="content"  border="0">
  <tr>
  <td style="padding: 1px;">
   <table align="center" width="100%" style="margin:0px; background: #fff;" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td colspan="2"  style="background: #ed7d31">
                               <h3>Join our Online Classroom</h3>
                            </td>
                        </tr>
                        <tr style="background: #ed7d31"><td style=" width:40%;background: #fff; height: 40px;">&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td style="background: #f8b651"><img src="https://aoltorontoagents.ca/mailer_images/logo.png" class="logo" >
     <img src="https://aoltorontoagents.ca/mailer_images/online_class.jpg" class="img2" style="margin:-3px auto 80px;" >

     <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/mail.png" width="40px;"><a href="mailto:info@aoltoronto.com">info@aoltoronto.com</a></p>  <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/globe.png" width="40px;"><a href="www.aoltoronto.com" target="blank">www.aoltoronto.com</a></p>  <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/phone.png" width="40px;"><a style="font-size: 17px;" href="tel:(416) 969 8845">(416) 969 8845</a></p></td><td style="padding: 10px; background:#fff; line-height:26px;">The COVID-19 has impacted the way we live, it has brought about unprecedented challenges to our daily lives. <br><br>
In order to provide our continuous support and uninterrupted service to ourexisting students, <b>Academy of Learning Bay & Queen Campus</b> has transformed all study programs to a <b>fully online platform.</b><br><br>
Using state-of-the-art <b>learning portals</b> and <b>live interactive online lecture sessions,</b> for our in-classroom programs, we are fully geared to facilitate the same in-class experience to support the educational needs of every student while ensuring their safety and well-being.<br><br>
Are you a <b>prospective student </b>considering your options during this time? Enrollments are now open, call us now and we will guide you onyour journey to success. <br><br>
Our experienced Academic Advisors will assess your needs and provide you with the best solution and plan where you can <b>enhance your knowledge</b> and <b>improveyour current skillset </b>so that you are ready to join and <b>challenge the workforce. </b>
 <br><p style="text-align: center ;width:100%"><b >
Your Journey to Success Begins Today…...</b></p>

</td></tr>
<tr><td colspan="2" align="center"><br><b style="font-size: 13px;">Registered as a Private Career College under the Private Career Colleges Act, 2005</b><img src="https://aoltorontoagents.ca/mailer_images/header-top.png" class="footer_img"></td></tr>
                    </table>
                            </td>
                        </tr>
                    </table>
              
    </body>
</html>';

$subject3 = 'Email Template3 Pushpa';
$headers3 = "MIME-Version: 1.0" . "\r\n";
$headers3 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers3 .= 'From: Testing<no-reply@aoltorontoagents.ca>' . "\r\n";
$headers3 .= 'Cc: preety@essglobal.com' . "\r\n";
$headers3 .= 'Cc: preety.singal@yahoo.in' . "\r\n";
$headers3 .= 'Cc: pushpa@essglobal.com' . "\r\n";

$to3 = 'sanjiv28890@gmail.com';	
mail ($to3,$subject3,$body_msg3,$headers3);
?>