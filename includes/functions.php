<?php
function safe($v){return htmlspecialchars($v,ENT_QUOTES,'UTF-8');}
function getOunces($t){
 if(preg_match('/(\d+(\.\d+)?)\s*(fl\s*oz|oz)/i',$t,$m)) return floatval($m[1]);
 return 0;
}
?>