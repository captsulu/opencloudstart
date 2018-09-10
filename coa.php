<? 
    require('interface/config.inc.ihtml'); 
    require('interface/chklogin.inc.ihtml');
    
    chklogin();
    
    
    $frm = array_merge($_GET, $_POST); 
    $filters = array("userID" => array ("filter" => FILTER_VALIDATE_INT), 
                    "co" => array ("filter" => FILTER_VALIDATE_INT),
                    "order" => array("filter" => FILTER_SANITIZE_STRING),
                    "page" => array("filter" => FILTER_VALIDATE_INT)
                    
                    );
  
  $frm = filter_var_array($frm, $filters);    
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
    
  
    //Grab COA accounts
    $perpage = 12;
      $tabs = 15;
		if(isset($page) && $page>0){
			$page = $frm['page'];
			$seg = ($page*$perpage);
			$limit = "limit $seg, $perpage ";
		} else {
			$limit = "limit $perpage ";
		}
		
		if(!isset($frm['page'])){
			$page = 0;
		}
       
       if(!isset($order)){
    	$order = " cAccount, cName ";
       } 
        
        
     
     $sql = "select *, c.id as id, c.name as cName, g.name as gName, c.account as cAccount from tbl_coa c 
            	left join tbl_groups g on c.group_id = g.id 
            	where co_id = '$co' and c.active = '1' 
            union
            select *, c.id as id, c.name as cName, g.name as gName, c.account as cAccount from tbl_coa c 
            	right join tbl_groups g on c.group_id = g.id 
            	where co_id = '$co' and c.active = '1' 
              order by $order $limit";
     $sql2 = "select count(id) as cnt from tbl_coa c where active = '1' and co_id = '$co'";   
     
    try  
    {  $rs = $dbh->obj_query( $sql ); 
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
             
        $x=0;
        while($obj = $rs->obj_fetch_object()){
            foreach($obj as $key => $value){
             $coa[$x][$key] = $value;   
            }
            $x++;
        }
      
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
        echo $dbh->obj_error_message(); 
    }  
    try  
    {  $rs = $dbh->obj_query( $sql2 );
        $obj = $rs->obj_fetch_object(); 
        $records = $obj->cnt;
        
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
        require('error.html'); 
        exit();
    } 
  
  
  
  //main page load
  require('templates/boot_header.ihtml');
  require('templates/boot_menu_main.ihtml');
  require('templates/boot_top_nav.ihtml'); 
  require('templates/show_coa.ihtml');
  require('templates/boot_footer.ihtml');
  
    
 //print_r($company); 