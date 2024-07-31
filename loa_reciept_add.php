<?php 
include("db.php");
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<p>Toronto LOA Receipt Id:</p>
<form class="form-horizontal" method="post" autocomplete="off" name="registerFrm" id="registerFrm">
Enter Number:

<input type="text" name="aolid" class="aolid" id="aolid">
<button type="button" class="btn btn-default" id="registerbtn">Create</button>

</form>
<br>
<p>Hamilton LOA Receipt Id:</p>
<form class="form-horizontal" method="post" autocomplete="off" name="registerFrm_h" id="registerFrm_h">
Enter Number:

<input type="text" name="aolid_h" class="aolid_h" id="aolid_h">
<button type="button" class="btn btn-default" id="registerbtn_h">Create</button>

</form>

<br>
<p>Brampton LOA Receipt Id:</p>
<form class="form-horizontal" method="post" autocomplete="off" name="registerFrm_B" id="registerFrm_B">
Enter Number:

<input type="text" name="aolid_B" class="aolid_B" id="aolid_B">
<button type="button" class="btn btn-default" id="registerbtn_B">Create</button>

</form>

<script>
$(document).ready(function (){
	$('#aolid').keyup(aolidfun);
});

function aolidfun(){	
	var username1 = $('#aolid').val();
	if(username1 == "") {
		$('.aolid').css({"border":"1px solid red"});
	} else {
		$('.aolid').css({"border":"1px solid #CCCCCC"});
	}
}

$('#registerbtn').on('click', function(e){
	e.preventDefault();
	var aolid2 = $('#aolid').val();
	
	if(aolid2 == "") {
		$('.aolid').css({"border":"1px solid red"});		
	}	
	
	if(aolid2 == ""){
		return false;
	}
	 
	var form=document.getElementById('registerFrm');
	var fdata=new FormData(form); 
	$.ajax({
		type: "POST",
		url: 'response.php?tag=AddLOAReceipt',
		data: fdata,
		contentType: false,
		cache: false,
		processData:false,
		success: function(result){
			if(result == 1){
				alert('Added');
				$("#registerFrm")[0].reset();
				return false;
			}
		}
	});
	
});

// <!----Hamilton---> ///
$(document).ready(function (){
	$('#aolid_h').keyup(aolidfun_h);
});

function aolidfun_h(){	
	var username1_h = $('#aolid_h').val();
	if(username1_h == "") {
		$('.aolid_h').css({"border":"1px solid red"});
	} else {
		$('.aolid_h').css({"border":"1px solid #CCCCCC"});
	}
}

$('#registerbtn_h').on('click', function(e){
	e.preventDefault();
	var aolid2_h = $('#aolid_h').val();
	
	if(aolid2_h == "") {
		$('.aolid_h').css({"border":"1px solid red"});		
	}	
	
	if(aolid2_h == ""){
		return false;
	}
	 
	var form_h=document.getElementById('registerFrm_h');
	var fdata_h=new FormData(form_h); 
	$.ajax({
		type: "POST",
		url: 'response.php?tag=AddLOAReceipt_h',
		data: fdata_h,
		contentType: false,
		cache: false,
		processData:false,
		success: function(result_h){
			if(result_h == 1){
				alert('Added');
				$("#registerFrm_h")[0].reset();
				return false;
			}
		}
	});
	
});

// <!----Hamilton---> ///
$(document).ready(function (){
	$('#aolid_h').keyup(aolidfun_h);
});

function aolidfun_h(){	
	var username1_h = $('#aolid_h').val();
	if(username1_h == "") {
		$('.aolid_h').css({"border":"1px solid red"});
	} else {
		$('.aolid_h').css({"border":"1px solid #CCCCCC"});
	}
}

$('#registerbtn_B').on('click', function(e){
	e.preventDefault();
	var aolid2_B = $('#aolid_B').val();
	
	if(aolid2_B == "") {
		$('.aolid_B').css({"border":"1px solid red"});		
	}	
	
	if(aolid2_B == ""){
		return false;
	}
	 
	var form_B=document.getElementById('registerFrm_B');
	var fdata_B=new FormData(form_B); 
	$.ajax({
		type: "POST",
		url: 'response.php?tag=AddLOAReceipt_B',
		data: fdata_B,
		contentType: false,
		cache: false,
		processData:false,
		success: function(result_B){
			if(result_B == 1){
				alert('Added');
				$("#registerFrm_B")[0].reset();
				return false;
			}
		}
	});
	
});
</script>