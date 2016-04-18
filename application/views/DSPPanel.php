<div>

	<h5>Name:</h5>
	<input id="name" type="text">
	<h5>Network:</h5>
	<select id="network">
		<option value="smart">SMART</option>
		<option value="sun">SUN</option>
	</select>
	<h5>Dealer No.: </h5>
	<input id="dealerNo" type="text">
	<h5>Percentage: </h5>
	<input id="percentage"type="text">
	<h5>Balance: </h5>
	<input id="balance" type="text">
	<h5>DSS: </h5>
	<select id="dss">
		<option value="0" selected="selected"></option>
		<?php foreach ($dss as $dss_item): ?>

	        <option value="<?php echo $dss_item->dss_id; ?>"><?=$dss_item->dss_name?></option>

		<?php endforeach; ?>
	</select>
	<button id="addDSP"> Submit </button>

</div>

<script>
	var path = "<?php echo site_url(); ?>";
	var app = "dspController";
	$("#addDSP").click(function(e){
		var name = $("#name").val();
		var network = $("#network").val();
		var dealerNo = $("#dealerNo").val();
		var percentage = $("#percentage").val();
		var balance = $("#balance").val();
		var dss = $("#dss").val();
		if(dss == 0)
			dss = null;
		$.ajax({
			method: 'POST',
	  		url: path + "/" + app + "/addDSP",
	  		cache: false,
	  		data: {name: name, network: network, dealer_no: dealerNo, percentage: percentage, balance: balance, dss:dss},
	  		async:false,
	  		success: function (msg){
	  			alert("Added successfully.");
	  		},
	  		error: function (msg){
	  			alert("Error has occured.")
	  		} 
		});
	});
</script>