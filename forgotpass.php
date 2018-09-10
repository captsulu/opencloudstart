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



</head>
<body>
	
<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cloud"></i> Open Cloud Start Forgot Password</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="forgotemail">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">
                            Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required="" name="email" />
                        </div>
                    </div>
                    
                    
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <input type="submit" class="btn btn-success" value="Send Email Reset &gt; &gt; " />
                            
                        </div>
                    </div>
                    </form>
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