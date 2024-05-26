<?php

echo "<ol>";
foreach ($_SERVER as $k => $v)
    echo "<li>'" . $k . "' = " . $v . "</li>";
echo "</ol>";