
<h1>Events for <?php echo $date  ; ?></h1>
<ul>
    <?php if ($day_events) { 
        foreach ($day_events as $event_html) {
            echo $event_html;
        } 
    } else { 
        echo '<li>No events for this day</li>';
    }
    ?>
</ul>

