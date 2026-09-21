<?php
$numero = 1;

while ($numero <= 20) {
    if ($numero % 2 == 0) {
        echo "O número $numero é Par<br>";
    } else {
        echo "O número $numero é Ímpar<br>";
    }
    
    $numero++;
}
?>