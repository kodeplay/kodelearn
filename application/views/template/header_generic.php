<!DOCTYPE html>
<html>
    <head>
        <title>KodeLearn - Generic Header</title>
        <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
        <script type="text/javascript">
            var KODELEARN = KODELEARN || { };
            KODELEARN.config = {    
                base_url:  "<?php echo Url::base(); ?>" ,
                controller: "<?php echo Request::current()->controller() ?>"   
            };
        </script>
        <?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
    </head>
    <body>
        <div class="menubar">
            <div class="wrap twhite">
                <ul class="lsNone l">
                    <li class="menu l selected"><a href="http://www.kodelearn.com:3000">Home</a></li>
                    
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
