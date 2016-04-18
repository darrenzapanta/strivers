
<div class="container">
	<form class="col s12">
	<!-- Append na lang din dito, may class na !-->
	<label>DSP Name</label>
	<div class="input-field col s12">
    	<select id="dsp" class="dsp">
    		<?php foreach ($dsp as $dsp_item): ?>
			    <option value="<?php echo $dsp_item->dsp_id; ?>"><?=$dsp_item->dsp_name?></option>
			<?php endforeach; ?>
    	</select>
    </div>
    <div class="col m12">
	    <p class="right-align">
	    	<button id="delete" class="btn btn-large waves-effect waves-light" type="button" name="action">Delete DSP</button>
	    </p>
    </div>
</div>



<script>
    $(document).ready(function() {
      $('select').material_select();
    });

    var path = "<?php echo site_url(); ?>";
	var app = "dspController";
	$("#delete").click(function(e){
		var target = $("#dsp").val();
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/deleteDSP",
	  		cache: false,
	  		data: {dsp_id: target},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "success"){
	  				alert("Deleted.");
	  				$('#dsp option[value= "' + target + '"]').remove();
	  				$('select').material_select();
	  			}else{
	  				alert("Error has occurred.");
	  			}
	  		},
	  		error: function (data){
	  			alert("Error has occurred.");
	  		} 
		});
	});
</script>

