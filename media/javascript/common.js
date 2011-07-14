$(document).ready(function(){
	
    // Confirm Delete
    $('form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('Delete cannot be undone! Are you sure you want to do this?')) {
                return false;
            }
        }
    });
    
});