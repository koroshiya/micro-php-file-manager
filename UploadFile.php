<?php
if (!defined('MPFM_INDEX')){die('You must access this through the root index!');}
?>
<center style="padding-top:300px;">
<div id="dialogform">
	<form action="ajax/uploadFile.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
	<input name="FileInput" id="FileInput" type="file" /><br /><br />
	<div id="progressbox">
		<div id="progressbar"></div>
		<div id="statustxt">0%</div>
	</div><br />
	<input type="submit" id="submit-btn" value="Upload" /><br /><br />
	<div id="output"></div>
	</form>
</div>
</center>

<script type="text/javascript">
	$('#MyUploadForm').submit(function(evt) {
		evt.preventDefault();
	    $(this).ajaxSubmit({
		    target: '#output',   // target element(s) to be updated with server response
		    beforeSubmit: beforeSubmit,  // pre-submit callback
		    success: afterSuccess,  // post-submit callback
		    uploadProgress: OnProgress, //upload progress callback
		    resetForm: false        // reset the form after successful submit
		});
	    return false;
	});
	function beforeSubmit(){
		if (!(window.File && window.FileReader && window.FileList && window.Blob)){
	       alert("Your browser does not support this feature.");
	       return false;
	    }else{
	    	var uFile = $('#FileInput')[0].files[0];
	    	var fsize = uFile.size; //get file size
        	var ext = uFile.name.split('.').pop().toLowerCase();
			if($.inArray(ext, ['zip','rar']) == -1) {
			    $("#output").html("<b>"+ext+"</b><br />Unsupported file type!");
			    return false;
			}else if (fsize>104857600){ //100MB limit
	        	alert("<b>"+fsize +"</b>File is too big. It should be less than 100 MB.");
	        	return false
	    	}
	    }
	}
	function OnProgress(event, position, total, percentComplete){
	    $('#progressbox').show();
	    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
	    $('#statustxt').html(percentComplete + '%'); //update status text
	    if(percentComplete>50){
	        $('#statustxt').css('color','#000'); //change status text to white after 50%
	    }
	}
	function afterSuccess(){
		$('#statustxt').html("100% - <a href=\"index.php\">Return to index</a>");
	}
</script>
