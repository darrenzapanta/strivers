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
                    Transactions AM
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
                  <h2>Payment Details</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover responsive">
                

                  </table>
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
          var app = "TransactionController";
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
                      $('td:eq(5)', row).append("<a data-id = '"+data['payment_id']+"' class='btn btn-danger deleteitem'>Delete</a>");
                      
                      //$(row).attr('data-toggle', 'modal');
                      //$(row).attr('data-target', '#modal1');
                      //$(row).attr('data-id', data['transaction_code']);
                      //$(row).attr('id', data['transaction_id']);
                      //$('<input type="hidden" class="dsp_id" value="'+data['dsp_id']+'">').appendTo(row);
                  },
                  responsive: true,
                  'columnDefs': [
                  {
                      'targets': 0,
                      'title': "Am Code",
                      'class': "am_code",
                      'data': 'am_code'
                  },              

                  {
                      'targets': 1,
                      'title': 'Amount',
                      'class': 'amount',
                      'data': 'amount'
                  },
                  {
                      'targets': 2,
                      'title': 'Payment Date',
                      'class': 'paymentdate',
                      'data': 'date_created'
                  },
                  {
                      'targets': 3,
                      'title': 'Mode of Payment',
                      'class': 'paymentmode',
                      'data': 'paymentmode'
                  },

                  {
                      'targets': 4,
                      'title': 'Confirmation No',
                      'class': 'confirmationno',
                      'data': 'confirm_no'
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
            $('#datatable-buttons').on( 'click', 'a.deleteitem', function (e) {
              var payment_id = $(this).data('id');
              var row = $(this).closest('tr');
          bootbox.confirm("<h3>Are you sure you want to delete?</h3>", function(result) {
              res = result;
              if(res == true){
                
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteTransactionAM",
                    cache: false,
                    data: {payment_id: payment_id},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        alert("Deleted.");
                        var table = $('#datatable-buttons').DataTable();
                         table
                            .row(row)
                            .remove()
                            .draw();
                      }else{
                        alert("Error has occurred.");
                      }
                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });
                }
              });      

              });
            $('#searchbtn').click(function(){

              var str = $(".daterange").val();
              var date = str.split(" ");
              var date1 = date[0];
              var date2 = date[2];
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/getTransactionAM",
                    cache: false,
                    data: {date1: date1, date2: date2},
                    async:false,
                    success: function (data){                     
                      
                      if(data.status == "failed"){

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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>