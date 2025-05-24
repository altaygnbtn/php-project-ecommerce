<?php
session_start();
if(!isset($_SESSION['user_id'])){header('Location: login.php');exit;}
require_once __DIR__.'/admin/db.php';
$user_id=$_SESSION['user_id'];
$stmt=$mysqli->prepare('SELECT o.id,o.total,o.created_at,oi.quantity,oi.price,p.name FROM orders o JOIN order_items oi ON o.id=oi.order_id JOIN products p ON oi.product_id=p.id WHERE o.user_id=? ORDER BY o.created_at DESC');
$stmt->bind_param('i',$user_id);
$stmt->execute();
$res=$stmt->get_result();
$orders=[];
while($r=$res->fetch_assoc()){
    $id=$r['id'];
    $orders[$id]['total']=$r['total'];
    $orders[$id]['created']=$r['created_at'];
    $orders[$id]['items'][]=['name'=>$r['name'],'qty'=>$r['quantity'],'price'=>$r['price']];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order History</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,Helvetica,sans-serif;background:#f2f6fa;padding:40px}
h1{text-align:center;margin-bottom:30px;color:#333}
.order{background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.08);margin-bottom:28px;padding:24px}
.order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;font-weight:600;color:#555}
.order-table{width:100%;border-collapse:collapse}
.order-table th,.order-table td{padding:10px 12px;text-align:left}
.order-table th{background:#f7f9fc;color:#666;font-size:14px}
.order-table tr:nth-child(even){background:#fafbfe}
.total{margin-top:12px;font-weight:700;color:#222;text-align:right}
</style>
</head>
<body>
<h1>Your Orders</h1>
<?php if(!$orders){echo'<p style="text-align:center;color:#666">No orders yet.</p>';} ?>
<?php foreach($orders as $id=>$o):?>
<div class="order">
<div class="order-header">
<span>Order #<?=htmlspecialchars($id)?></span>
<span><?=htmlspecialchars($o['created'])?></span>
</div>
<table class="order-table">
<thead>
<tr><th>Product</th><th>Quantity</th><th>Price</th></tr>
</thead>
<tbody>
<?php foreach($o['items'] as $it):?>
<tr>
<td><?=htmlspecialchars($it['name'])?></td>
<td><?=htmlspecialchars($it['qty'])?></td>
<td>$<?=number_format($it['price'],2)?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<div class="total">Total: $<?=number_format($o['total'],2)?></div>
</div>
<?php endforeach;?>
</body>
</html>
