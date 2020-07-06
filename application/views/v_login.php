<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Payroll</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo $base; ?>public/template/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>public/template/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(<?php echo $base; ?>public/template/login/images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Sign In
					</span>
				</div>

				<form class="login100-form validate-form">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input id='username' class="input100" type="text" name="username" placeholder="Enter username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input id='password' class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>

				

					<div class="container-login100-form-btn">
						<button id='login' class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo $base; ?>public/template/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo $base; ?>public/template/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo $base; ?>public/template/login/js/main.js"></script>
	
<script type="text/javascript">
    var url_post;

    url_post = '<?php echo $url_post; ?>'; //setting url post, variable di dapat dari controller
    $(document).ready(function ()
    {

        /*ketika tombol login di klik maka 
         * akan mengirim data dengan teknik ajax, dengan 
         * membuat properties username dan password,
         * isi didapat dari di username dan password
         */
        $('#login').click(
                function ()
                {
                    $.ajax(
                            {
                                type: "POST", //type ajax adalah post
                                url: url_post, // ketik di klik, akan mengirim data ke url postnya
                                dataType: "json", //data yang di kirim berupa json
                                data: {
                                    username: $("#username").val(), //username: adalah sebuah properties, $("#username") adalah sebuah object dari id input username
                                    password: $("#password").val() //password: adalah sebuah properties, $("#password") adalah sebuah object dari id input password

                                },
                                cache: false,
                                success:
                                        function (data, text)
                                        {

                                            if (data.hasil == 'true') {
                                                alert(data.msg); //ketika sukses maka akan masuk ke halaman dashboard di controller dashboard
                                                window.location = data.redirecto;
                                            } else {
                                                $("#err_username").html(data.err_username).fadeIn('slow');
                                                $("#err_password").html(data.err_password).fadeIn('slow');
                                                if (data.err_loginas == null) {
                                                    alert(data.msg); //ketika sukses maka akan masuk ke halaman login di controller login
                                                    window.location = data.redirecto;
                                                }

                                            }
                                        },
                                error: function (request, status, error) {
                                    alert(request.responseText + " " + status + " " + error);
                                }
                            });
                    return false;


                });
    });

    $(document).keypress(function (e) {
        if (e.which == 13) {
            $.ajax(
                    {
                        type: "POST", //type ajax adalah post
                        url: url_post, // ketik di klik, akan mengirim data ke url postnya
                        dataType: "json", //data yang di kirim berupa json
                        data: {
                            username: $("#username").val(), //username: adalah sebuah properties, $("#username") adalah sebuah object dari id input username
                            password: $("#password").val() //password: adalah sebuah properties, $("#password") adalah sebuah object dari id input password

                        },
                        cache: false,
                        success:
                                function (data, text)
                                {

                                    if (data.hasil == 'true') {
                                        alert(data.msg); //ketika sukses maka akan masuk ke halaman dashboard di controller dashboard
                                        window.location = data.redirecto;
                                    } else {
                                        $("#err_username").html(data.err_username).fadeIn('slow');
                                        $("#err_password").html(data.err_password).fadeIn('slow');
                                        if (data.err_loginas == null) {
                                            alert(data.msg); //ketika sukses maka akan masuk ke halaman login di controller login
                                            window.location = data.redirecto;
                                        }

                                    }
                                },
                        error: function (request, status, error) {
                            alert(request.responseText + " " + status + " " + error);
                        }
                    });
            return false;
        }
    });


</script>    


</body>
</html>