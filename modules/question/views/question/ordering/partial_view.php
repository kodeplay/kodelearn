<p class="question-help">Drag items to arrange in the correct answer.</p>
<ul class="items-ordering-section">
    <?php foreach ($items as $item) { ?>
        <li><?php echo $item; ?></li>    
    <?php } ?>
</ul>
<script type="text/javascript">
    $(".items-ordering-section").sortable();
</script>
