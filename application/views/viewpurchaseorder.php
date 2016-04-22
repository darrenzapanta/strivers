     <style>
      .daterangepicker.dropdown-menu {
          z-index: 1200 !important;
        }
      </style>   

      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>
                    Edit/View Purchase Order
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Purhcase Order Details</h2>
                  <div class="clearfix"></div>
                </div>
                  <table data-order='[[ 2, "desc" ]]' id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Sim</th>
                        <th>Amount</th>
                        <th>Purchase Order Date</th>
                        
                      </tr>
                    </thead>
                    <tbody class="transaction">
                     <?php foreach ($po as $po_item): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $po_item->purchase_id; ?>" id="<?php echo $po_item->purchase_id; ?>">
                            
                            <td class="sim"><?php echo strtoupper($po_item->global_name); ?></td>
                            <td class="amount"><?php echo $po_item->amount; ?></td>
                            <td class="purchaseorderdate"><?php echo $po_item->date_created; ?></td>

                        </tr>
                     <?php endforeach; ?>  

                    </tbody>                    

                  </table>
                </div>
                </div>       
      <div id="modal1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
          <input type="hidden" id="modalid">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Purchase Order</h4>
            </div>
            <div class="modal-body container-fluid">
              <div class="form-group">
                      <label for="newsim">Sim:</label>
                        <select name="newsim" id="newsim" class="form-control">
                          <?php foreach ($sim as $sim_item): ?>
                                <option value="<?php echo $sim_item->global_name; ?>"><?=$sim_item->global_name?></option>
                          <?php endforeach; ?>
                        </select>             
              </div>  
              <div class="form-group">
                <label for="newamount">Amount:</label>
               <input type="text" class="form-control" id="newamount" name="newamount"/>
              </div>                            
              <div class="form-group">
                <label>Purchase Order Date:</label>
                 <input name="newpurchaseorderdate" id="newpurchaseorderdate" class="date-picker form-control" required="required" type="text"/>
              </div>
            
            </div>

            <div class="modal-footer">
              <div class="row">
                <button id="edit" type="button" class="btn btn-success" data-dismiss="modal">Save</button>
                <button id="delete" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
              </div>
            </div>
          </div>

        </div>
      </div>      
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
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
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
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>

        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable-buttons').dataTable();
          });
          TableManageButtons.init();
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>

          <script>
              var path = "<?php echo site_url(); ?>";
              var app = "PurchaseOrderController";
            $(document).ready(function() {
              $('#newtransactiondate').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD hh:mm:ss',
                  },
                "timePicker": true,
                timePicker24Hour: true,
                timePickerSeconds: true,                
                "timePickerIncrement": 1,
                showDropdowns: true
              });  

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                var sim = $("#"+ dataid + " .sim").html();
                $('#modalid').val(dataid);
                $('#newsim option[value= "' + sim + '"]').attr("selected","selected");
                $('#newpurchaseorderdate').val($("#"+ dataid + " .purchaseorderdate").html());
                $('#newamount').val($("#"+ dataid + " .amount").html());

              });    

              $("#edit").click(function(e){

                var purchase_id = $("#modalid").val();
                var purchaseorderdate = $("#newpurchaseorderdate").val();
                var amount = $("#newamount").val();
                var sim = $("#newsim").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editPurchaseOrder",
                    cache: false,
                    data: {purchase_id: purchase_id, purchaseorderdate:purchaseorderdate, amount:amount, sim:sim},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        alert("Edited.");
                        location.reload();
                      }else{
                        alert("Error has occurred.");
                      }

                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });
              });

              $("#delete").click(function(e){
                var purchase_id = $("#modalid").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deletePurchaseOrder",
                    cache: false,
                    data: {purchase_id: purchase_id},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        alert("Deleted.");
                        location.reload();
                      }else{
                        alert("Error has occurred.");
                      }
                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });          
            });
          });
          </script> 
  