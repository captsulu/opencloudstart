<? 
     foreach($_COOKIE as $key=>$value){
		      setcookie($key,'',0);
            }
           @session_destroy();
           header('Location: index.html');
           exit();