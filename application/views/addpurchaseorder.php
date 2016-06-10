<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Purchase Order</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Purchase Order Details</h2>
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

                  <form action="<?php echo base_url(); ?>PurchaseOrderController/addPurchaseOrder" method="post" class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sim">Sim:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="sim" id="sim" class="form-control">
                          <?php foreach ($sim as $sim_item): ?>
                                <option value="<?php echo $sim_item->global_name; ?>"><?=$sim_item->global_name?></option>
                          <?php endforeach; ?>
                        </select>
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
                        <input type="text" name="confirmno" id="confirmno"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>                                   
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="amount" id="amount"  required="required" class="form-control col-md-7 col-xs-12">
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
                        <input name="purchaseorderdate" id="purchaseorderdate" class="form-control col-md-7 col-xs-12" required="required" type="text">
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
          <script>
              var path = "<?php echo site_url(); ?>";
              var app = "PurchaseOrderController";
            $(document).ready(function() {
              $('#purchaseorderdate').daterangepicker({
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
              $("#sim").change();
                var currentdate = new Date(); 
              var datetime = currentdate.getFullYear() + "-"
                      + ('0' + (currentdate.getMonth()+1)).slice(-2)  + "-" 
                      + ('0' + currentdate.getDate()).slice(-2) + " "  
                      + currentdate.getHours() + ":"  
                      + ('0' + (currentdate.getMinutes()+1)).slice(-2) + ":"  
                      + ('0' + (currentdate.getSeconds()+1)).slice(-2);
              var datetime = moment().format('YYYY-MM-DD HH:mm:ss ');
              $("#purchaseorderdate").val(datetime)
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
                      var running_balance = parseFloat(data.status) + parseFloat($("#amount").val());
                      $('#runbal').val(running_balance);
                    }else{
                      $('#runbal').val(data.status);
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
            var running_balance = parseFloat($("#begbal").val()) + parseFloat($("#amount").val());
            $('#runbal').val(running_balance);
          }else{
            $('#runbal').val(data.status);
          }     
          });
          </script>
  