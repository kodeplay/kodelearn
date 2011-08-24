<?php require 'header.php'?>
<?php require 'sidebar.php'?>
<div id="middle-content">
<?php echo View::factory('template/content')->set('content', $content) ?>
</div>
<?php require 'footer.php'?>