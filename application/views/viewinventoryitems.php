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
                    Edit/View Inventory Items
                </h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Item Information</h2>
                  <div class="clearfix"></div>
                </div>
                  <table id="datatable-buttons" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Item Category</th>
                        <th>Item Cost</th>
                        <th>Total Stocks</th>
                      </tr>
                    </thead>
                    <tbody class="am">
                     <?php foreach ($item as $item_item): ?>
                        <tr class="modal-trigger" data-toggle="modal" data-target="#modal1" data-id="<?php echo $item_item->item_code; ?>" id="<?php echo $item_item->item_code; ?>">
                            <td class="item_code"><?php echo $item_item->item_code; ?></td>
                            <td class="item_name"><?php echo $item_item->item_name; ?></td>
                            <td class="item_category"><?php echo $item_item->item_category; ?></td>
                            <td class="item_cost"><?php echo $item_item->item_cost; ?></td>
                            <td class="item_stock"><?php echo $item_item->item_stock; ?></td>
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
              <h4 class="modal-title">Edit Item</h4>
            </div>
            <div class="modal-body">
            <div class="row" id="message-info">

            </div>
              <div class="form-group">
                      <label for="newitemcode">Item Code:</label>
                      <input class="form-control" id="newitemcode" type="text"/>
              </div>
              <div class="form-group">
                      <label for="newitemname">Item Description</label>
                      <input class="form-control" id="newitemname" type="text" class="validate">
              </div>
              <div class="form-group">
                      <label for="newitemcategory">Item Category</label>
                      <input class="form-control" id="newitemcategory" type="text" class="validate">
              </div>
              <div class="form-group">
                      <label for="newitemcost">Item Cost</label>
                      <input type="number" class="form-control" id="newitemcost" type="text" class="validate">
              </div>
              <div class="form-group">
                      <label for="newitemstock">Item Stock</label>
                      <input type="number" class="form-control" id="newitemstock" type="text" class="validate">
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <button id="edit" type="button" class="btn btn-success" >Save</button>
                <button id="delete" type="button" class="btn btn-danger" >Delete</button>
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
              "pageLength": 20;
            });
          });
          TableManageButtons.init();
        </script>

          <script>
            $(document).ready(function() {

              $(document).on('click', '.modal-trigger', function(e) {
                e.preventDefault();
                var dataid = $(this).data('id');
                $('#modalid').val(dataid);
                $('#newitemcode').val($("#"+ dataid + " .item_code").html());
                $('#newitemname').val($("#"+ dataid + " .item_name").html());
                $('#newitemcategory').val($("#"+ dataid + " .item_category").html());
                $('#newitemcost').val($("#"+ dataid + " .item_cost").html());
                $('#newitemstock').val($("#"+ dataid + " .item_stock").html());
              });    

              var path = "<?php echo site_url(); ?>";
              var app = "InventoryController";
              $("#edit").click(function(e){
                e.preventDefault();
                var item_code = $("#modalid").val();
                var item_name = $("#newitemname").val();
                var item_cost = $("#newitemcost").val();
                var item_stock = $("#newitemstock").val();
                var item_category = $("#newitemcategory").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/editInventoryItem",
                    cache: false,
                    data: {item_code:item_code, item_name:item_name, item_category:item_category, item_cost:item_cost, item_stock:item_stock},
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
                });
              });

              $("#delete").click(function(e){
                var item_code = $("#modalid").val();
                $.ajax({
                  method: 'POST',
                    url: path + "/" + app + "/deleteInventoryItem",
                    cache: false,
                    data: {item_code: item_code},
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
                });          
            });
          });
          </script> 
  