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
                    Edit/View DSP
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>DSP Information</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Network</th>
                        <th>Dealer No.</th>
                        <th>Area Manager</th>
                        <th>Balance</th>
                        <th>Percentage</th>
                        <th>E-Mail</th>
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Contact No</th>
                        
                      </tr>
                    </thead>
                    <tbody class="dsp">
                     <?php foreach ($dsp as $dsp_item): ?>
                      <?php if($dsp_item->dsp_id <> 0): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $dsp_item->dsp_id; ?>" id="<?php echo $dsp_item->dsp_id; ?>">
                            <td class="dsp_firstname"><?php echo $dsp_item->dsp_firstname; ?></td>
                            <td class="dsp_lastname"><?php echo $dsp_item->dsp_lastname; ?></td>
                            <td class="sim"><?php echo strtoupper($dsp_item->dsp_network); ?></td>
                            <td class="dealerno"><?php echo $dsp_item->dsp_dealer_no; ?></td>
                            <td class="am"><?php echo $dsp_item->am_code ?></td>
                            <td class="balance"><?php echo $dsp_item->dsp_balance; ?></td>
                            <td class="percentage"><?php echo ($dsp_item->dsp_percentage*100) ?></td>
                            <td class="email"><?php echo $dsp_item->dsp_email; ?></td>
                            <td class="birthday"><?php echo $dsp_item->dsp_birthday; ?></td>
                            <td class="gender"><?php echo $dsp_item->dsp_gender; ?></td>
                            <td class="contactno"><?php echo $dsp_item->dsp_contactno; ?></td>

                        </tr>
                        <?php endif ?>
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
             <div class="row" id="message-info">

            </div>
              <div class="form-group">
                      <label for="newfirstname">First Name:</label>
                      <input class="form-control" name="newlastname" id="newfirstname" type="text"/>
              </div>
              <div class="form-group">
                      <label for="newlastname">Last Name:</label>
                      <input class="form-control" name="newlastname" id="newlastname" type="text" class="validate">
              </div>
              <div class="form-group">
                <label for="newgender">Gender:</label>
                    <select name="newgender" id="newgender" class="form-control">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
              </div>
              <div class="form-group">
                      <label for="newdealerno">Dealer No:</label>
                      <input class="form-control" name="newdealerno" id="newdealerno" type="text" class="validate">
              </div>              
              <div class="form-group">
                <label for="newcontactno">Contact No:</label>
               <input type="text" class="form-control" id="newcontactno" name="newcontactno" data-inputmask="'mask' : '(9999) 999-9999'"/>
              </div>
              <div class="form-group">
                <label>E-mail</label>
                 <input name="newemail" id="newemail" class="form-control" type="text"/>

              </div>                
              <div class="form-group">
                <label>Date Of Birth:</label>
                 <input name="newbirthday" id="newbirthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text"/>

              </div>
              <br/>
              <br/>
              <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign AM</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="newam" id="newam" class="form-control">
                  <?php foreach ($am as $am_item): ?>
                      <option value="<?php echo $am_item->am_code; ?>"><?=$am_item->am_code?></option> 
                  <?php endforeach; ?>
                </select>
                </div>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                <label class="control-label col-md-2 col-sm-6 col-xs-12">Network:</label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <select name="newsim" id="newsim" class="form-control">
                    <?php foreach ($sim as $sim_item): ?>
                          <option value="<?php echo $sim_item->global_name; ?>"><?=$sim_item->global_name?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                <label class="control-label col-md-3 col-sm-6 col-xs-12">Balance:</label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                <input name="newbalance" id="newbalance" type="text" class="form-control" value="0">
                </div>
              </div>
              <div class="form-group col-md-4 col-sm-6 col-xs-12">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Percentage:</label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input name="newpercentage" id="newpercentage" type="number" min="0" max="100" class="form-control" value="0" step="0.01" min="0">
                  
                </div>
              </div>               


            </div>
            <div class="modal-footer">
              <div class="row">
                <button id="edit" type="button" class="btn btn-success">Save</button>
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
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>

          <script>
            $(document).ready(function() {
              $('#newbirthday').daterangepicker({
                singleDatePicker: true,
                locale: {
                  format: 'YYYY-MM-DD',
                },
                showDropdowns: true,
                container:'#modal1'
              });
              $(":input").inputmask();
              $("#modal1").on("hidden.bs.modal", function () {
                  
                  location.reload();
              });

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                var dsp_id = $("#"+ dataid + " .dsp_id").val();
                var am_code = $("#"+ dataid + " .am").html();
                var gender = $("#"+ dataid + " .gender").html();
                var sim = $("#"+ dataid + " .sim").html();
                $('#modalid').val(dataid);
                $('#newfirstname').val($("#"+ dataid + " .dsp_firstname").html());
                $('#newlastname').val($("#"+ dataid + " .dsp_lastname").html());
                $('#newemail').val($("#"+ dataid + " .email").html());
                $('#newgender option[value= "' + gender + '"]').attr("selected","selected");
                $('#newcontactno').val($("#"+ dataid + " .contactno").html());
                $('#newbirthday').val($("#"+ dataid + " .birthday").html());
                $('#newdealerno').val($("#"+ dataid + " .dealerno").html());
                $('#newsim option[value= "' + sim + '"]').attr("selected","selected");
                $('#newbalance').val($("#"+ dataid + " .balance").html());
                $('#newpercentage').val($("#"+ dataid + " .percentage").html());
                $('#newam option[value= "' + am_code + '"]').attr("selected","selected");
              });    

              var path = "<?php echo site_url(); ?>";
              var app = "dspController";
              $("#edit").click(function(e){
                var dsp_id = $("#modalid").val();
                var firstname = $("#newfirstname").val();
                var lastname = $("#newlastname").val();
                var gender = $("#newgender").val();
                var contactno = $("#newcontactno").val();
                var email = $("#newemail").val();
                var birthday = $("#newbirthday").val();
                var percentage = $('#newpercentage').val();
                var balance = $('#newbalance').val();
                var am = $('#newam').val();
                var dealerno = $('#newdealerno').val();
                var sim = $('#newsim').val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editDSP2",
                    cache: false,
                    data: {dsp_id: dsp_id, firstname: firstname, lastname: lastname, gender:gender, contactno: contactno, email: email, birthday: birthday, percentage: percentage, balance: balance, am: am, sim:sim, dealerno: dealerno},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        var msg = data.message;
                        $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-info">'+msg+'</div>');
                        
                      }else{
                        var msg = data.message;
                        $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">'+msg+'</div>');
                      }

                    },
                    error: function (data){
                      $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">Error has Occurred.</div>');
                    } 
                });
              });

              $("#delete").click(function(e){
                var dsp_id = $("#modalid").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteDSP",
                    cache: false,
                    data: {dsp_id: dsp_id},
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
                      alert(data);
                    } 
                });          
            });
          });
          </script> 
  