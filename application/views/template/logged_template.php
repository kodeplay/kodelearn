<?php require 'header.php'?>
<?php require 'sidebar.php'?>
<?php echo View::factory('template/content')->set('content', $content) ?>
<?php require 'footer.php'?>