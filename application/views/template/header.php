<!DOCTYPE html>
<html>
	<head>
		<title>KodeLearn - Header after logging in</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/components.css" />
		<link rel="stylesheet" href="css/kodelearn.css" />
	</head>
	<body>
		<div class="menubar">
			<div class="wrap twhite">
				<ul class="lsNone l">
					<li class="menu l selected"><a href="#">Home</a></li>
					<li class="menu l"><a href="#">Profile</a></li>
					<li class="menu l"><a href="#">Inbox</a></li>
					<li class="clear"></li>
				</ul>
				<ul class="lsNone r">
					<li class="l pad10 tWhite">
						<span id="greet">Good morning</span>, 
						<span id="user">John</span> 
						<span class="tlGray">|</span>
					</li>
					<li class="menu l"><a href="#">My Account <span class="trid">&#x25BC;</span></a></li>
				</ul>
				<div class="clear"></div>
			</div><!-- wrap -->
		</div><!-- menubar -->
		
		<div class="container">
			
			<div class="branding">
				<h1 class="dib l"><a href="#"><img src="images/kodelearn.jpg" alt="KodeLearn | Home" /></a></h1>
				
				<div class="roles dib r">
					<p id="roleViewToggle">Switch roles <span class="trid">&#x25BC;</span></p>
					<ul id="roleList" class="smallMenu">
						<li class="smallText sans"><a href="#" class="role">Manager</a></li>
						<li class="smallText sans"><a href="#" class="role">Student</a></li>
					</ul>
				</div><!-- roles -->
				<div class="clear"></div>
			</div><!-- branding -->
