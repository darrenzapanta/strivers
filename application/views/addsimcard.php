<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add Sim Card</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Sim Card</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <?php if($this->session->flashdata('message') !== null): ?>
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 alert alert-info">
                      <?php echo $this->session->flashdata('message'); ?>
                    </div>
                  </div>
                <?php endif; ?>

                  <form action="<?php echo base_url(); ?>AdminController/addSimCard" method="post" class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Sim Card Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="global_name" id="global_name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Network: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="network" name="network" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Current Balance: </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" id="currentbalance" name="currentbalance" value="0"/>
                      </div>
                    </div>
                  <?php if(validation_errors() != NULL): ?>
                    <div class="form-group">
                    <div class=" col-md-3 col-sm-3 col-xs-12">
                    </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="alert alert-danger fade in">
                            <?php echo validation_errors(); ?>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

  