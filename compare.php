<?php include 'includes/header.php';
$products=$_SESSION['products'];
$sel=$_POST['sel']??[];
$items=[];
foreach($sel as $i){ $items[]=$products[$i]; }
$name=$_POST['m_name']??'';
$price=floatval($_POST['m_price']??0);
$oz=floatval($_POST['m_oz']??0);
if($name && $price>0 && $oz>0){ $items[]=['name'=>$name,'store'=>'User','price'=>$price,'oz'=>$oz,'cost'=>$price/$oz]; }

usort($items,function($a,$b){return $a['cost']<=>$b['cost'];});
$best=$items[0]['cost']??0;
?>
<div class="row">
<?php foreach($items as $i=>$it): $diff=$it['cost']-$best; ?>
<div class="col-md-4">
<div class="card p-3 mb-3">
<?php if($i==0): ?>
<span class="badge bg-warning">Best Value</span>
<?php else: ?>
<span class="badge bg-danger">+<?=round($diff,3)?> / oz</span>
<?php endif; ?>
<h5><?=$it['name']?></h5>
<p><?=$it['store']?> - <?=$it['price']?> - <?=round($it['cost'],3)?>/oz</p>
</div>
</div>
<?php endforeach; ?>
</div>
<?php include 'includes/footer.php'; ?>