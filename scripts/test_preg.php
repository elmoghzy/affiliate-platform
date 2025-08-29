<?php
$pattern = '/^(?:\\+?20)?0?1[0125]\\d{8}$/';
$numbers = ['+201001234567','201001234567','01001234567','01123456789','+201112345678'];
foreach($numbers as $n){
    echo $n . ' => ' . (preg_match($pattern, $n) ? 'match' : 'no') . PHP_EOL;
}
