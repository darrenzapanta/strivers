<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Sales Payment</h3>
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

                  <form id="form1" action="<?php echo base_url(); ?>InventoryController/addInventorySales" method="post" class="form-horizontal form-label-left">
                    <div class="form-group col-md-12 ">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                    </div>
                      <div id="message-info" class="col-md-6 col-sm-6 col-xs-12">

                      </div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Sales Code: <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="sales_code" id="sales_code" class="form-control col-md-7 col-xs-12" >
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-sm-6 col-xs-12" style="padding-left:15px;padding-right:0px">
                      <label class="control-label col-sm-offset-1 col-md-6 col-sm-6 col-xs-12">Date of Payment: <span class="required">*</span>
                      </label>
                      <div class="col-md-5 col-sm-5 col-xs-12" style="padding-left:15px;padding-right:0px">
                        <input type="text" name="paymentdate" id="paymentdate" class="salesdate form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <button type="button" id="cleardate" class="btn btn-danger">Clear Date</button>
                      </div>   
                    </div>                  
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Mode of Payment:
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="sales_mop" id="sales_mop" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Receipt Number: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="sales_receipt" id="sales_receipt" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                     <div class="x_title">
                      <h2>Sales Details</h2>
                      <div class="clearfix"></div>
                    </div> 
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" readonly id="name" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Date of Sale: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" readonly id="sales_date" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Number of Items: <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="number" readonly id="itemno" value="0"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Grand Total: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="number" readonly id="grandtotal" value="0"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    

                                                  



                    

        
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button id="submitpurchase" type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>

        </div>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>
        <script src="<?php echo base_url(); ?>js/round.js"></script>    
           
          <script>
              var path = "<?php echo site_url(); ?>";
              var app = "InventoryController";
            $(document).ready(function() {

              $('#paymentdate').daterangepicker({
                singleDatePicker: true,
                "autoUpdateInput": true,
                locale: {
                    format: 'YYYY-MM-DD',
                  },             
                showDropdowns: true
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });

            });
          $("#cleardate").click(function(){
            $("#paymentdate").val("");
          });

          $("#sales_code").blur(function(e) {
              var sales_code = $('#sales_code').val();
              $.ajax({
              method: 'POST',
                url: path + "/" + app + "/getSalesTransactionBySalesCode",
                cache: false,
                data: {sales_code: sales_code},
                async:false,
                success: function (data){
                  if(data.status == "success"){
                    $('#name').val(data.name);
                    $('#itemno').val(data.itemno);
                    $('#grandtotal').val(data.grandtotal);
                    $('#sales_date').val(data.sales_date);
                  }

                },
                error: function (data){
                  $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">Error has Occurred.</div>');
                } 
            });    
          });
          $(function() {
              $('#form1').submit(function() {
                  var sales_mop = $('#sales_mop').val();
                  var paymentdate = $('#paymentdate').val();
                  var sales_receipt = $('#sales_receipt').val();
                  var sales_code = $('#sales_code').val();
                  $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/addSalesPayment",
                    cache: false,
                    data: {sales_code: sales_code, paymentdate: paymentdate, sales_mop:sales_mop, sales_receipt:sales_receipt},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        var msg = data.message;
                        //alert(msg);
                        location.reload();
                      }else{
                        var msg = data.message;
                        $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">'+msg+'</div>');
                      }

                    },
                    error: function (data){
                      $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">Error has Occurred.</div>');
                    } 
                });                   // DO STUFF
                  return false; // return false to cancel form action
              });
          });

          </script>
  