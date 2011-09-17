<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60"><?php echo $page_title; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar bm10">
    	<?php echo HTML::anchor('document/upload', 'Upload', array('class' => 'button round5')); ?>            
        <span class="clear">&nbsp;</span>
    </div><!-- topbar -->    
    
    
    <!-- NKHL -->
    <?php /*?>
    <?php for($catCount=0; $catCount < 3; $catCount++) { ?>
    <p class="catName">Document Category <?php echo $catCount; ?></p>
    */?>
    <ul class="lsNone documentsContainer">
    	<?php foreach($documents as $document){ ?>
    		<li class="l oneDoc">
    			<div class="prel docWrapper">
	    			<input type="checkbox" />
	    			<div class="docMeta tac pabs">
	    				<p class="bold"><?php echo $document->toLink() ?></p>
	    				<p class="tm5 h6">Uploaded by <?php echo $document->user(); ?> on <?php echo $document->time(); ?></p>
	    			</div>
	    		</div>
    		</li>
    	<?php }?>
    	<li class="clear">&nbsp;</li>
    </ul>
    <?php //} //catCount ?>
    
    <!-- NKHL -->
    
    <div class="hidden OLDCODE">
    	<ul class="documents vm10">
    		
    		<?php foreach($documents as $document){ ?>
    			<li><input type="checkbox" /><?php echo $document->toLink() ?></li>
    		<?php }?>
    		
    		<li class="heading">Physics Documents</li>
    		<li> <input type="checkbox" /> GitTdo </li>
    		<li> <input type="checkbox" /> GitTdo </li>
    		
    		<li class="heading">Global Documents</li>
    		<li> <input type="checkbox" /> GitTdo </li>
    		<li> <input type="checkbox" /> GitTdo </li>
    	</ul>
    </div>
       
</div>
<div class="clear"></div>
    
