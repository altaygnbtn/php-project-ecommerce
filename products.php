<?php

include 'db.php';

$record = $mysqli->query("SELECT * FROM products");

echo '<h2>Products</h2>';
?>

<?php while ($row = $record->fetch_assoc()): ?>

<div style="border:1px solid #ccc; padding:10px; margin:10px; width=250px; display:inline-block;">
  <img src="<?php echo $row['image']; ?>" width="200" height="200"><br>
  <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
  <?php echo htmlspecialchars($row['description']); ?><br>
  <strong>$<?php echo $row['price']; ?></strong><br>
  <a href="add_to_cart.php?id=<?php echo $row['id']; ?>">Add to Cart</a>

</div>
<?php endwhile ?>

<?php $mysqli->close(); ?>