<?php   
session_start();
session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" href="../images/top-logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="../css/almuni.css">
    <title>AOLCC-Student Contract Error</title>
</head>
<body>

<div class="s01 mb-5">
<div class="signin-page">
    <div class="container">
        <div class="row">
	
<div class="col-12 mt-5 text-center" id="main">

    <div class="fof  p-md-5 p-2 bg-white">
	<a href=""><img src="../images/academy_of_learning_logo.png" class="mb-5" width="200">
	</a>
	<div class="alert alert-danger">
	<strong>Success!</strong> Something went wrong. Please connect with your Admission Advisor.
	</div>
    </div>
</div>
</div>
</div>
</div>
</div>

<style>
*{transition: all 0.6s;}
html {height: 100%;}
body{
    font-family: 'Lato', sans-serif;
    color: #888;
    margin: 0;
}
#main{
    display: table;
    width: 100%;
    height: 100vh;
    text-align: center;
}
.fof { border-radius:5px; border:1px solid #ccc;}
.fof h1{
	font-size: 50px;
	display: inline-block;
	padding-right: 12px;
	animation: type .5s alternate infinite;
}
@keyframes type{
	from{box-shadow: inset -3px 0px 0px #888;}
	to{box-shadow: inset -3px 0px 0px transparent;}
}
</style>
</body>
</html>