<?php

    $main_test=array();
    $row_test=array();
    $rows=3;
    $rindex=0;
    $cols=4;
    $cindex=0;
    while($rindex<$rows){
        
        if($rindex==0){
            $rowvalue="zero";
        }elseif($rindex==1){
            $rowvalue="first";
        }else{
            $rowvalue="last";
        }
        while($cindex<$cols){
            array_push($row_test,$rowvalue);
            $cindex++;
        }
        array_push($main_test,$row_test);
        $rindex++;
        $cindex=0;
        $row_test=array();
    }
//print_r($main_test);
$rindex=0;
$cindex=0;
while($rindex<$rows){
        while($cindex<$cols){
            echo $main_test[$rindex][$cindex]."<br>";
            $cindex++;
        }
        $rindex++;
    $cindex=0;
    }
echo count($main_test[0]);

?>