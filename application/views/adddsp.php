<div class="right_col container" role="main">

      <div class="page-title">
            <div class="title_left">
              <h3>Add DSP</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Personal Information</h2>
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

                  <form action="<?php echo base_url(); ?>dspController/addDSP" method="post" class="form-horizontal form-label-left">

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="firstname" id="firstname" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="lastname" name="lastname" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" id="email" name="email"/>
                        <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth: <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input name="birthday" id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                      </div>
                     </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="gender" id="gender" class="form-control">
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Dealer No.:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control" id="dealerno" name="dealerno" required="required"/>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign Area Manager:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
				    		<select name="am" id="am" class="form-control">
									<?php foreach ($am as $am_item): ?>
                    <?php if ($am_item->am_code == "Unassigned") : ?>
                      <option value="<?php echo $am_item->am_code; ?>"><?=$am_item->am_code ?></option>
                    <?php else : ?>
                      <option value="<?php echo $am_item->am_code; ?>"><?=$am_item->am_code?></option>
                    <?php endif; ?>		
									<?php endforeach; ?>
				    		</select>
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Sim:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <select name="sim" id="sim" class="form-control">
                          <?php foreach ($sim as $sim_item): ?>
                                <option value="<?php echo $sim_item->global_name; ?>"><?=$sim_item->global_name?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Contact Number:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="text" class="form-control" id="contactno" name="contactno" data-inputmask="'mask' : '(9999) 999-9999'"/>
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 pull-left">
                      <label class="control-label col-md-6 col-sm-6 col-xs-12">Balance:</label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                      <input name="balance" id="balance" type="number" class="form-control" value="0">
                      </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                      <label class="control-label col-md-4 col-sm-6 col-xs-12">Percentage:</label>
                      <div class="col-md-5 col-sm-5 col-xs-12">
                        <input name="percentage" id="percentage" type="number" step="any" min="0" max="100" class="form-control" value="0" step="0.01" min="0">
                        
                      </div>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>js/input_mask/jquery.inputmask.js"></script>
          <script>
            $(document).ready(function() {
              $('#birthday').daterangepicker({
                singleDatePicker: true,
                locale: {
        		      format: 'YYYY-MM-DD',
                },
                showDropdowns: true
              }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
              });
              $(":input").inputmask();
            });
          </script>
  