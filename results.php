<?php include 'includes/header.php'; include 'includes/functions.php';
$q=strtolower(trim($_POST['search']??''));
$data=json_decode(file_get_contents('backup_data.json'),true);
$items=$data['items'];
$filtered=[];
$words=explode(' ',$q);
foreach($items as $item){
 $title=strtolower($item['title']);
 $cat=strtolower($item['category']);
 $match=false;
 foreach($words as $w){ if($w!='' && (strpos($title,$w)!==false||strpos($cat,$w)!==false)){ $match=true; break;} }
 if($match) $filtered[]=$item;
}
if(count($filtered)==0) $filtered=$items;
$rows=[];
foreach($filtered as $item){
 foreach($item['offers'] as $offer){
  $oz=getOunces($item['title']);
  $price=$offer['price'];
  $rows[]=['name'=>$item['title'],'store'=>$offer['merchant'],'price'=>$price,'oz'=>$oz,'cost'=>$oz>0?$price/$oz:999];
 }
}
usort($rows,function($a,$b){return $a['cost']<=>$b['cost'];});
$_SESSION['products']=$rows;
?>
<form method="POST" action="compare.php">
<div class="row">
<?php foreach($rows as $i=>$r): ?>
<div class="col-md-4">
<div class="card p-3 mb-3">
<input type="checkbox" name="sel[]" value="<?=$i?>">
<h5><?=safe($r['name'])?></h5>
<p><?=safe($r['store'])?><br>$<?=$r['price']?> - <?=round($r['cost'],3)?>/oz</p>
</div>
</div>
<?php endforeach; ?>
</div>
<h4>Manual Item</h4>
<label>Product Name</label>
<input name="m_name" class="form-control mb-1">
<label>Price ($)</label>
<input name="m_price" class="form-control mb-1">
<label>Total Ounces</label>
<input name="m_oz" class="form-control mb-1">
<button class="btn btn-warning">Compare</button>
</form>
<?php include 'includes/footer.php'; ?>