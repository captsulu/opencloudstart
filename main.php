<? 
    require('interface/config.inc.ihtml'); 
    require('interface/chklogin.inc.ihtml');
    
    chklogin();
    
    
    $frm = array_merge($_GET, $_POST); 
    $filters = array("userID" => array ("filter" => FILTER_VALIDATE_INT), 
                    "co" => array ("filter" => FILTER_VALIDATE_INT)
                    );
  
  $frm = filter_var_array($frm, $filters);    
  extract($frm); 
  
  if(!isset($userID) && !strlen($userID)>0){
    $userID = $_COOKIE['userID']; 
  }
  
  if(!isset($co) && !strlen($co)>0){
    $co = $_COOKIE['co'];
  }
  
  if(!isset($_COOKIE['co']) && isset($co)){
    setcookie('co', $co, time()+3600);
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
    
  
    //Grab deposits by   
   try  
    {  $rs = $dbh->obj_query( "select * from tbl_coa where co_id = '$co' and type_id = '4' and active = '1' " ); 
             
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
             
        
       
    $x=0;    
    //convert login database information
    while( $obj = $rs->obj_fetch_object()){
    foreach ($obj as $key => $value){
        $bank[$x][$key] = $value;
            }
       $x++;     
    }     
    } 
    catch ( Exception $e )  
    { 
        //log error and/or redirect user to error page 
        require('index.html'); 
        exit();
    }  
  
    //grab customer numbers 
    try  
    {  $rs = $dbh->obj_query( "select count(id) as cnt from tbl_customers where co_id = '$co' and active = '1' " ); 
             
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
        $obj = $rs->obj_fetch_object(); 
        $custCount = $obj->cnt;             
        } catch ( Exception $e ) { 
        //log error and/or redirect user to error page 
        require('index.html'); 
        exit();
    }  
  
  //graph queries 
  //deposits
  $sql = "select MONTH(enterdate) as graphmonth, YEAR(enterdate) as graphyear, sum(debit) as Amt from tbl_genledger 
                where co_id = '$co' and active = '1' and histype = 'DEP' and entertype = '1'
            group by YEAR(enterdate) DESC , MONTH(enterdate) ASC limit 12;"; 
  $graphdep = array(); 
  $depositSum = 0; 
              try  
                {  $rs = $dbh->obj_query( $sql ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                     foreach ($obj as $key => $value){
                        if($key == 'Amt'){
                         array_push( $graphdep, $value);  
                         $depositSum = $depositSum + $value;    
                        } 
                        
                     }     
                   $x++;
                   }
                } 
                catch ( Exception $e )  
                { 
                    echo $dbh->obj_error_message();
                    die;
                }  
        $graphrevDep = $graphdep;    
        $graphdep = implode(",",$graphdep);
        //echo $graphdep;
        


  $sql2 = "select MONTH(enterdate) as graphmonth, YEAR(enterdate) as graphyear, sum(credit) as Amt from tbl_genledger 
                    where co_id = '$co' and active = '1' and entertype = '1'
                group by YEAR(enterdate) DESC , MONTH(enterdate) ASC
            limit 12;";
    $graphexp = array(); 
    $expenseSum = 0; 
            try  
                {  $rs = $dbh->obj_query( $sql2 ); 
                    if ( $dbh->obj_error() ) 
                        throw new Exception( $dbh->obj_error_message() ); 
                   $x=0;
                   while($obj = $rs->obj_fetch_object() ){     
                    foreach ($obj as $key => $value){
                     if($key == 'Amt'){
                         array_push( $graphexp, $value);  
                         $expenseSum = $expenseSum + $value;    
                        } 
                    }     
                   $x++;
                   }
                } 
                catch ( Exception $e )  
                {  
                    echo $dbh->obj_error_message();
                    die;
                }
     $graphrevExp = $graphexp;             
     $graphexp = implode(",",$graphexp);
      
     $revenue = array(); 
     $revenue = sum_arrays($graphrevDep,$graphrevExp); 
     $revenueDisplay = implode(",",$revenue);
     
  
  //main page load
  require('templates/boot_header.ihtml');
  require('templates/boot_menu_main.ihtml');
  require('templates/boot_top_nav.ihtml'); 
  require('templates/show_main.ihtml');
  require('templates/boot_footer.ihtml');
  
    
// print_r($company); 