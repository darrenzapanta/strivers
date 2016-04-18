
<div class="container">
	<form class="col s12">
		<div class="searchdiv" id="searchdiv">
			<div class="row">
				<div class="input-field col s6">
					<button class="btn btn-small waves-effect waves-light" type="button" name="action" id="addsearch">Add new search criteria</button>
				</div>
				<div class="input-field col s6">
					<button class="btn btn-small waves-effect waves-light" type="button" name="action" id="removesearch">Remove last search criteria</button>
				</div>
			</div>
			
	    </div>
	    <div class="col m12">
		    <p class="right-align">
		    	<button class="btn btn-large waves-effect waves-light" type="submit" name="action">Search</button>
		    </p>
	    </div>
	</form>
</div>

<script>
    $(document).ready(function() {
      var field_count = 0;
      var rowName = "dynamicrow";
      var searchName = "searchcriteria";
      var dynamicName = "dynamicfield";
      var searchValues = ['DSS', 'DSP', 'Date'];

      $('select').material_select();

      $(document).on('change', '.select_field', function() {
      	var id = $(this).attr("id");
      	var val = $(this).find("option[value='" + $(this).val() + "']").text();

      	$('#' + dynamicName + id).empty();

      	switch(val) {
      		case 'DSS': $('#' + dynamicName + id).append('<input name="search_dss" id="search_dss" type="text">'); break;
      		case 'DSP': $('#' + dynamicName + id).append('<input name="search_dsp" id="search_dsp" type="text">'); break;
      		case 'Date': $('#' + dynamicName + id).append('<input name="search_date" id="search_date" type="date">'); break;
      	}
      });

      $('#addsearch').click(function(){
        addSearchCriteria();
      });   

      $('#removesearch').click(function(){
      	removeLastCriteria();
      });

      function removeLastCriteria() {
      	$('#' + rowName + (field_count - 1)).remove();
      	//$('#' + rowName + field_count + ' div').remove();
      	if (field_count > 0) {
			field_count--;
      	}
      	//$('select').material_select();
      }

      function addSearchCriteria() {
      	$('<div class="row"></div>').attr("id", rowName + field_count).attr("name", rowName + field_count).appendTo('#searchdiv');

      	$('<div class="input-field col s2"></div>').attr("id", searchName + field_count).attr("name", searchName + field_count).appendTo('#' + rowName + field_count);
      	
      	var newSelection = $("<select class='select_field' id='" + field_count + "' />");
	    	$.each(searchValues, function(key, value) {   
	    	     newSelection
	    	     	.append($('<option>', { value : key })
	    	        .text(value))  
	    	});
	    newSelection.appendTo('#' + searchName + field_count);

	   	$('<div class="input-field col s10"></div>').attr("id", dynamicName + field_count).attr("name", dynamicName + field_count).appendTo('#' + rowName + field_count);
	   	$('<input name="search_dss" id="search_dss" type="text">').appendTo('#' + dynamicName + field_count);

      	field_count++;
    	$('select').material_select();
      }
  	});
</script>