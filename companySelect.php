<? 
    $userID = $login['user_id']; 
    $x=0; 
    $company = array();
    //$sql = "select * from tbl_company where user_id = '$userID' and active = '1'"; 
    //echo $sql; 
      
    //get companies that are assigned to this user
     try  
    {  $rs = $dbh->obj_query( "select * from tbl_company where user_id = '$userID' and active = '1'" ); 
             
        if ( $dbh->obj_error() ) 
            throw new Exception( $dbh->obj_error_message() ); 
             
        $passValue = $rs->obj_num_rows(); 
             
       
    //convert login database information
    while ( $obj = $rs->obj_fetch_object() )  
    { 
        foreach($obj as $key => $value){
            $company[$x][$key] = $value;
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
   
   //print_r($company); 
   //echo $passValue;
     
   if($passValue>1){
   
   
   require('templates/form_selectcompany.ihtml');
   exit();
   } else {
    
    
    $companyID = $company[0]['id'];
    
    //set cookie Company
    setcookie('co', $companyID, time()+3600 );
    setcookie('taxcoa',$company[0]['salestaxcoa'],time()+3600);    
    
    
    header('Location: main?userID='.$userID."&co=".$companyID);
    exit();
    
   } 
   
   
   