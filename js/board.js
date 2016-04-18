

$(".info-wrapper").dblclick(function(e){
	var dataid = $(this).data('id')
	$('#newaccountnumber').val($("#"+ dataid + " .accountnumber").html());
	$('#newaccountname').val($("#"+ dataid + " .accountname").html());
	$('#newdatecreated').val($("#"+ dataid + " .datecreated").html());
	$('#newcontactnumber').val($("#"+ dataid + " .contactnumber").html());
	$('#editModal').modal('toggle');
	$('#dataid').val(dataid);
	
});

