<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Document</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
		<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.0.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div id="wrapper">

		<header>
			<!--header code goes here!-->
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<i class="ion-university"></i>
							<span class="icon-local-library"></span>
						</a>
					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
						<ul class="nav navbar-nav">
							<li class="active"><a href="#">پرسش و پاسخ <span class="sr-only">(current)</span></a></li>
							<li><a href="#">دانلود منابع</a></li>
							<li><a href="#">اخبار و اطلاعیه</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#">ورود استاد</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<main>
			<?php echo $content; ?>
		</main>
		<footer class="main-footer">
					<p>کپی‌رایت © ۱۳۹۳. کلیه حقوق این سایت متعلق به آقای مجتبی مددیار می باشد<p>
		</footer>

		</div>
	</body>
</html>
