<?php
include 'db_connect.php'; 

if (!isset($conn)) {
    die("Database connection not established.");
}

$sql = "SELECT id, category, item_name, description, price, image_url FROM menu_items ORDER BY 
        CASE 
            WHEN category = 'Short Orders' THEN 1
            WHEN category = 'Value Meals' THEN 2
            WHEN category = 'Desserts' THEN 3
            WHEN category = 'Bucket' THEN 4
            ELSE 5
        END, item_name";
$result = $conn->query($sql);

$menu = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        if (!isset($menu[$category])) {
            $menu[$category] = [];
        }
        $menu[$category][] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2em;
        }

        .category {
            margin-top: 20px;
            padding: 10px;
            border-bottom: 2px solid #ddd;
            background-color: #d0f0c0;
            border-radius: 5px;
        }

        .category h2 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }

        .item {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            position: relative;
        }

        .item:nth-child(odd) {
            background-color: white;
        }

        .item img {
            max-width: 100px;
            height: auto;
            margin-right: 15px;
            border-radius: 8px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }

        .item p {
            margin: 5px 0;
            color: #666;
        }

        .item .price {
            font-weight: bold;
            color: #000;
        }

        .item input[type="number"] {
            width: 60px;
            margin: 5px 0;
        }

        .add-to-cart-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.5em;
            display: block;
            margin: 20px auto 0;
        }

        .add-to-cart-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Our Menu</h1>
        <form action="cart.php" method="POST">
            <?php foreach (['Short Orders', 'Value Meals', 'Desserts', 'Bucket'] as $category): ?>
                <?php if (isset($menu[$category])): ?>
                    <div class="category">
                        <h2><?php echo htmlspecialchars($category); ?></h2>
                        <?php foreach ($menu[$category] as $item): ?>
                            <div class="item">
                                <?php if (!empty($item['image_url']) && file_exists($item['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>">
                                <?php else: ?>
                                    <img src="images/default.jpg" alt="No image available">
                                <?php endif; ?>
                                <div class="item-details">
                                    <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                    <?php if (!empty($item['description'])): ?>
                                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                                    <?php endif; ?>
                                    <p class="price">₱<?php echo number_format($item['price'], 2); ?></p>
                                    <input type="hidden" name="item_id[]" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="item_name[]" value="<?php echo htmlspecialchars($item['item_name']); ?>">
                                    <input type="hidden" name="item_price[]" value="<?php echo number_format($item['price'], 2); ?>">
                                    <input type="hidden" name="item_description[]" value="<?php echo htmlspecialchars($item['description']); ?>">
                                    <input type="number" name="quantity[]" min="0" value="0">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <input type="submit" name="add_to_cart" class="add-to-cart-btn" value="Check Order">
        </form>
    </div>
</body>
</html>
