<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Transaction</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Transaction Details</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <?php if($this->session->flashdata('message') !== null): ?>
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 alert alert-info">
                      <?php echo $this->session->flashdata('message'); ?>
                    </div>
                  </div>
                <?php endif; ?>

                  <form action="<?php echo base_url(); ?>TransactionController/addTransaction" method="post" class="form-horizontal form-label-left">
                    <input type="hidden" id="dsp_id" name="dsp_id">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transaction_code">Transaction Code: <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="transaction_code" id="transaction_code" readonly class="form-control col-md-7 col-xs-12" value="<?php echo $code; ?>">
                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="am_code">AM Code:
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" readonly name="am_code" id="am_code"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12" for="dealerno">Dealer No:</label>
                      <div class="col-md-5 col-sm-5 col-xs-1">
                        <input type="text" name="dealerno" id="dealerno"  readonly class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-3 col-sm-6 col-xs-12">Sim:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" class="form-control" readonly id="sim" name="sim"/>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmationno">Confirmation No:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="confirmationno" id="confirmationno"  required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>                      
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Gross Amount:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="amount" id="amount"  required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Net Amount:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" readonly id="net_amount" name="net_amount"/>
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-3 col-sm-6 col-xs-12">Percentage:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" class="form-control" readonly id="percentage" name="percentage"/>
                      </div>
                    </div>       
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Beginning Balance:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" readonly id="begbal" name="begbal"/>
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-3 col-sm-6 col-xs-12">Running Balance:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" class="form-control" readonly id="runbal" name="runbal"/>
                      </div>
                    </div>                                    
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Transaction Date:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input name="transactiondate" id="transactiondate" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                      </div>
                    </div>

                                                  

                  <?php if(validation_errors() != NULL): ?>

                    <div class="form-group col-md-12 ">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                    </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="alert alert-danger fade in">
                            <?php echo validation_errors(); ?>
                        </div>
                      </div>
                    </div>
                    
                  <?php endif; ?>

        
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/round.js"></script>
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>
          <script>
              var path = "<?php echo site_url(); ?>";
              var app = "TransactionController";
              var names = [];
              var globalpercent = 0;
              <?php foreach ($dsp as $dsp_item): ?>
                var data = [];
                var data2 = [];
                data2["name"] = "<?php echo $dsp_item->dsp_dealer_no; ?>";
                data2["percentage"] = "<?php echo $dsp_item->dsp_percentage; ?>";
                data2["dsp_id"] = "<?php echo $dsp_item->dsp_id; ?>";
                data2["am_code"] = "<?php echo $dsp_item->am_code; ?>";
                data2["network"] = "<?php echo $dsp_item->dsp_network; ?>";
                data["value"] = "<?php echo $dsp_item->dsp_firstname." ".$dsp_item->dsp_lastname." (".$dsp_item->dsp_network.")"; ?>";
                data["data"] = data2;
                names.push(data);
              <?php endforeach; ?>
            $(document).ready(function() {
              $('#transactiondate').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD hh:mm:ss',
                  },
                "timePicker": true,
                timePicker24Hour: true,
                timePickerSeconds: true,                
                "timePickerIncrement": 1,
                showDropdowns: true
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
              $(":input").inputmask();
              var currentdate = new Date(); 
              var datetime = currentdate.getFullYear() + "-"
                      + ('0' + (currentdate.getMonth()+1)).slice(-2)  + "-" 
                      + ('0' + currentdate.getDate()).slice(-2) + " "  
                      + currentdate.getHours() + ":"  
                      + ('0' + (currentdate.getMinutes()+1)).slice(-2) + ":"  
                      + ('0' + (currentdate.getSeconds()+1)).slice(-2);
              $("#transactiondate").val(datetime)
              $("#name").autocomplete({
              	lookup: names, 
                onSelect: function(suggestion){
                  $("#dealerno").val(suggestion.data["name"]);
                  $("#sim").val((suggestion.data["network"]).toUpperCase())
                  $("#dsp_id").val(suggestion.data["dsp_id"]);
                  $("#am_code").val(suggestion.data["am_code"]);
                  var percent = suggestion.data["percentage"] * 100;
                  globalpercent = suggestion.data["percentage"];
                  percent = roundToTwo(percent);
                  $("#percentage").val(percent + '%');
                  $("#sim").change();
                },
                onInvalidateSelection: function(){
                  $("#dealerno").val("");
                  $("#dsp_id").val("");
                  $("#sim").val("");
                  $("#runbal").val("");
                   $("#am_code").val("");
                  $("#begbal").val("");
                  $("#percentage").val("");
                  globalpercent = 0;


                },
                showNoSuggestionNotice: true     
              });
            });
          $('#sim').change(function(e){
            var global_name = $("#sim").val();
            $.ajax({
              method: 'POST',
                url: path + "/globalController/getBalance",
                cache: false,
                data: {global_name: global_name},
                async:false,
                success: function (data){
                  if(data.status == "failed"){
                    alert("Error has occurred.");
                  }else{
                    $("#begbal").val(data.status);
                    if(!isNaN($("#amount").val())){
                      var running_balance = parseFloat(data.status) - parseFloat($("#amount").val());
                      $('#runbal').val(roundToTwo(running_balance));
                    }else{
                      $('#runbal').val(parseFloat(data.status));
                    }
                  }
                },
                error: function (data){
                  alert(data);
                } 
            });     
          });

          $('#amount').blur(function(e){
          if(!isNaN($("#amount").val())){
            var amount = parseFloat($("#amount").val());
            var running_balance = parseFloat($("#begbal").val()) - amount;
            var temp = amount * globalpercent;
            var net_amount = amount - temp;
            $('#net_amount').val(roundToTwo(net_amount));
            $('#runbal').val(roundToTwo(running_balance));
          }else{
            $('#runbal').val(parseFloat(data.status));
          }     
          });
          </script>
  