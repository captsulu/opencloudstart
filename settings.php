<? 
    require('interface/config.inc.ihtml'); 
    require('interface/chklogin.inc.ihtml');
      
    chklogin();
    
    
  $frm = array_merge($_GET, $_POST, $_COOKIE); 
        
  extract($frm);   
  
  if(!isset($userID) && !strlen($userID)>0){
    $userID = $_COOKIE['userID']; 
    $co = $_COOKIE['co'];
  }
  
  //Get information on User/Company
    
     try  
    {  $rs = $dbh->obj_query( "select * from tbl_users u 
                                join tbl_company c on u.user_id = c.user_id
                                where c.active = '1' and c.id = '$co' " ); 
             
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
             
        
        $obj = $rs->obj_fetch_object();
        
    //convert login database information
    foreach ($obj as $key => $value){
        $company[$key] = $value;
    }
         
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
        require('index.html'); 
        exit();
    }  
  
  
  //loadinterface 
  require('interface/settings.inc.ihtml');
  
  //main page load
  require('templates/boot_header.ihtml');
  require('templates/boot_menu_main.ihtml');
  require('templates/boot_top_nav.ihtml'); 
  
  
  if(isset($frm['mode'])){	 
   switch ($frm['mode']){
   	case 'edit':
        edit($frm); 
    break;
    case 'update':
        update($frm); 
    break;
    
    
   	
   	
   	
   	
   	
   	
   	
   	default:
   		edit($frm);
   	break;			
   	
   }
   } else {
   	edit($frm);
   }  
  
  
  
  
  
  
  

  require('templates/boot_footer.ihtml');
  
    
  
  