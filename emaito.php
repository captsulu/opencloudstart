<? 

    $emailto = 'captsulu@gmail.com';
    
    $frm = array_merge($_GET, $_POST); 
    //print_r($frm); 
    
    
    $filters = array("email"        => array ("filter" => FILTER_VALIDATE_EMAIL), 
                     "subject"      => array ("filter" => FILTER_SANITIZE_STRING),
                     "message"      => array ("filter" => FILTER_SANITIZE_STRING),
                     "name"         => array ("filter"  => FILTER_SANITIZE_STRING)
                    );
  
  $frm = filter_var_array($frm, $filters);    
  extract($frm); 
  
  ////////////////////////////////////////////////////////////////
//  Setup following variables before requiring this 
//  file.
//  $emailto = 'customer email address'
//  $subject = 'email subject'
//  $body = 'html email'
//  $altbody = 'text email'
//  $attachfile = 0 - no   1 - yes
//  $reqfilename = 'path to file and filename'
//  $filename = 'customer seen filename'
//  $filetype = 1 - image/tif  2- application/pdf


    $body = '<html><body>
                From:    '.$name.'<br/>'; 
    $body .='   Email:   '.$email.'<br/>'; 
    $body .='   Subject: '.$subject.'<br/>';
    $body .='   Message: <br/>';
    $body .= $message;
    $body .='</body></html>';
    
    $altbody  =' From: '.$name.'('.$email.') \n';
    $altbody .=' Email: '.$email.'\n';
    $altbody .=' Subject: '.$subject.'\n';
    $altbody .=' Message: '.$message;
    
    
    //print_r($frm); 
    //echo $body;
    //die;
    
    
  require('emailclass/email_center.php');
   
 header('Location: https://www.opencloudstart.com/');
 
 ?>   