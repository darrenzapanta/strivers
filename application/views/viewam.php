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
                    Edit/View Area Manager
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Area Manager Information</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>AM Code</th>
                        <th>Location</th>
                        <th>Total Balance</th>
                      </tr>
                    </thead>
                    <tbody class="am">
                     <?php foreach ($am as $am_item): ?>
                      <?php if($am_item->am_code != "Unassigned"): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $am_item->am_code; ?>" id="<?php echo $am_item->am_code; ?>">
                            <td class="am_code"><?php echo $am_item->am_code; ?></td>
                            <td class="location"><?php echo $am_item->am_location; ?></td>
                            <td class="totalbalance"><?php echo $am_item->am_totalbalance; ?></td>
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
              <h4 class="modal-title">Edit Area Manager</h4>
            </div>
            <div class="modal-body">
            <div class="row" id="message-info">

            </div>
              <div class="form-group">
                      <label for="newcode">AM Code:</label>
                      <input readonly class="form-control" id="newcode" type="text"/>
              </div>
              <div class="form-group">
                      <label for="newlocation">Location:</label>
                      <input class="form-control" id="newlocation" type="text" class="validate">
              </div>

            </div>
            <div class="modal-footer">
              <div class="row">
                <button id="edit" type="button" class="btn btn-success" >Save</button>
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

          <script>
            $(document).ready(function() {

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                $('#modalid').val(dataid);
                $('#newcode').val($("#"+ dataid + " .am_code").html());
                $('#newlocation').val($("#"+ dataid + " .location").html());

              });    

              var path = "<?php echo site_url(); ?>";
              var app = "AmController";
              $("#edit").click(function(e){
                e.preventDefault();
                var am_code = $("#newcode").val();
                var location = $("#newlocation").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editAM",
                    cache: false,
                    data: {am_code: am_code, location: location},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        var msg = data.message;
                        //alert(msg);
                        $("#message-info").html('<div class="col-md-12 col-sm-12 col-xs-12 alert alert-info">'+msg+'</div>');
                        $("#"+ am_id + " .am_code").html(am_code);
                        $("#"+ am_id + " .location").html(location);
                        
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
                var am_code = $("#modalid").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteAM",
                    cache: false,
                    data: {am_code: am_code},
                    async:false,
                    success: function (data){
                      if(data.status == "success"){
                        alert("Deleted.");
                        $("#"+am_id).remove();
                        $('#datatable-buttons').draw();
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
  