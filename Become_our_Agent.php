<?php
$body_msg3 = '<!DOCTYPE html PUBLIC "">
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Join the “A” team, Become our Agent</title>
        <style type="text/css">

@media only screen and (max-device-width: 768px) {
    .content { max-width: 920px !important;
        width: 100% !important;  margin:10px 0px; font-size: 14px;
    }.footer_img { max-width:920px !important;}
}
@media only screen and (max-device-width: 480px){
   content table td{ line-height: 15px !important;
     font-size: 10px !important;
    }.content h3 {  font-size: 18px !important;padding:20px 10px !important;}
    .contact_text a { font-size:9px !important; line-height:16px !important;}
    .contact_text img { width:16px !important; margin-right:2px !important;}
    .contact_text {padding: 3px !important;}

}
        body {margin: 0; padding: 0; min-width: 100%!important; }
        .content {width: 100%; padding:0px; max-width: 600px; font-family:arial; box-shadow: 0px 0px 10px #999; margin:10px auto;}.content h3 { padding:20px 15px; margin:20px; border:10px solid #92c272; font-size: 28px; text-align:center; }
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
                            <td colspan="2"  style="background: #70ad47">
                               <h3>Join the “A” team, Become our Agent</h3>
                            </td>
                        </tr>
                        <tr style="background: #70ad47"><td style=" width:40%;background: #fff; height: 40px;">&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td style="background: #92c272"><img src="https://aoltorontoagents.ca/mailer_images/logo.png" class="logo" >
     <img src="https://aoltorontoagents.ca/mailer_images/hand-shake.jpg" class="img2" style="margin:0px auto 100px;" >

     <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/mail.png" width="40px;"><a href="mailto:info@aoltoronto.com">info@aoltoronto.com</a></p>  <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/globe.png" width="40px;"><a href="www.aoltoronto.com" target="blank">www.aoltoronto.com</a></p>  <p class="contact_text"><img src="https://aoltorontoagents.ca/mailer_images/phone.png" width="40px;"><a style="font-size: 17px;" href="tel:(416) 969 8845">(416) 969 8845</a></p></td><td style="padding: 10px; background:#fff; line-height:26px;"><b>Our Mission -</b> To improve the lives of under-served students and the communities in which they live.<br><br>
Academy of Learning Career College since its inception has been in the forefront in the post-secondary education sector by creating <b>skilled professionals</b> who are <b>industry ready.</b> All our current academic programs and courses have been developed in-line with the respective sector standards and requirements.<br><br>
Our uniqueness and success comes from our exclusive <b>Integrated Learning System (ILS).</b> This mode of learningoffers an all-encompassing experience using multi-sensory learning styles and preferences through student workbooks, media presentations and hands-on exercises whilst being supported continuously by a facilitator.
We are expanding our horizons, and are looking for enthusiastic individuals to <b>join our network of agents.</b> As an agent, you will represent us and recruit students, and our Admissions Advisors will work with you directly to enroll them.<br><br>
Talk to us now to discuss your benefits and we will guide you to <b>become an authorized agent</b> for our campuses in Toronto (Bay & Queen), Hamilton and Brampton East.


</td></tr>
<tr><td colspan="2" align="center"><br><b style="font-size: 13px;">Registered as a Private Career College under the Private Career Colleges Act, 2005</b><img src="https://aoltorontoagents.ca/mailer_images/header-top.png" class="footer_img"></td></tr>
                    </table>
                            </td>
                        </tr>
                    </table>
              
    </body>
</html>';

$subject3 = 'Email Template2 Pushpa';
$headers3 = "MIME-Version: 1.0" . "\r\n";
$headers3 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers3 .= 'From: Testing<no-reply@aoltorontoagents.ca>' . "\r\n";
$headers3 .= 'Cc: preety@essglobal.com' . "\r\n";
$headers3 .= 'Cc: preety.singal@yahoo.in' . "\r\n";
$headers3 .= 'Cc: pushpa@essglobal.com' . "\r\n";

$to3 = 'sanjiv28890@gmail.com';	
mail ($to3,$subject3,$body_msg3,$headers3);
?>