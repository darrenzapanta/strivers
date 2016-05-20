<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Payment for Area Manager</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Payment Information</h2>
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

                  <form action="<?php echo base_url(); ?>TransactionController/addPaymentAM" method="post" class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amcode">AM Code: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="amcode2" id="amcode2" required="required" class="form-control col-md-7 col-xs-12">
                        <input type="hidden" id="amcode" name="amcode">
                     </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paymentmode">Mode of Payment: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="paymentmode" id="paymentmode" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paymentmode">Confirmation No (if applicable):
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="confirmno" id="confirmno" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>  
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Amount:<span class="required">*</span> </label> 
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" required class="form-control" id="amount" name="amount" value="0"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Payment:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input name="paymentdate" required id="paymentdate" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                      </div>
                    </div>
                  <?php if(validation_errors() != NULL): ?>
                    <div class="form-group">
                    <div class=" col-md-3 col-sm-3 col-xs-12">
                    </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="alert alert-danger fade in">
                            <?php echo validation_errors(); ?>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
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
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>
          <script>
              var am = [];
              <?php foreach ($am as $am_item): ?>
              <?php if ($am_item->am_code != 'Unassigned') : ?>
                var data = [];
                var data2 = [];
                data2["amcode"] = "<?php echo $am_item->am_code; ?>";
                data["value"] = "<?php echo $am_item->am_code; ?>";
                data["data"] = data2;
                am.push(data);
              <?php endif; ?>
              <?php endforeach; ?>
            $(document).ready(function() {
              $('#paymentdate').daterangepicker({
                singleDatePicker: true,
                locale: {
                  format: 'YYYY-MM-DD',
                },
                showDropdowns: true
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
              $(":input").inputmask();
              $("#amcode2").autocomplete({
                lookup: am, 
                onSelect: function(suggestion){
              
                  $("#amcode").val((suggestion.data["amcode"]));
                },
                onInvalidateSelection: function(){
    
                  $("#amcode").val("");

                },
                showNoSuggestionNotice: true     
              });
            });
          </script>
  