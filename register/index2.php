<? 
    require_once('../interface/config.inc.ihtml'); 
    
    $frm = array_merge($_POST);
    
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
                  <? //print_r($group);?>
                  <form action="index3" method="POST">
                  <? foreach($frm as $key => $value){ ?>
                      <input type="hidden" name="<?=$key?>" value="<?=$value?>" />  
                  <? } ?>
                  
                      <div class="progress">
                        <div class="progress-bar progress-bar-success" data-transitiongoal="45"></div>
                      </div>
                  
                  
                     <div class="row">
                        <div class="col-xs-12">
                            <label>Type of Company</label>
                            <select name="coType" class="form-control" >
                                <option value="">Select Company Type</option>
                                <option value="1">Accountant/Bookkeeper</option>
                                <option value="2">Retail Store</option>
                                <option value="3">Service Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Federal Employer Identification Number</label><br />
                            <input type="text" name="fein" value="" class="form-control" placeholder="FEIN Number"  />
                            <p>You can add this later...</p>
                        </div>
                        <div class="col-xs-4">
                             <label>Sales Tax Rate </label>   
                             <input type="text" name="salestax" value="0.06" class="form-control" />
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