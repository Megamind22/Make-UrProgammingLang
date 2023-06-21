
<?php 

require __DIR__ . '/parsserver.php';
require __DIR__ . '/scanner_.php';


$text=$_POST['name1'];
#$text="@ Type ID { If ( ID > ID ) { } } # %";
$result=runScanner($text);

$valueTokens=$result[1];
$valueErr=$result[0];
$totalErr=$result[2];




$parsText=array("","");
foreach ($valueTokens as $vs ) {
   
    if ($vs->value == "ID" || $vs->value == "NUMBER" || $vs->value =="COMMENT"){
        $parsText[0].=$vs->value;
        $parsText[1].=$vs->line;
    }else{
     $parsText[0].=$vs->type;
     $parsText[1].=$vs->line;
    }
    $parsText[0].=" ";
    $parsText[1].=" ";
    
}
$sr=$parsText[0]." "."%";
echo $sr;

$result2 =runPasrer($sr,$parsText[1]);

echo "<br>";
$sm=array();
array_push($sm,"1");
$s=$result2[0][0];


$arrline=array();
for ($i=0; $i <count($result2) ; $i++) {
    $arr=explode(" ", $result2[$i]);
    $arrline[]=$arr[0];
}

for ($i=0; $i <count($arrline) ; $i++) {//linesNo

    if ($arrline[$i] >$s){
        $s = $arrline[$i];
        echo $arrline[$i];
        array_push($sm,$arrline[$i]);
        //echo $result2[$i][0];
    }       
    
}



$countUnMatch=0;

//echo $parsText[1] ;
//print_r($arrline);

for ($i=0; $i < count($sm) ; $i++) {
    $bool=true;
    $rule =""; 
    for ($j=0; $j <  count($result2); $j++) {

        if ($result2[$j][0]==$sm[$i]){
            $rule .= substr($result2[$j],5,3)." ";
            if ($result2[$j][2]=="U"){
                $bool=false;
            }
        } 
        }
    if ($bool){
            echo "Line $sm[$i]: match "."  "."Rule : $rule";

    }else{
            echo "Line $sm[$i]: Notmatch";
            $countUnMatch++;
        } 
    echo "<br>";
        
}

echo "Total No Of Error : $countUnMatch";
    



 ?>
