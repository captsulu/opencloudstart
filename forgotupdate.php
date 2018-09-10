<? 
    require('interface/config.inc.ihtml'); 
    
    $frm = array_merge($_GET, $_POST); 

   
   $filters = array("key" => array ("filter" => FILTER_SANITIZE_STRING,"filter" => FILTER_FLAG_STRIP_HIGH),
                    "userID" => array( "filter" => FILTER_VALIDATE_INT ),
                    "passwd" => array( "filter" => FILTER_SANITIZE_STRING ), 
                    "passwd2" => array( "filter" => FILTER_SANITIZE_STRING )
                    );
  
  $frm = filter_var_array($frm, $filters);
  
  extract($frm); 
  
  //check to make sure passwords match 
 function checkPassword($pwd) {
    $errors[] = $pwd;

    if (strlen($pwd) < 8) {
        $errors[] = "Password too short!";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "Password must include at least one letter!";
    } 
    if( !preg_match("#[A-Z]+#", $pwd) ) {
        $errors[]  = "Password must include at least one CAPS!";
    }

    if( !preg_match("#\W+#", $pwd) ) {
        $errors[] = "Password must include at least one symbol!";
    }

    return ($errors);
}
  
 $chkpass = checkPassword($passwd);   
 if(count($chkpass)>1){
    $err = 1;
    $login['user_id'] = $userID;
    $login['password_reset_key'] = $key;
    require('templates/form_passwordreset.ihtml');
    exit();
 }
 
 if($passwd == $passwd2){ } else {
    $err = 2; 
    $login['user_id'] = $userID;
    $login['password_reset_key'] = $key;
    require('templates/form_passwordreset.ihtml');
    exit();
 }
 
 
 //prepare to update database 
 $password = hash ( "sha512", $passwd); 
 $ipaddress = getIP();
 
      try  
{  
    $data = array( "password" => $password ,
                   "password_reset_confirmed" => 'Y', 
                   "login_date" => date("Y-m-d H:i:s"),   
                   "login_IP"  => $ipaddress );  
    
    $whereIs = "user_id = ".$userID;  
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


require('templates/form_resetlogin.ihtml');


    