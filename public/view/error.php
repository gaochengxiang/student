<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="./static/bt3/css/bootstrap.min.css">
	<style>
		body{
			background: #eee;
		}
	</style>
</head>
<body>
<div class="jumbotron" style="text-align: center">
	<h1><?php echo $this->msg ?> ):</h1>
	<p>
		如果没有跳转，请点击下面的按钮
	</p>
	<p><a class="btn btn-danger" href="javascript:<?php echo $this->url ?>;" role="button">跳转</a></p>
</div>
<script>
//	设置一个定时器 让它1.5S之后自动跳转
	setTimeout(function () {
		<?php echo $this->url ?>
    },1500);
</script>
</body>
</html>