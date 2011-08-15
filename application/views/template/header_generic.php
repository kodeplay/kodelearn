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
                    <li class="menu l selected"><?php echo $topmenu->home; ?></li>
                    <li class="menu l"><?php echo $topmenu->about; ?></li>
                    <li class="menu l"><?php echo $topmenu->features; ?></li>
                    <li class="clear"></li>
                </ul>
                <ul class="lsNone r">
                    <li class="l menu"><?php echo $topmenu->signuplogin; ?></li>
                </ul>
                <div class="clear"></div>
            </div><!-- wrap -->
        </div><!-- menubar -->
        
        <div class="container">
            
            <div class="branding">
                <h1 class="dib"><a href="#"><img src="<?php echo $image; ?>" alt="KodeLearn | Home" /></a></h1>
            </div><!-- branding -->
