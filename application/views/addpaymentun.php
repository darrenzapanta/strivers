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
                  <h2>Payment Details</h2>
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

                  <form action="<?php echo base_url(); ?>TransactionController/addPaymentUN" method="post" class="form-horizontal form-label-left">
                    <input type="hidden" id="dsp_id" name="dsp_id">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="transaction_code">Transaction Code:
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="transaction_code" id="transaction_code"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-1 2" for="name">DSP Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12" for="dealerno">Dealer No:</label>
                      <div class="col-md-4 col-sm-5 col-xs-1">
                        <input type="text" name="dealer_no" id="dealer_no"  readonly class="form-control">
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-3 col-sm-6 col-xs-12">Sim:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" class="form-control" readonly id="sim" name="sim"/>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paymentmode">Mode of Payment:
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="paymentmode" id="paymentmode" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>                     
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmationno">Confirmation No:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="confirmno" id="confirmno"  required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>                      
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="amount" id="amount"  required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>                                       
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Payment Date:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input name="paymentdate" id="paymentdate" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
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
                    <div class="ln_solid"></div>
                     <div class="x_title">
                      <h2>Transaction Details</h2>
                      <div class="clearfix"></div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-1 2">DSP Name:
                      </label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" id="t_name" readonly class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-1 2" >Transaction Date:
                      </label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" id="t_date"readonly class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-1 2" >Gross Amount: 
                      </label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" id="t_gross"readonly class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Net Amount:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="text" id="t_net"class="form-control" readonly />
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-3 col-sm-6 col-xs-12">Percentage:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" id="t_percentage"class="form-control" readonly />
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
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>
          <script>
              var path = "<?php echo site_url(); ?>";
              var app = "TransactionController";
              var names = [];
              <?php foreach ($dsp as $dsp_item): ?>
                var data = [];
                var data2 = [];
                data2["name"] = "<?php echo $dsp_item->dsp_dealer_no; ?>";
                data2["dsp_id"] = "<?php echo $dsp_item->dsp_id; ?>";
                data2["network"] = "<?php echo $dsp_item->dsp_network; ?>";
                data["value"] = "<?php echo $dsp_item->dsp_firstname." ".$dsp_item->dsp_lastname." (".$dsp_item->dsp_network.")"; ?>";
                data["data"] = data2;
                names.push(data);
              <?php endforeach; ?>
            $(document).ready(function() {
              $('#paymentdate').daterangepicker({
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
              $("#paymentdate").val(datetime)
              $("#name").autocomplete({
                lookup: names, 
                onSelect: function(suggestion){
                  $("#dealer_no").val(suggestion.data["name"]);
                  $("#sim").val((suggestion.data["network"]).toUpperCase())
                  $("#dsp_id").val(suggestion.data["dsp_id"]);
                  $("#sim").change();
                },
                onInvalidateSelection: function(){
                  $("#dealer_no").val("");
                  $("#dsp_id").val("");
                  $("#sim").val("");
                  $("#runbal").val("");
                  $("#begbal").val("");


                },
                showNoSuggestionNotice: true     
              });
            });
          $('#transaction_code').blur(function(e){
            var transaction_code = $("#transaction_code").val();
            $.ajax({
              method: 'POST',
                url: path + "/TransactionController/getTransactionByTransactionCode",
                cache: false,
                data: {transaction_code: transaction_code},
                async:false,
                success: function (data){
                  if(data.status == "failed"){
                    $("#t_name").val("");
                    $("#t_date").val("");
                    $("#t_gross").val("");
                    $("#t_net").val("");
                    $("#t_percentage").val("");
                  }else{
                    var data = data.data;
                    $("#t_name").val(data['name']);
                    $("#t_date").val(data['date']);
                    $("#t_gross").val(data['gross']);
                    $("#t_net").val(data['net']);
                    $("#t_percentage").val(data['percentage']);

                  }
                },
                error: function (data){
                  alert(data);
                } 
            });     
          });

          </script>
  