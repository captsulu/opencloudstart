<? 
    require_once('../interface/config.inc.ihtml'); 
    
    $frm = array_merge($_POST);
    extract($frm);
     
    require('templates/boot_header.ihtml');
?>    
    <!-- page content -->
    <div class="login_wrapper">    
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
                  <? if(isset($alert) && $alert == '1'){?>
                  <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span>
                    </button>
                    <strong>Error</strong> <?=$err;?>
                  </div>
                  <? } ?>
                  <? if(isset($alert) && $alert == '2'){?>
                  <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-remove"></i></span>
                    </button>
                    <strong>Success</strong> <?=$err;?>
                  </div>
                  <? } ?>
                  
                  <form action="register" method="POST">
                  <? foreach($frm as $key => $value){ ?>
                      <input type="hidden" name="<?=$key?>" value="<?=$value?>" />  
                  <? } ?>
                      <div class="progress">
                        <div class="progress-bar progress-bar-success" data-transitiongoal="75"></div>
                      </div>
                  
                      <p>Coming Soon Sign up Packages</p>
                      <p>Software is in Beta Testing</p>  
                     
                     
                     
                     <div class="clearfix"></div>
                     <div class="row">
                        <div class="col-xs-6">
                            <label>User Name</label><br />
                            <input type="text" name="username" value="<? if(isset($username)){ echo $username; };?>" class="form-control" placeholder="User Name/Email Address" required="" pattern=".{8,}" title="Eight or more characters" />
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-6">
                            <label>Password</label><br />
                            <input type="password" name="passwd1" class="form-control" placeholder="Password" required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
                        </div>
                        <div class="col-xs-6">
                            <label>Confirm</label><br />
                            <input type="password" name="passwd2" class="form-control" placeholder="Confirm Password" required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
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
            </div>
      </div>
      </div>   
   </div>                              
<?             
          require('templates/boot_footer.ihtml');
?>     