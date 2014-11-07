<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freelection</title>
  
  <base href="http://giogottardi.me/freelection/" target="_self">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
    <link href="css/navbar-fixed-top.css" rel="stylesheet">
    <link href="font-awesome-4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/sticky-footer.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body{
        background: url("images/mountain.jpg") no-repeat top center fixed;
        background-color: #000;
        background-size: cover;
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        font-family: 'Karla', sans-serif;

        }
    </style>
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
        </div>
      </div>
    </div>

    <div class="container" style="height: 100%">
      <div class="verticalalign">
          <div class="bs-header text-center title-font" >
            <h1 class="btn-custom">Freelection</h1>
            <i class="fa fa-check-square-o fa-5x btn-custom"></i>
          </div>
          <?php echo form_open('register/input'); 
             $data = array(
            'name' => 'name_field',
            'class' => 'form-control login-input',
            'placeholder' => 'Name',
            'required' => 'required',
            'autofocus' => 'autofocus'
            );
       echo form_input($data);
       $data = array(
            'name' => 'email_field',
            'class' => 'form-control login-input',
            'placeholder' => 'Email',
            'required' => 'required'
            );
       echo form_input($data);
       $data = array(
            'name' => 'password_field',
            'type' => 'password',
            'class' => 'form-control login-input',
            'placeholder' => 'Password',
            'required' => 'required'
            );
       echo form_input($data);?>
	   <div style="margin-left:auto; margin-right:auto; width:63px">
	   <?
	   $options = array(
		    'voter' => 'Voter',
			'candidate' => 'Candidate',
			'admin' => 'Administrator',
			'monitor' => 'Election Monitor'
	   		);
	   echo form_dropdown('user_types', $options, 'voter', 'style="margin-bottom:10px"');
	   $data = array(
          'name' => 'mysubmit',
          'value' => 'Register',
          'class' => 'btn btn-xs btn-default'
          ); 
          echo form_submit($data, 'Register');?></div>
      <?php echo form_close(); ?>
      </div>
    </div>
    <div class="footer">
      <div class="container">
      </div>
    </div>
    <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>

