<? 

    require_once('../interface/config.inc.ihtml'); 
    
    $frm = array_merge($_GET, $_POST);
    extract($frm); 
    //print_r($frm); 
    
    //update key information 
    
    $data = array(  "confirmed"   =>  "Y",
                    "active"      =>  '1'); 
    
                    
      try{
        
    $rs = $dbh->obj_update( "tbl_users", $data, "confirmation_key='".$key."'" );   
       
        if ( $dbh->obj_error() )   
                throw new Exception( $dbh->obj_error_message() );   
                   
            //echo $rs->obj_affected_rows();   
             
        }   
        catch ( Exception $e )    
        {   
            echo "confirmation Key Error: ";
            echo $dbh->obj_error_message();
            die;
            //log error and/or redirect user to error page   
        }              
    
    
    //get account number 
     $sql = "select * from tbl_users where confirmation_key = '".$key."'";
   try { $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                    $obj = $rs->obj_fetch_object();
                    $userID = $obj->user_id;                        
                  }  
                catch ( Exception $e )  
                { 
                    echo "userid query Error: ";
                    echo $dbh->obj_error_message();
                    die;
                } 
  
  
   $account_num = $userID;
   
   require('tables/newTables.php'); 
   
   
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
                  
                  <h2>Thank you for confirming your account... </h2>
                  <br /><br />
                  <p>We have setup your basic chart of accounts. To get you started. </p>
                  <p>Once your ready you can sign in...</p>
                  <a href="https://app.opencloudstart.com/" class="btn btn-primary" > Sign In </a>
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
 
                        