<? 
    require('interface/config.inc.ihtml'); 
    
    
  $frm = array_merge($_POST);
  $filters = array("email" => array ("filter" => FILTER_SANITIZE_STRING,
                                        "filter" => FILTER_FLAG_STRIP_HIGH
                                     )
                    );
  
  $frm = filter_var_array($frm, $filters); 
  $emailto = $frm['email'];   
  
  //create reset Key 
  $resetkeyrand = rand(99, 99999);
  $resetKey = hash ( "sha512", $resetkeyrand); 
  
  //check to see email exists
    try  
    {  $rs = $dbh->obj_query( "select * from tbl_users where email = '$emailto' and active = '1'" ); 
             
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
             
        $passValue = $rs->obj_num_rows(); 
        $obj = $rs->obj_fetch_object();
        
    //convert login database information
    foreach ($obj as $key => $value){
        $login[$key] = $value;
    }
         
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
        require('index.html'); 
        exit();
    }  
  
     //Wrong email not found  
    if($passValue == 0){
        require('index.html'); 
        exit(); 
    }

    //update key in database and security link 
  
  $ipaddress = getIP();
     try  
{  
    $data = array( "password_reset_key" => $resetKey ,
                   "login_date" => date("Y-m-d H:i:s"),   
                   "login_IP"  => $ipaddress );  
    
    $whereIs = "user_id = ".$login['user_id'];  
    $rs = $dbh->obj_update( "tbl_users", $data, $whereIs );  
      
    if ( $dbh->obj_error() )  
        throw new Exception( $dbh->obj_error_message() );  
          
    //echo $rs->obj_affected_rows();  
      
}  
catch ( Exception $e )   
{  
    //log error and/or redirect user to error page  
    require('index.html');
    exit();
}   


  //diagnosis stuff  
   //print_r($frm); 
   
   
   //reset link 
   $resetlink = $settings->url.'forgotreset?key='.$resetKey;

    //echo $resetlink; 
    
    
 		$bcc=0;
        $emailbcc = 'captsulu@gmail.com';
        $emailfrom = 'no-reply@opencloudstart.com';
		$filename2 =  $settings->emailtemplates.'emailreset.template';
        $handle = fopen($filename2, "r");
        $body = fread($handle, filesize($filename2));
        fclose($handle);
        
        $filename3 =  $settings->emailtemplates.'emailreset.altbody';
        $handle = fopen($filename3, "r");
        $altbody = fread($handle, filesize($filename3));
        fclose($handle);

        //populate variables
        //Body str_replace
        $body = str_replace("##firstname##",$login['nameFirst'],$body);
        $body = str_replace("##link##",$resetlink,$body);
        
        
        //Altbody str_replace
        $altbody = str_replace("##firstname##",$login['nameFirst'],$altbody);
        $altbody = str_replace("##link##",$resetlink,$altbody);
        		        

    $subject = 'Open Cloud Start Password Reset';	
		
	require("emailclass/email_center.php");

  ?>  
  
  <!DOCTYPE html>
<html lang="en">
<head>
	<title>Open Cloud Start</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" type="image/png" href="images/favicon.ico"/>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css" />
    <link href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"  rel="stylesheet" />
    <link href="css/main.css"  rel="stylesheet" />    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5b7317ceafc2c34e96e79343/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->


</head>
<body>
	
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cloud"></i> Open Cloud Start Password Reset</div>
                <div class="panel-body">
                    We have sent an email to your account click on the link to reset your password.
                    <div class="form-group">
                    <a href="index.html"> Login Now </a>
                    </div>
                <div class="panel-footer">
                    Not Registred? <a href="register/register">Register here</a></div>
            </div>
        </div>
    </div>
</div>
	


	<script src="js/main.js"></script>

</body>
</html>
  
  
 