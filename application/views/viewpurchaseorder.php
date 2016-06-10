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
                    Purchase Orders
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                    <div class="x_title">
                      <h2>Data Builder</h2>
                      <div class="clearfix"></div>
                    </div> 
                  <h1>Search</h1>     
                  <div class="form-group">
                       <div class="col-md-4 col-sm-9 col-xs-12">
                        <select id="option1" class="form-control type">
                          <option value="date">Date Range:</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-12">
                        <input class="daterange form-control">
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="form-group">
                      <div class="btn-group col-md-12 col-sm-12 col-xs-12" id="network" data-toggle="buttons">
                        <label class="control-label col-md-1 col-sm-9 col-xs-12"><h5>Network:</h5></label>
                            <?php foreach ($sim as $sim_item): ?>
                                <label class="btn btn-default col-md-1 col-sm-9 col-xs-12">
                                  <input type="radio" name="network" value="<?php echo $sim_item->global_name; ?>"><?php echo $sim_item->global_name; ?>
                                </label>
                            <?php endforeach; ?>

                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-12 col-sm-9 col-xs-12 col-md-offset-5">
                        <button id="searchbtn" type="submit" class="btn btn-success col-md-2">Submit</button>
                      </div>
                    </div>
              </div>

            </div>
          </div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Transaction Details</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover responsive">
                

                  </table>
                </div>
                </div>
              </div>  

      <div id="modal1" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
          <input type="hidden" id="modalid">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Transaction</h4>
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
        <script src="<?php echo base_url(); ?>js/bootbox/bootbox.min.js"></script>

        <script type="text/javascript">
          var path = "<?php echo site_url(); ?>";
          var app = "PurchaseOrderController";
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
                  <?php if($this->ion_auth->in_group(array(1,2))) : ?>
                    $('td:eq(5)', row).append("<a data-id = '"+data['purchase_id']+"' class='btn btn-danger deleteitem'>Delete</a>");
                  <?php endif; ?>
                  },
                  responsive: true,
                  'columnDefs': [
                  {
                      'targets': 0,
                      'title': "Network",
                      'class': "network",
                      'data': 'network'
                  }, 
                  {
                      'targets': 1,
                      'title': "Mode of Payment",
                      'class': "paymentmode",
                      'data': 'paymentmode'
                  },                 
                  {
                      'targets': 2,
                      'title': 'Reference No.',
                      'class': 'confirmno',
                      'data': 'confirmno'
                  },
                  {
                      'targets': 3,
                      'title': 'amount',
                      'class': 'amount',
                      'data': 'amount'
                  },  
                  {
                      'targets': 4,
                      'title': 'Purchase Date',
                      'class': 'purchasedate',
                      'data': 'date_created'
                  },
                    {
                        'targets': 5,
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    }],
                   'order': [[4, 'desc']]              
            });

            $(".daterange").daterangepicker({
                "opens": "left",
                "linkedCalendars": false,
                locale: {
                  format: 'YYYY-MM-DD',
                },
              });
            $('#searchbtn').click(function(){

              var str = $(".daterange").val();
              var date = str.split(" ");
              var date1 = date[0];
              var date2 = date[2];
              var network = $("input[type='radio'][name='network']:checked").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/getPurchaseOrder",
                    cache: false,
                    data: {date1: date1, date2: date2, network:network},
                    async:false,
                    success: function (data){                     
                      
                      if(data.status == "failed"){
                        $('#datatable-buttons').dataTable().fnClearTable();
                      }else if(data.status == 'success'){
                        $('#datatable-buttons').dataTable().fnClearTable();
                        if(data.recordsTotal > 0){
                          var jsdata = JSON.parse(JSON.stringify(data.data));
                          $('#datatable-buttons').dataTable().fnAddData(jsdata);
                        }
                      }
                      
                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });              
            });

          });
          
        </script>
        <script>
                 
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
            $('#datatable-buttons').on( 'click', 'a.deleteitem', function (e) {
              var purchase_id = $(this).data('id');
              var row = $(this).closest('tr');
              bootbox.confirm("<h3>Are you sure you want to delete?</h3>", function(result) {
              res = result;
              if(res == true){
                
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deletePurchaseOrder",
                    cache: false,
                    data: {purchase_id: purchase_id},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        alert("Deleted.");
                        var table = $('#datatable-buttons').DataTable();
                         table
                            .row(row)
                            .remove()
                            .draw();
                      }
                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });
                }
              });      

              });
/*              $("#edit").click(function(e){

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
*/
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>