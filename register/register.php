<?
    require('../interface/config.inc.ihtml'); 
    
    $frm = array_merge($_POST); 
    extract($frm);
    //print_r($frm); 
    
    //check to see if $username>''
    if(strlen($username)<='0'){
        $alert = '1';
        $err = 'User Name cannot be blank, Try again...';
        require('index3.php');
        exit();
        
    }
    
    
    
    //check to see if username already exists
 
        $sql = "select count(user_id) as cnt from tbl_users where username = '$username' and active = '1'";
        try  
    {  $rs = $dbh->obj_query( $sql );
        $obj = $rs->obj_fetch_object(); 
        $userCnt = $obj->cnt;
     } 
    catch ( Exception $e )  
    { 
        require('error.html'); 
        exit();
    }
    
    
    if($userCnt>0){
        
        $alert = '1';
        $err = 'User Name is already taken please choose a new name...';
        require('index3.php');
        exit();
    }
       
    //match sure that passwords match
    
    if($passwd1<>$passwd2){
        
        $alert = '1';
        $err = 'Your passwords do NOT match. Please fix this...';
        require('index3.php');
        exit();
    }   
       
       
   //encrypt password
   $passwd = passwdHash($passwd1);
   
  //get ready to create account 
   
  //create confirmation Key 
  $resetkeyrand = rand(99, 99999);
  $resetKey = hash ( "sha512", $resetkeyrand);
  
  //create expire Date
  $expDate = date('Y-m-d',time()+(86400*60)); 
  
   
   $data = array( "username"            => $username,
                  "password"            => $passwd,
                  "email"               => $email,
                  "nameFirst"           => $nameFirst,
                  "nameLast"            => $nameLast, 
                  "seclevel"            => 5,
                  "confirmation_key"    => $resetKey,
                  "register_date"       => date("Y-m-d H:i:s"),
                  "expire_date"         => $expDate,
                  "login_IP"            => getIP(),
                  "active"              => '2'
                  );
                  
    //insert information 
    try{
        
    $rs = $dbh->obj_insert( "tbl_users", $data );   
       
        if ( $dbh->obj_error() )   
                throw new Exception( $dbh->obj_error_message() );   
                   
            //echo $rs->obj_affected_rows();   
             
        }   
        catch ( Exception $e )    
        {   
            echo $dbh->obj_error_message();
            die;
            //log error and/or redirect user to error page   
        }              
  
  $sql = "select * from tbl_users where confirmation_key = '".$resetKey."'";
   try { $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                    $obj = $rs->obj_fetch_object();
                    $userID = $obj->user_id;                        
                  }  
                catch ( Exception $e )  
                { 
                    echo $dbh->obj_error_message();
                    die;
                } 
  
  
  
  
  
//insert inital company
    $data = array( "user_id"        =>  $userID,
                   "companyName"    =>  $companyName,
                   "fein"           =>  $fein,
                   "salestax"       =>  $salestax,
                   "salestaxcoa"    => '2500',
                   "startdate"      => date("Y-m-d H:i:s"),
                   "active"         => '1');
                   
     try{
        
    $rs = $dbh->obj_insert( "tbl_company", $data );   
       
        if ( $dbh->obj_error() )   
                throw new Exception( $dbh->obj_error_message() );   
                   
            //echo $rs->obj_affected_rows();   
             
        }   
        catch ( Exception $e )    
        {   
            echo $dbh->obj_error_message();
            die;
            //log error and/or redirect user to error page   
        }           
        
        
                  
  //print_r($data);
  
  $resetlink = "https://app.opencloudstart.com/register/confirm?key=".$resetKey;
  
  $emailto = $email; 
  
     	$bcc=0;
        $emailbcc = 'captsulu@gmail.com';
        $emailfrom = 'no-reply@opencloudstart.com';
		$filename2 =  $settings->emailtemplates.'emailconfirm.template';
        $handle = fopen($filename2, "r");
        $body = fread($handle, filesize($filename2));
        fclose($handle);
        
        $filename3 =  $settings->emailtemplates.'emailconfirm.altbody';
        $handle = fopen($filename3, "r");
        $altbody = fread($handle, filesize($filename3));
        fclose($handle);

        //populate variables
        //Body str_replace
        $body = str_replace("##firstname##",$nameFirst,$body);
        $body = str_replace("##link##",$resetlink,$body);
        
        
        //Altbody str_replace
        $altbody = str_replace("##firstname##",$nameFirst,$altbody);
        $altbody = str_replace("##link##",$resetlink,$altbody);
        		        

    $subject = 'Open Cloud Start Confirm Account';	
		
	require("../emailclass/email_center.php");

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
                  
                  <h2>Check your email for cofirmation email. <br/>
                  Once you confirm your account you should be able to login to get started. Click on the link in your email.<br />
                  With all the email filters today you may need to check your Spam or Filtered inbox to get email. </h2>
                  <br /><br />
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
                  