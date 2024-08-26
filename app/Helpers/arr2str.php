<?php



namespace App\Helpers;
function arr2str(array $array):string{
    $separator = ',';
    $string = "";
    if(is_null($array) or empty($array)) return $string;

    foreach ($array as $k=>$v){
        $string .= $v.$separator;
    }
    return "'".rtrim($string,$separator)."'";
}
