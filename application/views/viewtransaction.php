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
                    Edit/View Transactions
                </h3>
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
                  <table data-order='[[ 5, "desc" ]]' id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>DSP Name</th>
                        <th>Dealer No.</th>
                        <th>Network</th>
                        <th>Amount</th>
                        <th>Confirmation No</th>
                        <th>Transaction Date</th>
                        
                      </tr>
                    </thead>
                    <tbody class="transaction">
                     <?php foreach ($trans as $trans_item): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $trans_item->transaction_id; ?>" id="<?php echo $trans_item->transaction_id; ?>">
                            <input class="dsp_id" type="hidden" value="<?php echo $trans_item->dsp_id ?>">
                            <td class="dsp_name"><?php echo $trans_item->dsp_firstname." ".$trans_item->dsp_lastname; ?></td>
                            <td class="dealerno"><?php echo $trans_item->dealer_no; ?></td>
                            <td class="sim"><?php echo strtoupper($trans_item->global_name); ?></td>
                            <td class="amount"><?php echo $trans_item->amount; ?></td>
                            <td class="confirmationno"><?php echo $trans_item->confirm_no; ?></td>
                            <td class="transactiondate"><?php echo $trans_item->date_created; ?></td>
                            
                            
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
              <h4 class="modal-title">Edit DSS</h4>
            </div>
            <div class="modal-body container-fluid">
              <div class="form-group">
                      <input id="newdsp_id" type="hidden">
                      <label for="newdsp">Name:</label>
                      <input class="form-control" name="newdsp" id="newdsp" type="text"/>
              </div>
              <div class="form-group">
                      <label for="newdealerno">Dealer No:</label>
                      <input type="text" name="newdealerno" id="newdealerno"  readonly class="form-control">
              </div>
              <div class="form-group">
                      <label for="newsim">Sim:</label>
                      <input type="text" class="form-control" readonly id="newsim" name="newsim"/>
              </div>              
              <div class="form-group">
                <label for="confirmation no">Confirmation No:</label>
               <input type="text" class="form-control" id="newconfirmationno" name="newconfirmationno"/>
              </div>
              <div class="form-group">
                <label>Transaction Date:</label>
                 <input name="newtransactiondate" id="newtransactiondate" class="date-picker form-control" required="required" type="text"/>
              </div>
              <div class="form-group">
                <label for="newamount">Amount:</label>
               <input type="text" class="form-control" id="newamount" name="newamount"/>
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
            $('#datatable-buttons').dataTable({
              "pageLength": 50,
              "scrollX": true,
            });
          });
          TableManageButtons.init();
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>

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
              $("#newdsp").autocomplete({
                lookup: names, 
                onSelect: function(suggestion){
                  $("#newdealerno").val(suggestion.data["name"]);
                  $("#newsim").val((suggestion.data["network"]).toUpperCase())
                  $("#newdsp_id").val(suggestion.data["dsp_id"]);
                  $("#newsim").change();
                },
                onInvalidateSelection: function(){
                  $("#newdealerno").val("");
                  $("#newdsp_id").val("");
                  $("#newsim").val("");
                  $("#newrunbal").val("");
                  $("#newbegbal").val("");


                },
                showNoSuggestionNotice: true     
              });              

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                
                $('#modalid').val(dataid);
                $('#newdsp').val($("#"+ dataid + " .dsp_name").html());
                $('#newdsp_id').val($("#"+ dataid + " .dsp_id").val());
                $('#newdealerno').val($("#"+ dataid + " .dealerno").html());
                $('#newsim').val($("#"+ dataid + " .sim").html());
                $('#newconfirmationno').val($("#"+ dataid + " .confirmationno").html());
                $('#newtransactiondate').val($("#"+ dataid + " .transactiondate").html());
                $('#newamount').val($("#"+ dataid + " .amount").html());
                console.log($("#newdsp_id").val());
                console.log(dataid);

              });    

              $("#edit").click(function(e){

                var trans_id = $("#modalid").val();
                var dsp_id = $('#newdsp_id').val();
                var transactiondate = $("#newtransactiondate").val();
                var amount = $("#newamount").val();
                var confirmationno = $("#newconfirmationno").val();
                var sim = $("#newsim").val();
                var dealerno = $('#newdealerno').val();
                console.log($('#newdsp_id').val());
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editTransaction",
                    cache: false,
                    data: {confirmationno: confirmationno, trans_id: trans_id, dsp_id: dsp_id, transactiondate: transactiondate, amount: amount, sim: sim, dealerno: dealerno},
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
                var trans_id = $("#modalid").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteTransaction",
                    cache: false,
                    data: {trans_id: trans_id},
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
  