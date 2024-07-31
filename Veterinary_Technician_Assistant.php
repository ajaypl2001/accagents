<?php
$body_msg3 = '<!DOCTYPE html PUBLIC "">
<html xmlns="">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Aol Toronto</title>
             <style type="text/css">

        body {margin: 0; padding: 0; min-width: 100%!important; }
        .content {width: 100%; padding:0px; max-width: 600px; font-family:arial;  margin:10px auto;     border-spacing: 0px;}
td {    border-spacing: 0 5px;}
.top_heading { background: #e66a20; padding: 10px 20px 15px; color:#fff; text-align:center; font-size: 28px; margin: -3px 0px 0px; border-radius: 0px 0px 50px 50px; }
        .content h3 { padding:20px 15px; margin:20px; font-size: 28px; text-align:center; }
        .content table { width:100%; }
              .content table td { font-size: 15px;vertical-align: top }
       
      .contact_text {
	padding: 10px;
}
       .contact_text1 img {
	float: left;
	margin-right: 10px;
	margin-top: 2px;
}
        .contact_text1 a { line-height: 20px; color:#333; font-weight:700; font-size:14px;text-decoration: none; }
.footer_img { max-width:600px; width:100%;} 

.phone-cnt{
padding-left: 23px;
}
p {
	font-size: 15px;
	line-height: 27px;
}
.earning-title{
background: #e66a20 !important;border-radius: 13px;color: #fff;
						 text-align: center;padding: 10px 2px;line-height: 26px;margin: 0;
						 font-size:24px;}
ul li {
	list-style: decimal;
	margin-left: 10px;
}

@media (max-width:480px){
	.top_heading {  padding: 8px 20px 12px; font-size: 20px !important;}
	.phone-cnt{
		padding-left: 0px;
	}  
	ul li {font-size: 14px;}
	p {
	font-size: 13px !important;
	line-height: 22px !important;
	}
	.contact_text1 a {
	font-size: 10px !important;
}
.contact_text1 img {
	width: 18px;margin-right: 5px
}
	.earning-title{
		font-size:18px;}
}
.content table td {
	font-size: 13px;
}
        </style>
    </head>
    <body yahoo bgcolor="#d3d3d3">
       
 <table align="center" class="content"  cellpadding="0" cellspacing="0"  border="0">
  <tr>
  <td>
   <table align="center" width="100%" style="margin:0px; background: #fff;" cellpadding="0" cellspacing="0" border="0">
                       <tr>
                            <td  colspan="2" align="center" bgcolor="#fff" style="padding: 0px 10px; "><span style="background: linear-gradient(to bottom, rgba(230,106,32,1) 80%, rgba(230,106,32,1) 80%, rgb(230,106,32, 1) 60%, rgba(255,255,255,1) 80%, rgba(255,255,255,1) 100%); width: 100%; float:left">
                               <img src="https://aoltorontoagents.ca/mailer_images/ECA_top.jpg"  width="100%" style="margin-bottom: 0px !important;">
                               <h2 class="top_heading" style="margin-top: 0px !important;">Join Our <br>Early Childcare Assistant Program</h2></span>
                            </td>
							
                        </tr>
                       
                   
					<tr>
						<td  colspan="2" align="center">
						<p style="background: #4a9e3e;margin: 30px 20px;padding: 6px 13px;border-radius: 25px;font-size: 20px;color: #fff;">Call us now for more information</p>
						</td>
					</tr>
					<tr>
						<td  class="phone-cnt" width="50%">
						<p class="contact_text1"><img src="https://aoltorontoagents.ca/mailer_images/phone1.png" width="26"><a  href="tel:4169698845"> (416) 969 8845</a></p>
						
							<p class="contact_text1"><img src="https://aoltorontoagents.ca/mailer_images/mail1.png" width="26"><a href="mailto:info@aoltoronto.com">info@aoltoronto.com</a></p> 
							 <p class="contact_text1"><img src="https://aoltorontoagents.ca/mailer_images/globe1.png" width="26"><a href="https://aoltoronto.com/" target="blank">https://aoltoronto.com</a></p>  
							 
						
						</td>
				<td style="padding: 0 15px 0px 0px;" width="50%">
						<img src="https://aoltorontoagents.ca/mailer_images/logo.png"  width="80%" style="margin-top: 7px; float:right">
						</td>
					
					
					
					</tr>
					
					
					
					
					
					
					
<tr><td colspan="2" align="center"><br><b style="font-size: 12px;">Registered as a Private Career College under the Private Career Colleges Act, 2005</b><img src="https://aoltorontoagents.ca/mailer_images/footer.png" class="footer_img" style="margin-top: 10px;"></td></tr>
                    </table>
                            </td>
                        </tr>
                    </table>
              
    </body>
</html>
';
$subject3 = 'Email Template1 Pushpa';
$headers3 = "MIME-Version: 1.0" . "\r\n";
$headers3 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers3 .= 'From: Testing<no-reply@aoltorontoagents.ca>' . "\r\n";
  $headers3 .= 'Cc: preetysingal@outlook.com' . "\r\n";
 $headers3 .= 'Cc: preeti@essglobal.com' . "\r\n";
$headers3 .= 'Cc: pushpa@essglobal.com' . "\r\n";
 $headers3 .= 'Cc: preety.singal@yahoo.in' . "\r\n";

$to3 = 'sanjiv28890@gmail.com';	
mail ($to3,$subject3,$body_msg3,$headers3);
?>