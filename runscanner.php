<?php

require __DIR__ . '/scanner_.php';
require __DIR__ . '/parsserver.php';


$text=$_POST['name1'];

$result=runScanner($text);

$valueTokens=$result[1];
$valueErr=$result[0];
$totalErr=$result[2];

foreach ($valueErr as  $ve) {
    echo $ve->as_string();
    echo"<br>";
}
foreach ($valueTokens as $vs ) {
    echo $vs->to_string();
    echo"<br>";
}
echo "Total NO of errors: $totalErr"."\n";



?>