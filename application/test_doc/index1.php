
<script src="jquery.min.js"></script>
<script src="document.js"></script>

<form action="uploadpro.php" enctype="multipart/form-data" class="form-horizontal-docu4" method="post">
    <div class="preview4"></div>
	 
<div class="progress4" style="display:none">
<div class="progress-bar4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
0%
</div>
</div>	
	  <input type="file" name="duolingo_file" class="form-control upload-image4 " id="showbtn4" />
	  <input type="hidden" name="stuid" value="14">
</form>


<script> 
	$(document).ready(function() {
	 var progressbar = $('.progress-bar4');
		$(".upload-image4").on('change',function(){
			$(".form-horizontal-docu4").ajaxForm(
	{
	  target: '.preview4',
	  beforeSend: function() {
	  $('.preview4').show();
	  $(".progress4").css("display","block");
	  $('#showbtn4').hide();
	  progressbar.width('0%');
	  progressbar.text('0%');
	},
	uploadProgress: function (event, position, total, percentComplete) {
		progressbar.width(percentComplete + '%');
		progressbar.text(percentComplete + '%');
	 },
	})
	.submit();
		});
	}); 
</script>
