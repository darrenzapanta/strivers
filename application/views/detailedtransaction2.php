<div class="right_col" role="main">
		<div class="form-group" id="BasicGroup">
			<h4>Basic Search</h4>
            <form role="form" id="basic" action="<?php echo site_url() ?>/search/basicsearch" class="form" method="POST">
                <label>Search Post</label>
                <input id="basicsearch" name="message"></input>
                <input id="submitbasic" class="btn btn-info" type="submit" value="Search" name="submit">
            </form>
            <a href="#" id="advancedlink">Advanced Search</a>
        </div>
		<div class="form-group" id="AdvancedGroup">
            <form role="form" action="<?php echo site_url() ?>/search/advancedsearch" id="advanced" class="form" method="POST">
                <br>
                <div class="input-group" id="advancedsettings">
                </div>
                <button class="btn btn-info" id="addcontrol" type="button">+</button>
                <br>
                <br>
                <input class="btn btn-info" type="submit" value="Search" name="submit">
            </form>
            <a href="#" id="basiclink">Basic Search</a>
        </div>
<div class="table">
    <table id="table1"class="table table-striped" >

    </table>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>
<script>

$("#basic").submit(function (e){
     e.preventDefault();
    var type = $(this).attr('method');
    var url = $(this).attr('action');
    var input = $("#basicsearch").val();
    var temp = [{"type":"post", "value":input, "op":"and"}];
    var data = JSON.stringify(temp);
    console.log(data);

    $.ajax({
        url:url,
        type: type,
        data: {d:data},
        async: 'false'
    }).done(function (html){
        console.log(html);
        $("#table1").html(html);
    });
});
$("#advanced").submit(function (e){
     e.preventDefault();
    var type = $(this).attr('method');
    var url = $(this).attr('action');
    var data = [];
    var temp = {};
    temp["type"] = "post";
    temp["op"] = "and";
    temp["value"] = $("#basicsearch").val();
    data.push(temp);
    $(".subgroup").each(function(index, element){
        var item = {};
        item["type"] = $(element).children(".type").val();
        item["op"] = $(element).children(".op").val();
        item["dateop"] = $(element).children(".dateop").val();
        item["value"] = $(element).children(".advancedsearch").val();
        item["value2"] = $(element).children(".btinput").val();
        data.push(item);
    });
    data = JSON.stringify(data);
     console.log(data);

    $.ajax({
        url:url,
        type: type,
        data: {d:data},
        async: 'false'
    }).done(function (html){
        console.log(html);
        $("#table1").html(html);
    });
});

$("#AdvancedGroup").hide();
$("#advancedlink").click(function(){
    $("#submitbasic").hide();
	$("#AdvancedGroup").show();
});
$("#basiclink").click(function(){
	$("#AdvancedGroup").hide();
    $("#submitbasic").show();
	$("#BasicGroup").show();
});
$("#addcontrol").click(function(){
	var newC = "<div class=\"subgroup\"> <select class=\"type\"><option value=\"user\">User</option><option value=\"date\">Date</option></select>&nbsp<input class=\"advancedsearch\"></input>&nbsp<select class=\"op\"><option value=\"and\">AND</option><option value=\"or\">OR</option></select> &nbsp&nbsp<button class=\"btn btn-danger delete\" type=\"button\">-</button></div>";
     $("#advancedsettings").append(newC);
});


$(document).on('click', '.delete', function(e){
    $(e.target).parent().remove();
});
$(document).on('change', '.type', function(e){
    var type = (e.target.value);
    if(type == "date"){
        var newC = "&nbsp<select class=\"dateop\"><option value=\"gt\">Greater Than</option><option value=\"lt\">Less Than</option><option value=\"eq\">Equals</option><option value=\"lte\">Less Than Equal</option><option value=\"gte\">Equals</Greater Than Equal><option value=\"bt\">BETWEEN</option></select>";

        $(e.target).parent().children(".advancedsearch").daterangepicker({
        dateFormat: 'yy-mm-dd'
        });
        $(e.target).after(newC);
    }else{

         $(e.target).parent().children(".advancedsearch").datepicker('destroy');
        $(e.target).parent().children(".dateop").remove();
        $(e.target).parent().children(".btinput").remove();
    }
});
$(document).on('change', '.dateop', function(e){
    var type = (e.target.value);
    console.log($(e.target).parent().children(".advancedsearch"));
    if(type == "bt"){
        var newC = "&nbsp<input class=\"btinput\"></input>&nbsp";
        $(e.target).parent().children(".advancedsearch").after(newC);
    }else{
        $(e.target).parent().children(".btinput").remove();
    }
});
$(document).ready(function(){
    $("#addcontrol").trigger("click");
    });
</script>