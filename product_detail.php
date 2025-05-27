<?php
require_once 'admin/db.php';
require 'header.php';
?>

<?php


//inserting reviews into the database
if ( isset($_POST['submit_review']) && isset($_SESSION['user_id'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        $review = $mysqli->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)"); //prepared statements
        $review->bind_param("iiis", $product_id, $user_id, $rating, $comment);
        $review->execute();
       
        header("Location: product_detail.php?id=$product_id"); //prevent resubmission by rendering the page
        exit;
    }
}

//displaying the product details

$product_id = $_GET['id'];

$result = $mysqli->query("SELECT * FROM products WHERE id = $product_id");

if ($result) {
    $product = $result->fetch_assoc();
    ?>
    <div style="max-width: 500px; margin: 40px auto; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 2px 8px #eee; padding: 30px; background: #fafbfc;">
        <h2 style="text-align:center; color:#2196F3;"><?php echo ($product['name']); ?></h2>
        <div style="text-align:center;">
            <img src="<?php echo 'admin/' . $product['image']; ?>" width="300" style="border-radius:8px; box-shadow:0 1px 4px #ccc;">
        </div>
        <p style="margin-top:20px;"><?php echo ($product['description']); ?></p>
        <div style="margin: 18px 0;">
            <strong style="font-size:18px;">Price: <span style="color:#388e3c;">$<?php echo $product['price']; ?></span></strong><br>
            <strong>Stock: <?php echo $product['stock']; ?></strong>
        </div>
        <br>
        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') : ?>
            <strong>Select quantity</strong>
            <form method="POST" action="cart.php?action=add&id=<?php echo $product['id']; ?>" style="margin:10px 0;">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width:60px; padding:5px;">
                <input type="submit" value="Add to Cart" style="padding:8px 18px; background:#2196F3; color:white; border:none; border-radius:5px; cursor:pointer;">
            </form>
            <?php if (isset($_SESSION['user_id'])): ?>

    <h3>Leave a Review</h3>
    <!-- review form -->
    <form method="post" action="product_detail.php?id=<?php echo $product['id']; ?>">
        Rating:
        <select name="rating" required>
            <option value="">Select</option>
            <?php for ($i=1; $i<=5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <br>
        Comment:<br>
        <textarea name="comment" required></textarea><br>
        <button type="submit" name="submit_review">Submit Review</button>
    </form>
<?php else: ?>
    <p><a href="admin/login.php">Login</a> to leave a review.</p>
<?php endif; ?>

<h3>Reviews</h3>

<?php
//displaying reviews
$reviews = $mysqli->query("SELECT r.rating, r.comment, r.created_at, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = $product_id ORDER BY r.created_at DESC");
if ($reviews->num_rows > 0):
    while ($rev = $reviews->fetch_assoc()):
?>
    <div style="border-bottom:1px solid #ccc; margin-bottom:10px;">
        <strong><?php echo htmlspecialchars($rev['username']); ?></strong>
        - Rating: <?php echo $rev['rating']; ?>/5
        <br>
        <?php echo nl2br(htmlspecialchars($rev['comment'])); ?>
        <br>
        <small><?php echo $rev['created_at']; ?></small>
    </div>
<?php endwhile; else: ?>
    <p>No reviews yet.</p>
<?php endif; ?>
            <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" style="color:#2196F3; text-decoration:underline;">Quick Add to Cart</a>
            <br>
        <?php endif; ?>
        <br>
        <a href="store.php" style="display:inline-block; margin-top:10px; color:#555; text-decoration:none;"> Back to Store</a>
    </div>
    <?php
} else {
    echo "<div style='text-align:center; margin-top:40px; color:#c00;'>Product not found.</div>";
}
$mysqli->close();
?>