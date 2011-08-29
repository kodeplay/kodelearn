<!DOCTYPE html>
<html>

    <head>
        <title><?php ECHO $title ?></title>
        <?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL ?>
        <?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL ?>
    </head>
    <body>
<div id="ajax-loader"><img src="<?php echo URL::base() ?>media/image/ajax-loader.gif" alt="loading" title="loading.."/></div>

        <div class="menubar">
            <div class="wrap twhite">
                <ul class="lsNone l">
                    <li class="menu l selected"><?php echo $topmenu->home; ?></li>
                    <li class="menu l"><?php echo $topmenu->profile; ?></li>
                    <li class="menu l"><?php echo $topmenu->inbox; ?></li>
                    <li class="clear"></li>
                </ul>
                <?php //$b = time(); $hour = date("g:i",$b); $m = date ("A", $b); if ($m == "AM") { if ($hour == 12) { $msg = "Good Evening!"; } elseif ($hour < 4) { $msg = "Good Evening!"; } elseif ($hour > 3) { $msg = "Good Morning!"; } } elseif ($m == "PM") { if ($hour == 12) { $msg = "Good Afternoon!"; } elseif ($hour < 5) { $msg = "Good Afternoon!"; } elseif ($hour > 4) { $msg = "Good Evening!"; } } ?> 
                
                <ul class="lsNone r">
                    <li class="l pad10 tWhite">
                        <span id="greet"><?php //echo $msg ?></span>, 
                        <span id="user"><?php echo $username;?></span> 
                        <span class="tlGray">|</span>
                    </li>

                   <li class="menu l"><a href="#" id="myac">My Account <span class="trid">&#x25BC;</span></a></li>
                    
                </ul>
				<ul id="myacContent" class="crsrPoint">
					<?php 
                        $links = $myaccount->as_array(); 
                        foreach ($links as $link) {
                    ?>
                        <li><?php echo $link['html']; ?></li>
                    <?php 
                        } 
                    ?>
				</ul>
                <div class="clear"></div>
            </div><!-- wrap -->
        </div><!-- menubar -->
        
        <div class="container">
            
            <div class="branding">
                <h1 class="dib l"><a href="<?php echo Url::base(); ?>home"><img src="<?php echo $image; ?>" alt="KodeLearn | Home" /></a></h1>
                
                <div class="roles dib r">
                    <p id="roleViewToggle">Switch roles <span class="trid">&#x25BC;</span></p>
                    <ul id="roleList" class="smallMenu">
                        <li class="smallText sans"><a href="#" class="role">Manager</a></li>
                        <li class="smallText sans"><a href="#" class="role">Student</a></li>
                    </ul>
                </div><!-- roles -->
                <div class="clear"></div>
            </div><!-- branding -->
            
            <!--<div class="breadcrumbs">
	            <a href="#">Home</a>
	            <span class="sep">&rarr;</span>
	            <a href="#">Crumb 1</a>
	            <span class="sep">&rarr;</span>
	            <a href="#">Crumb 2</a>
            </div>  breadcrumbs -->            
            <?php echo $breadcrumbs; ?>
            
            <div class="clear"></div>
            
<script language="javascript">
    var datetoday = new Date(),
    timenow=datetoday.getTime(),
    thehour = datetoday.getHours();
    if (thehour > 18) display = "Evening";
    else if (thehour >12) display = "Afternoon";
    else display = "Morning";
    var greeting = ("Good " + display + "!");
    $('#greet').html(greeting);
</script>
