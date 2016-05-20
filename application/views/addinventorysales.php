<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Inventory Sales</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Sales Details</h2>
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
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Sales Code: <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="sales_code" readonly id="sales_code" class="form-control col-md-7 col-xs-12" value="<?php echo $code; ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="salesname">Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="sales_name" id="sales_name" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Date of Sales: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" name="salesdate" id="salesdate" required="required" class="salesdate form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item_code">Item Code: <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="item_code" id="item_code" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <input type="hidden" id="sales_itemname">
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">Cost per Item: 
                      </label>
                      <div class="col-md-3 col-sm-5 col-xs-12" style="padding-left:15px;padding-right:0px">
                        <input type="number" class="form-control" id="sales_itemcost" name="sales_itemcost"/>
                      </div>
                    </div>
                    <div class="form-group col-md-8 col-sm-6 col-xs-12">
                      <label class="control-label col-md-1 col-sm-3 col-xs-12">Margin: 
                      </label>
                      <div class="col-md-2 col-sm-6 col-xs-12">
                        <input type="number" step="any" class="form-control" value="0" id="sales_margin" name="sales_margin"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Quantity:
                      </label>
                      <div class="col-md-1 col-sm-6 col-xs-12">
                        <input type="text" name="sales_quantity" id="sales_quantity" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group col-md-5 col-sm-6 col-xs-12" style="padding-left:15px;padding-right:0px">
                      <label class="control-label col-sm-offset-1 col-md-6 col-sm-6 col-xs-12">Remarks:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12" style="padding-left:15px;padding-right:0px">
                        <input type="text" name="sales_remarks" id="sales_remarks" class="form-control">
                      </div>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <button type="button" id="additem" class="btn btn-primary">Add Item</button>
                      </div>   
                    </div>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                     <div class="x_title">
                      <h2>Payment Details</h2>
                      <div class="clearfix"></div>
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


                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" >Grand Total: <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="number" readonly id="grandtotal" value="0"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    

                                                  


                    <div class="form-group col-md-12 ">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                    </div>
                      <div id="message-info" class="col-md-6 col-sm-6 col-xs-12">

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
          <div class="row">
          <div class="col-md-9 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Sales</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover responsive">
                

                  </table>
                </div>
                </div>
              </div>  
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
              var items = [];
              var all_items = [];
              <?php foreach ($item as $item_item): ?>
                var data = [];
                var data2 = [];
                data2["item_name"] = "<?php echo $item_item->item_name; ?>";
                data2["item_cost"] = "<?php echo $item_item->item_cost; ?>";
                data["value"] = "<?php echo $item_item->item_code; ?>";
                data["data"] = data2;
                items.push(data);
              <?php endforeach; ?>
            $(document).ready(function() {

            $('#datatable-buttons').dataTable({
                  dom: "Bfrtip",
                  buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                  }, {
                    extend: "csv",
                    className: "btn-sm"
                  }, {
                    extend: "excel",
                    className: "btn-sm"
                  }, {
                    extend: "pdf",
                    className: "btn-sm"
                  }, {
                    extend: "print",
                    className: "btn-sm"
                  }],
                "createdRow": function( row, data, dataIndex ) {
                   $('td:eq(8)', row).append("<a class='btn btn-danger deleteitem'>Delete</a>");
                  },
                  responsive: true,
                  'columnDefs': [
                  {
                      'targets': 0,
                      'title': "Item Code",
                      'class': "t_item_code",
                      'data': 'item_code'
                  },                 
                  {
                      'targets': 1,
                      'title': 'Item Name',
                      'class': 't_item_name',
                      'data': 'item_name'
                  },
                  {
                      'targets': 2,
                      'title': 'Item Cost (Base Price)',
                      'class': 't_item_cost',
                      'data': 'item_cost'
                  },
                  {
                      'targets': 3,
                      'title': 'Margin',
                      'class': 't_item_margin',
                      'data': 'item_margin'
                  },
                  {
                      'targets': 4,
                      'title': 'Item Quantity',
                      'class': 't_item_quantity',
                      'data': 'item_quantity'
                  },
                  {
                      'targets': 5,
                      'title': 'Item Cost w/ Margin',
                      'class': 't_item_costmargin',
                      'data': 'item_costmargin'
                  },  
                  {
                      'targets': 6,
                      'title': 'Total Cost',
                      'class': 't_item_totalcost',
                      'data': 'item_totalcost'
                  },
                  {
                      'targets': 7,
                      'title': 'Remarks',
                      'class': 't_item_remarks',
                      'data': 'item_remarks'
                  },
                  {
                      'targets': 8,
                      "orderable":      false,
                      "data":           null,
                      "defaultContent": ''
                  }]           
            });          
              $('.salesdate').daterangepicker({
                singleDatePicker: true,
                "autoUpdateInput": true,
                locale: {
                    format: 'YYYY-MM-DD',
                  },             
                showDropdowns: true
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
              $('#paymentdate').val("");
              $("#item_code").autocomplete({
                lookup: items, 
                onSelect: function(suggestion){
                  $("#sales_itemname").val(suggestion.data["item_name"]);
                  $("#sales_itemcost").val(suggestion.data["item_cost"])
                },
                onInvalidateSelection: function(){
                  $("#sales_itemname").val("");
                  $("#item_code").val("");
                  $("#sales_itemcost").val(""); 
                  $("#sales_quantity").val("");  



                },
                showNoSuggestionNotice: true     
              });
            });
          $("#cleardate").click(function(){
            $("#paymentdate").val("");
          });
          $("#additem").click(function(){
            var data = [];
            var table = $('#datatable-buttons').DataTable();
            var code = $('#item_code').val();
            var name = $('#sales_itemname').val();
            var cost = $('#sales_itemcost').val();
            var quantity = $('#sales_quantity').val();
            var margin = $('#sales_margin').val();
            var remarks = $('#sales_remarks').val();
            var costmargin = roundToTwo(Number(cost) + Number(margin));
            var totalcost = roundToTwo(costmargin * Number(quantity));
            data = [ {
              "item_code": code,
              "item_name": name,
              "item_cost": cost,
              "item_quantity": quantity, 
              "item_totalcost": totalcost,
              "item_costmargin": costmargin,
              "item_margin": margin,
              "item_remarks": remarks,
            }];
            table.rows.add(data)
            .draw();
            $("#sales_itemname").val("");
            $("#item_code").val("");
            $("#sales_itemcost").val(""); 
            $("#sales_amount").val("");
            $("#sales_quantity").val("");
            $('#sales_remarks').val(""); 
            var gtotal = $("#grandtotal").val();
            var newgtotal = roundToTwo(Number(gtotal) + Number(totalcost));
            $("#grandtotal").val(newgtotal);          
          });
          $('#datatable-buttons').on( 'click', 'a.deleteitem', function (e) {
               var table = $('#datatable-buttons').DataTable();
               var table1 = $('#datatable-buttons').dataTable();
               var row = $(this).closest('tr');
               var data = table1.fnGetData(row);
               var gtotal = $("#grandtotal").val();
               var newgtotal = roundToTwo(Number(gtotal) - data['item_totalcost']);
               $("#grandtotal").val(newgtotal);
               table
                  .row($(this).closest('tr'))
                  .remove()
                  .draw();
          } );
          $('#submitpurchase').click(function(){
           
          });
          $(function() {
              $('#form1').submit(function() {
                  var table =  $('#datatable-buttons').dataTable();
                  all_items = [];
                  table.each(function(){
                      $(this).find('tr').each(function(){
                          var data = table.fnGetData( this );
                          if(data != null){
                            all_items.push(data);
                          }
                      })
                  });
                  var salesdate = $('#salesdate').val();
                  var paymentdate = $('#paymentdate').val();
                  var sales_mop = $('#sales_mop').val();
                  var sales_name = $('#sales_name').val();
                  var sales_receipt = $('#sales_receipt').val();
                  var sales_code = $('#sales_code').val();
                  $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/addInventorySales",
                    cache: false,
                    data: {sales_name: sales_name, sales_code: sales_code, paymentdate: paymentdate, sales_mop:sales_mop, sales_name:sales_name, all_items:all_items, salesdate:salesdate, sales_receipt:sales_receipt},
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
  