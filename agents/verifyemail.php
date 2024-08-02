<?php
ob_start();  
if($_SESSION){
$sessionid_veri = $_SESSION['sno'];
$result_veri = mysqli_query($con,"SELECT * FROM allusers WHERE sno = '$sessionid_veri'");
 while ($row_veri = mysqli_fetch_assoc($result_veri)) {
	 $loggedid_veri = mysqli_real_escape_string($con, $row_veri['sno']);
	 $email_veri = mysqli_real_escape_string($con, $row_veri['email']);	
?>

<?php 
	if(isset($_POST['submit_verify'])){
       $elemail = $_POST['email'];
	   $response_v = mysqli_query($con,"SELECT email FROM allusers WHERE email = '$elemail'");
	   if(mysqli_num_rows($response_v)){
		   echo "<script>alert('Email already Exists.'); window.location='../dashboard'</script>";
	   }else{
       $uid = $_POST['user_id'];	   
       $update_email = mysqli_query($con, "update `allusers` set  `email`='$elemail' where `sno`='$uid'");
       mysqli_query($con, "update `st_application` set  `email_address`='$elemail' where `user_id`='$uid'");
       if($update_email) {
          header('Location: ../dashboard');
        }
	  }
    }
	
if(isset($_POST['email_verify'])){
    $genrate_verify_link_id = $_POST['link_id'];
    $genrate_verify_link_email = $_POST['email_id'];
    $gid = base64_encode($genrate_verify_link_id);
	
	$body="<p> Username:  $genrate_verify_link_email</p>
	  <p><a href='http://essglobal.online/aol/verify.php?verified=$gid&email=$genrate_verify_link_email' target='_blank'>Verify Your Email Address</a>
	";
	
	$to = $genrate_verify_link_email;
	$subject="Activate Your Account - AOL";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: AOL <avneet@essglobal.com>' . "\r\n";
	$mail = mail($to,$subject,$body,$headers);
	
	header('Location: ../dashboard?sentemail=success2');
}
?>
<style>

body { background:url(../images/book.jpg) no-repeat center center fixed; background-size: cover;
</style>
<section class="container-fluid main-div">
<div class="col-sm-12">
<div class="dashboard-right">
<?php  if(isset($_GET['sentemail']) == 'success2'){ ?>
<div id='alert'>
	<div class='alert alert-success' style="text-align:center;">
		<?php echo 'Link has been sent to your email. Please check your email to activate your account.'; ?>
	</div>
</div>     
<?php } ?>
<div class="tab-content pb-5 col-xs-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 ">
    <div id="verify" class="tab-pane in active">
  <h3 class="folded"><a data-toggle="pill" href="#personalverify">To View Dashboard Verify Your Email</a></h3>
  </ul>


    <div id="personalverify" class="tab-pane in active ">

    <form class="form-vertical text-center" method="post" action="" autocomplete="off">
	
    <label for="name" style="font-size:18px;">Email Id :</label>
          
        <span  class="verify-emaiid" style="font-size:18px;"><?php echo $email_veri;?></span><br><br> 
        <span class="hideemail">
        <span class="btn btn-sm btn-submit editemail mb-4" id="editemail">Change Email</span>
        </span>
        <span class="show_editemail" style="display: none;">
            <form method="post" action="" autocomplete="off">
			<div class="row">
            <div class="col-sm-8">
			<input type="email" name="email" class="form-control mb-4" id="fname" placeholder="Email Address" required>
           <input type="hidden" class="form-control1" name="user_id" value="<?php echo $loggedid_veri;?>">
		   </div>
		  <div class="col-sm-4 pl-1">
          <input type="submit" name="submit_verify" value="Save" class="btn submit_verify">
		  </div></div> 
          </form>
        </span>     
        

  </form>
    <form method="post" action="" autocomplete="off">
	 <center>
        <input type="hidden" name="link_id" value="<?php echo $loggedid_veri;?>">  
        <input type="hidden" name="email_id" value="<?php echo $email_veri;?>">
		<span class="btn btn-warning btn-sm cancelbtn" id="cancelbtn" style="display:none;">Cancel</span>
       <input type="submit" name="email_verify" value="Verify" class="btn btn-default email_verify"></center>
    </form>
</div>    
     </div>    
    </div>
   </div>   
  </div>
 </div>
</div>
</section>
<script>
   $('.show_editemail').hide();       
   $('#editemail').on('click',function(){
	   $('.hideemail').hide();
	   $('.show_editemail').show();
	   $('#cancelbtn').show();
   });    
   
   $('#cancelbtn').on('click',function(){
	   $('.show_editemail').hide();
	   $('.hideemail').show();  
	   $('#cancelbtn').hide();
   }); 
</script> 
   
 <?php }
}else{	
	echo "Session Expire!!!";
}
?>








