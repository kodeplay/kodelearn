<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60"><?php echo $page_title; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar bm10 hgtfix vpad5">
    	<?php echo HTML::anchor('document/upload', 'Upload', array('class' => 'dib button round5')); ?>            
        <span class="clear">&nbsp;</span>
    </div><!-- topbar -->    
    
    
    <ul class="lsNone documentsContainer">
    	<?php foreach($documents as $document){ ?>
    	<?php //for($i=0; $i < 10; $i++) {?>
    		<li id="doc<?php echo $document->id ?>" class="l oneDoc <?php echo $document->extension() . 'Doc' ?>">
    			<div class="prel docWrapper hlcontainer">
    				<p class="hoverLinks"><?php echo $document->editLink() ?> <?php echo $document->deleteLink() ?></p>
	    			<div class="docMeta tac pabs">
	    				<p class="bold"><?php echo $document->toLink() ?></p>
	    				<p class="tm5 h6">Uploaded by <?php echo $document->user(); ?> on <?php echo $document->time(); ?></p>
	    			</div>
	    		</div>
    		</li>
    		<?php }?>
    	<?php //}?>
    	<li class="clear">&nbsp;</li>
    </ul>
    
</div>
<div id="edit_document"></div>
<div class="clear"></div>
    
