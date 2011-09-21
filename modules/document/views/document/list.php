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
    <div class="vm5" align="right">
            <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
              <option value="filter_title">Title</option>
              <option value="filter_by">Uploaded By</option>
            </select>
            <input type="text" name="filter" id="filter" value="<?php echo $filter['text']; ?>" style="padding:5px" />
            <a class="button" id="trigger_filter" href="#">Find</a>
            <input type="hidden" id="filter_url" value="<?php echo $filter['url'] ?>" />
            <input type="hidden" id="select_val" value="<?php echo $filter['select'] ?>" />
        </div>    
    
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
    
