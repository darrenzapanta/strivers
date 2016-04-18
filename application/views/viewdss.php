
<div class="container">
	<table class="responsive-table bordered centered highlight">
        <thead>
          <tr>
              <th data-field="dss_id">DSS ID</th>
              <th data-field="dss_name">DSS Name</th>
          </tr>
        </thead>
        <!-- PHP append na lang based sa results sa DB, tsaka PHP din sa clickable table,  !-->
        <tbody class="dsp">
         <?php foreach ($dss as $dss_item): ?>
         	<?php if($dss_item->dss_id <> 0): ?>
	         	<tr class="modal-trigger" href="#modal1" data-id="<?php echo $dss_item->dss_id; ?>" id="<?php echo $dss_item->dss_id; ?>">
		          	<td class="dss_id"><?php echo $dss_item->dss_id; ?></td>
		          	<td class="dss_name"><?php echo $dss_item->dss_name; ?></td>
	          	</tr>
          	<?php endif ?>
         <?php endforeach; ?>	 

        </tbody>
         
      </table>          
  	<div id="modal1" class="modal">
  		<div class="modal-content">
  			<input type="hidden" id="modalid">
      		<h4>Edit DSS details</h4>
      		<form class="col s12">
				<div class="row">
			        <div class="input-field col s12">
			        	<input id="newfull_name" type="text" class="validate">
			        	<label for="newfull_name">Full Name</label>
			        </div>
			    </div>
			    <div class="col m12">
			    <p class="right-align">
			    	<button id="edit" class="btn btn-large waves-effect waves-light" type="button" name="action">Edit Details</button>
			    	<button id="delete" class="btn btn-large waves-effect waves-red red" type="button" name="action">Delete DSS</button>
			    </p>
			    </div>
      		</form>
      	</div>
  	</div>
  
</div>
<script>
 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    //$('.modal-trigger').openModal();
    //$('#modal1').openModal();
    $('select').material_select();
    $(document).on('click', '.modal-trigger', function(e) {
	    e.preventDefault();
	    //you have to trigger modal like this
	    //$(".modal-trigger").leanModal();
	    var dataid = $(this).data('id');
	    var dss_id = $("#"+ dataid + " .dss_id").val();
	    $('#modalid').val(dataid);
	    $('#newfull_name').val($("#"+ dataid + " .dss_name").html());
	    Materialize.updateTextFields();
	    $('#modal1').openModal();
	  });



  });

    var path = "<?php echo site_url(); ?>";
	var app = "dssController";
	$("#edit").click(function(e){
		var dss_id = $("#modalid").val();
		var name = $("#newfull_name").val();
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/editDSS",
	  		cache: false,
	  		data: {dss_id: dss_id, full_name: name},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "success"){
	  				alert("Edited.");
	  				location.reload();
	  			}else{
	  				alert("Error has occurred.");
	  			}

	  		},
	  		error: function (data){
	  			alert(data);
	  		} 
		});
	});

	$("#delete").click(function(e){
		var dss_id = $("#modalid").val();
		var name = $("#newfull_name").val();
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/deleteDSS",
	  		cache: false,
	  		data: {dss_id: dss_id},
	  		async:false,
	  		success: function (data){
	  			if(data.status == "success"){
	  				alert("Deleted.");
	  				location.reload();
	  			}else{
	  				alert("Error has occurred.");
	  			}
	  		},
	  		error: function (data){
	  			alert(data);
	  		} 
		});
	});	
</script>

