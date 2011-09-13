    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
    <br/><br/>
        Enter Access Code: <input type="text" id="access_code" /> <a href="#" id="view_course" class="button">View Course</a>
        <br/><br/><br/>
        <div id="course_info"></div>
    </div>
    <div class="clear"></div>
<script type="text/javascript" ><!--
KODELEARN.modules.add('join_course' , (function () {    
    
    return {
        init: function () { 
           $('#view_course').click(function() {
               accessCode = $('#access_code').val();
               if(accessCode){
	        	   $.post(KODELEARN.config.base_url + "course/course_detail", { "access_code": accessCode },
	        			   function(data){
	        		   		   $('#course_info').html(data.response);
	        			   }, "json");
	
	           } else {
	               $('#course_info').text('Please enter access code.');
	           }
           });

           $('#join_course').live('click', function() {
               accessCode = $('#access_code').val();
               if(accessCode){
                   $.post(KODELEARN.config.base_url + "course/join", { "access_code": accessCode },
                           function(data){
                       $('#course_info').html(data.response);
                           }, "json");
    
               } else {
                   $('#course_info').text('Please enter access code.');
               }
           });
        }
    }; 
})());

//--></script>    