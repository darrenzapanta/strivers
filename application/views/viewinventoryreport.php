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
                    Inventory Report
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
                        <input id="daterng" class="daterange form-control">
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="form-group">
                      <div class="col-md-12 col-sm-9 col-xs-12">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" id="curstocks"> Append current stocks at the end.
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" checked="" value="1" id="radio1" name="optionsRadios"> Include In and Out.
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" value="2" id="radio2" name="optionsRadios"> Include In only.
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" value="3" id="radio3" name="optionsRadios"> Include Out only.
                          </label>
                        </div>                      
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
                  <h2>Inventory Report</h2>
                  <div class="clearfix"></div>
                </div>
                  <div id="table1">
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
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedColumns.min.js"></script>

        <script type="text/javascript">
          var path = "<?php echo site_url(); ?>";
          var app = "InventoryController";
          var flag = false;
          var curstocks = 0;
          $(document).ready(function() {
            

            $(".daterange").daterangepicker({
                "opens": "left",
                "linkedCalendars": false,
                locale: {
                  format: 'YYYY-MM-DD',
                },
              });
            $('#searchbtn').click(function(){
              
              var str = $("#daterng").val();
              var date = str.split(" ");
              var date1 = date[0];
              var date2 = date[2];
              if($("#curstocks:checked").length > 0){
                curstocks = 1;
              }else{
                curstocks = 0;

              }    
              var type = $("input[name=optionsRadios]:checked").val();              
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/generateInventoryReport",
                    cache: false,
                    data: {date1: date1, date2: date2, type: type, curstocks: curstocks},
                    async:false,
                    success: function (data){                     
                      if(data.status == "failed"){
                        alert("Error has occurred.");
                      }else if(data.status == 'success'){
                        initDT(data['columnDef'],data['rowDef']);
                        $('#datatable-buttons').dataTable().fnAddData(data['rowDef']);
                        flag = true;
                      }
                      
                    },
                    error: function (data){
                      alert("Error has occurred.");
                    } 
                });              
            });

          });
        function initDT(columnDef, data){
            var fixedcol = new Array();
            if(curstocks == 0){
              fixedcol['leftColumns'] = 1;
            }else{
              fixedcol['leftColumns'] = 1;
              //fixedcol['rightColumns'] = 1;

            }
          $('#table1').html('<table width="100%" class="table table-striped table-bordered table-hover nowrap"></table>').children('table').dataTable({
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
                  'aoColumnDefs': columnDef,
                  "bDestroy": true,
                  "aaData": data,
                  "scrollX": true,
                  scrollCollapse: true,
                  fixedColumns: fixedcol,
                     
            });
        }  
        </script>
        <script>
                  var path = "<?php echo site_url(); ?>";
          var app = "InventoryController";
        
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
       <script type="text/javascript" src="<?php echo base_url(); ?>js/autocomplete/jquery.autocomplete.js"></script>