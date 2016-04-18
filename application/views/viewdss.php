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
                    Edit/View DSS
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>DSS Information</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Contact No.</th>
                        <th>E-mail</th>
                        <th>Birthdate</th>
                      </tr>
                    </thead>
                    <tbody class="dss">
                     <?php foreach ($dss as $dss_item): ?>
                      <?php if($dss_item->dss_id <> 0): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $dss_item->dss_id; ?>" id="<?php echo $dss_item->dss_id; ?>">
                            <td class="dss_firstname"><?php echo $dss_item->dss_firstname; ?></td>
                            <td class="dss_lastname"><?php echo $dss_item->dss_lastname; ?></td>
                            <td class="gender"><?php echo $dss_item->dss_gender; ?></td>
                            <td class="contactno"><?php echo $dss_item->dss_contactno; ?></td>
                            <td class="email"><?php echo $dss_item->dss_email; ?></td>
                            <td class="birthday"><?php echo $dss_item->dss_birthday; ?></td>
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
            <div class="modal-body">
              <div class="form-group">
                      <label for="newfirstname">First Name:</label>
                      <input class="form-control" id="newfirstname" type="text"/>
              </div>
              <div class="form-group">
                      <label for="newlastname">Last Name:</label>
                      <input class="form-control" id="newlastname" type="text" class="validate">
              </div>
              <div class="form-group">
                <label for="newgender">Gender:</label>
                    <select name="newgender" id="newgender" class="form-control">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
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
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>

          <script>
            $(document).ready(function() {
              $('#newbirthday').daterangepicker({
                singleDatePicker: true,
                format: 'YYYY-MM-DD',
                showDropdowns: true,
                container:'#modal1'
              });
              $(":input").inputmask();

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                var dss_id = $("#"+ dataid + " .dss_id").val();
                var gender = $("#"+ dataid + " .gender").html();
                $('#modalid').val(dataid);
                $('#newfirstname').val($("#"+ dataid + " .dss_firstname").html());
                $('#newlastname').val($("#"+ dataid + " .dss_lastname").html());
                $('#newemail').val($("#"+ dataid + " .email").html());
                $('#newgender option[value= "' + gender + '"]').attr("selected","selected");
                $('#newcontactno').val($("#"+ dataid + " .contactno").html());
                $('#newbirthday').val($("#"+ dataid + " .birthday").html());
              });    

              var path = "<?php echo site_url(); ?>";
              var app = "dssController";
              $("#edit").click(function(e){
                var dss_id = $("#modalid").val();
                var firstname = $("#newfirstname").val();
                var lastname = $("#newlastname").val();
                var gender = $("#newgender").val();
                var contactno = $("#newcontactno").val();
                var email = $("#newemail").val();
                var birthday = $("#newbirthday").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editDSS",
                    cache: false,
                    data: {dss_id: dss_id, firstname: firstname, lastname: lastname, gender:gender, contactno: contactno, email: email, birthday: birthday},
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
                      alert(data);
                    } 
                });
              });

              $("#delete").click(function(e){
                var dss_id = $("#modalid").val();
                var name = $("#newfull_name").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteDSS",
                    cache: false,
                    data: {dss_id: dss_id},
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
  