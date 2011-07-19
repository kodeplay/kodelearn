<!DOCTYPE html>
<html>
    <head>
        <title>KodeLearn - Generic Header</title>
        <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
        <?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
    </head>
    <body>
        <div class="menubar">
            <div class="wrap twhite">
                <ul class="lsNone l">
                    <li class="menu l selected"><a href="#">Home</a></li>
                    <li class="menu l"><a href="#">About</a></li>
                    <li class="menu l"><a href="#">Features</a></li>
                    <li class="clear"></li>
                </ul>
                <ul class="lsNone r">
                    <li class="l menu"><a href="#">Sign up</a></li>
                    <li class="l pad10"><span class="tlGray">|</span></li>
                    <li class="menu l"><a href="#">Login</a></li>
                </ul>
                <div class="clear"></div>
            </div><!-- wrap -->
        </div><!-- menubar -->
        
        <div class="container">
            
            <div class="branding">
                <h1 class="dib"><a href="#"><img src="/media/image/kodelearn.jpg" alt="KodeLearn | Home" /></a></h1>
            </div><!-- branding -->
