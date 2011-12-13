<?php
foreach ($menu as $k=>$item) {
    echo HTML::anchor($item[0],$item[1], $item[2]);
}

