<? 
    require('interface/config.inc.ihtml'); 
    
   $frm = array_merge($_GET, $_POST); 

   
   $filters = array("key" => array ("filter" => FILTER_SANITIZE_STRING,
                                        "filter" => FILTER_FLAG_STRIP_HIGH
                                     )
                    );
  
  $frm = filter_var_array($frm, $filters);
  
  extract($frm); 
  //get user information from database - 
  
  if(!isset($key)){
    require('index.html');
    exit();
  }
  
  
  
     try  
    {  $rs = $dbh->obj_query( "select * from tbl_users where password_reset_key = '$key' and active = '1'" ); 
             
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
    
   require('templates/form_passwordreset.ihtml'); 