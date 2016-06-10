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
                    Inventory Sales Transactions
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
                        <select id="type" class="form-control type">
                          <option value="date">Date Range:</option>
                          <option value="sales">Sales Code:</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-12">
                        <input class="daterange form-control">
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
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
          <?php if($this->session->userdata('type') == 'admin'): ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                    <div class="x_title">
                      <h2>Delete</h2>
                      <div class="clearfix"></div>
                    </div> 
                  <h1>Delete Sales</h1>   
 
                  <div class="form-group">
                       <div class="col-md-4 col-sm-9 col-xs-12">
                        <select id="type" class="form-control type">
                          <option value="sales">Sales Code:</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-12">
                        <input id="delete" class="delete form-control">
                      </div>
                    </div>

                    <br>
                    <br>
                    <br>
                  <div class="row" id="msg">
                  </div> 
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-12 col-sm-9 col-xs-12 col-md-offset-5">
                        <button id="deletebtn" type="submit" class="btn btn-danger col-md-2">Delete</button>
                      </div>
                    </div>
              </div>

            </div>
          </div>
        <?php endif; ?>
          <?php if($this->ion_auth->in_group(array(1,2))): ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                    <div class="x_title">
                      <h2>Delete</h2>
                      <div class="clearfix"></div>
                    </div> 
                  <h1>Delete Sales Payment</h1>   
 
                  <div class="form-group">
                       <div class="col-md-4 col-sm-9 col-xs-12">
                        <select id="type" class="form-control type">
                          <option value="sales">Sales Code:</option>
                        </select>
                      </div>
                      <div class="col-md-8 col-sm-9 col-xs-12">
                        <input id="delete2" class="delete form-control">
                      </div>
                    </div>

                    <br>
                    <br>
                    <br>
                  <div class="row" id="msg2">
                  </div> 
                    <div class="clearfix"></div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-12 col-sm-9 col-xs-12 col-md-offset-5">
                        <button id="deletebtn2" type="submit" class="btn btn-danger col-md-2">Delete</button>
                      </div>
                    </div>
              </div>

            </div>
          </div>
        <?php endif; ?>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Sales Details</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-bordered table-hover">
                

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
          var app = "InventoryController";
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
                scrollX: true,
                "createdRow": function( row, data, dataIndex ) {
                    if(data['name'] == ""){
                      $(row).addClass('danger');

                    }
                  },
                  "pageLength": 50,
                  "scrollX": true,
                  'columnDefs': [
                  {
                      'targets': 0,
                      'title': "Name",
                      'class': "name",
                      'data': 'name'
                  },                 
                  {
                      'targets': 1,
                      'title': 'Date',
                      'class': 'salesdate',
                      'data': 'date_sales'
                  },
                  {
                      'targets': 2,
                      'title': 'O.R. NO.',
                      'class': 'sales_receiptnumber',
                      'data': 'sales_receiptnumber'
                  },  
                  {
                      'targets': 3,
                      'title': 'Quantity',
                      'class': 'quantity',
                      'data': 'sales_amount'
                  },
                  {
                      'targets': 4,
                      'title': 'Items',
                      'class': 'item_code',
                      'data': 'item_code'
                  },
                  {
                      'targets': 5,
                      'title': 'Original Cost',
                      'class': 'sales_originalcost info',
                      'data': 'sales_originalcost'
                  },
                  {
                      'targets': 6,
                      'title': 'Margin',
                      'data': 'sales_margin'
                  },
                  {
                      'targets': 7,
                      'title': 'Total Margin Income',
                      'data': 'margin_income'
                  },                                                                                        
                  {
                      'targets': 8,
                      'title': 'Margin Cost',
                      'class': 'margin_cost success',
                      'data': 'sales_margincost'
                   },                  
                   {
                      'targets': 9,
                      'title': 'Total Cost',
                      'data': 'sales_totalcost'

                  },
                   {
                      'targets': 10,
                      'title': 'Date of Payment',
                      'data': 'date_payment'

                  },
                  {
                      'targets': 11,
                      'title': 'MOP',
                      'data': 'sales_mop'

                  },
                  {
                      'targets': 12,
                      'title': 'Remarks',
                      'data': 'sales_remark'

                  },
                  {
                      'targets': 13,
                      'title': 'Sales Code',
                      'data': 'sales_code'

                  }                       
                  ],
                  bSort: false           
            });
            $(".daterange").daterangepicker({
              "opens": "left",
              "linkedCalendars": false,
              locale: {
                format: 'YYYY-MM-DD',
              },
            });
            $(document).on('change', '.type', function(e){
                var type = (e.target.value);
                if(type == "date"){            
                    $(e.target).parent().parent().children().children(".daterange").daterangepicker({
                        "opens": "left",
                        "linkedCalendars": false,
                        locale: {
                          format: 'YYYY-MM-DD',
                        },
                      });  
                }else{
                    $(e.target).parent().parent().children().children(".daterange").val("");
                     $(e.target).parent().parent().children().children(".daterange").data('daterangepicker').remove();
                }
            });
            $('#searchbtn').click(function(){

              var str = $(".daterange").val();
              if($('.type').val() == 'date'){
                var date = str.split(" ");
                var date1 = date[0];
                var date2 = date[2];      
                var type = 1;
                } 
             if($('.type').val() == 'sales'){
                var sales_code = str;
                var type = 2;
                }         
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/viewSalesTransaction",
                    cache: false,
                    data: {date1: date1, date2: date2, type:type, sales_code: sales_code},
                    async:false,
                    success: function (data){                     
                      
                      if(data.status == "failed"){
                        alert("Error has occurred.");
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
            $('#deletebtn').click(function(){
            var res = false;
            bootbox.confirm("<h3>Are you sure you want to delete?</h3>", function(result) {
              res = result;
              if(res == true){
                var sales_code = $("#delete").val();     
                    $.ajax({
                      method: 'POST',
                        url: path + "/" + app + "/deleteSalesTransaction",
                        cache: false,
                        data: {sales_code: sales_code},
                        async:false,
                        success: function (data){                     
                          
                          if(data.status == "failed"){
                            $('#msg').html('<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 alert alert-danger">' +
                            '<p>'+data.message+'</p></div>')
                          }else if(data.status == 'success'){
                            $('#msg').html('<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 alert alert-danger">' +
                            '<p>Deleted successfully.</p></div>')
                            $('#datatable-buttons').dataTable().fnClearTable();
                          }
                          
                        },
                        error: function (data){
                          alert("Error has occurred.");
                        } 
                    });                     
                }
              
              });     
            });
            $('#deletebtn2').click(function(){
            var res = false;
            bootbox.confirm("<h3>Are you sure you want to delete?</h3>", function(result) {
              res = result;
              if(res == true){
                var sales_code = $("#delete2").val();     
                    $.ajax({
                      method: 'POST',
                        url: path + "/" + app + "/deleteSalesPaymentTransaction",
                        cache: false,
                        data: {sales_code: sales_code},
                        async:false,
                        success: function (data){                     
                          
                          if(data.status == "failed"){
                            $('#msg2').html('<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 alert alert-danger">' +
                            '<p>'+data.message+'</p></div>')
                          }else if(data.status == 'success'){
                            $('#msg2').html('<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 alert alert-danger">' +
                            '<p>Deleted successfully.</p></div>')
                            $('#datatable-buttons').dataTable().fnClearTable();
                          }
                          
                        },
                        error: function (data){
                          alert("Error has occurred.");
                        } 
                    });                     
                }
              
              });     
            });
          });
          
        </script>

        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>