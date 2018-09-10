<? 
    require_once('../interface/config.inc.ihtml'); 
    
    require('templates/boot_header.ihtml');
?>    
    <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><i class="fa fa-cloud"></i> Open Cloud Start</h3>
                <small>Small Business Accounting Software Sign Up</small>
              </div>

             
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Account Registration</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                 <div class="col-md-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Small Business Accounting Sign up</h2>
                    <div class="pull-right">
                        <h2>3 Simple Steps</h2>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <? //print_r($group);?>
                  <form action="index2" method="POST">
                  
                      <div class="progress">
                        <div class="progress-bar progress-bar-success" data-transitiongoal="10"></div>
                      </div>
                  
                  
                     <div class="row">
                        <div class="col-xs-12">
                            <label>Company Name</label>
                            <input type="text" name="companyName" value="" class="form-control" placeholder="Company Name" required="" />
                        
                        </div>
                        <div class="col-xs-6">
                            <label>First Name</label>
                            <input type="text" name="nameFirst" value="" class="form-control" placeholder="First Name" required="" />
                        </div>
                        <div class="col-xs-6">
                            <label>Last Name</label>
                            <input type="text" name="nameLast" value="" class="form-control" placeholder="Last Name" required="" />
                        </div>
                    
                    </div> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <label>Email Address</label><br />
                            <input type="email" class="form-control has-feedback-left" placeholder="Email" name="email" required="" />
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Billing Address</label><br />
                            <input type="text" name="address1" value="" class="form-control" placeholder="Billing Address" required="" />
                        </div>
                        <div class="col-xs-12">
                             <input type="text" name="address2" value="" class="form-control" placeholder="Ste/Apt/RR" />
                        </div>
                        <div class="col-xs-6">
                             <input type="text" name="city" value="" class="form-control" placeholder="City" />
                        </div>
                        <div class="col-xs-2">
                            <input type="text" name="state" value="" class="form-control" placeholder="State" />
                        </div>
                        <div class="col-xs-4">
                            <input type="text" name="zip" value="" class="form-control" placeholder="Zip Code/Postal Code" />
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Phone/Contact Number</label>
                            <input type="text" name="phone" value="" class="form-control" placeholder="Contact Phone" required="" />
                        </div>
                    </div>
                                
                  
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-info pull-right" value="Continue" />
                </div>
                </form>
              </div>
            </div>
            </div>
            </div>
            </div>
<?             
          require('templates/boot_footer.ihtml');
?>     