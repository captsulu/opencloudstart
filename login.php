<? 
    require('interface/config.inc.ihtml'); 
    
    
  $frm = array_merge($_POST);
  $filters = array("username" => array ("filter" => FILTER_SANITIZE_STRING,
                                        "filter" => FILTER_FLAG_STRIP_HIGH
                                     ), 
                    "password" => array ("filter" => FILTER_SANITIZE_STRING)
                    );
  
  $frm = filter_var_array($frm, $filters);    
    
  if(!strlen($frm['username'])>0){
    require('index.html');
    exit();
  } 
  
  if(!strlen($frm['password'])>0){
    require('index.html');
    exit();
  } 
  
 $username = $frm['username'];
 $password = passwdHash($frm['password']);  
  
 //$sql = "select * from tbl_users where username = '$username' and password = '$password' and active = '1'";
 //echo $sql; 
 //die;  
    try  
    {  $rs = $dbh->obj_query( "select * from tbl_users where username = '$username' and password = '$password' and active = '1'" ); 
             
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

    //Diagnois issues code    
    //print_r($frm); 
    //echo "<br/>User Found: ".$passValue;
    
    //Wrong username/password  
    if($passValue == 0){
        require('index.html'); 
        exit(); 
    }


    ////////$passValue  Good Login 
    $ipaddress = getIP();
    $login_date = date("Y-m-d H:i:s");
    
    //print_r($login);
    //Setup $_COOKIES
        
        setcookie("userID", $login['user_id'], time()+3600);
        setcookie("username", $username, time()+3600);
		setcookie("password", $password, time()+3600);
		setcookie("ip",$ipaddress, time()+3600);
		setcookie("seclevel", $login['seclevel'], time()+3600);
        setcookie("logindate", $login_date, time()+3600); 
        setcookie("expireDate", $login['expire_date'], time()+3600);
        
     //update database login information
    
        
    try  
{  
    $data = array( "login_date" => $login_date ,  
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
}   


require('companySelect.php');

    