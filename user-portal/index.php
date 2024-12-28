<?php
require_once 'includes/template.php';
require_once 'includes/db_functions.php';

function render_header($title) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>$title</title>
        <!-- Add other head elements here -->
    </head>
    <body>";
}

function render_footer() {
    echo "</body></html>";
}

render_header("Our Products");
?>

<div class="products-container">
    <?php
    // Fetch products from database
    $stmt = $db->query("SELECT * FROM products WHERE active = 1 ORDER BY price ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($products as $product): ?>
        <div class="product-card">
            <?php if (!empty($product['image'])): ?>
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            <?php endif; ?>
            
            <div class="product-details">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                
                <div class="product-features">
                    <?php 
                    $features = json_decode($product['features'], true);
                    if (is_array($features)): ?>
                        <ul>
                            <?php foreach ($features as $feature): ?>
                                <li><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <a href="checkout.php?product_id=<?php echo $product['id']; ?>" 
                   class="button get-started-btn">
                    Get Started
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php render_footer(); ?> 