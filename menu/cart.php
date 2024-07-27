<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $item_ids = $_POST['item_id'];
    $item_names = $_POST['item_name'];
    $item_prices = $_POST['item_price'];
    $item_descriptions = $_POST['item_description'];
    $quantities = $_POST['quantity'];
    
    $_SESSION['cart'] = [];

    foreach ($item_ids as $index => $id) {
        $quantity = intval($quantities[$index]);
        if ($quantity > 0) { 
            $_SESSION['cart'][] = [
                'id' => $id,
                'name' => $item_names[$index],
                'price' => $item_prices[$index],
                'description' => $item_descriptions[$index],
                'quantity' => $quantity
            ];
        }
    }
}

if (isset($_POST['update_cart'])) {
    $quantities = $_POST['quantity'];
    foreach ($_SESSION['cart'] as $index => $item) {
        $quantity = intval($quantities[$index]);
        if ($quantity > 0) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$index]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

if (isset($_POST['remove_item'])) {
    $remove_index = $_POST['remove_index'];
    unset($_SESSION['cart'][$remove_index]);

    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$cart_items_with_images = [];
foreach ($cart_items as $item) {
    $stmt = $conn->prepare("SELECT image_url FROM menu_items WHERE id = ?");
    $stmt->bind_param("i", $item['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();
    $item['image_url'] = $image['image_url'];
    $cart_items_with_images[] = $item;
}
$conn->close();

$total_amount = 0;
foreach ($cart_items_with_images as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
            border-radius: 8px;
        }
        .remove-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .remove-button:hover {
            background-color: #c82333;
        }
        .update-button, .checkout-button {
            background-color: green;
            color: white;
            border: none;
            padding: 20px 30px;
            cursor: pointer;
            border-radius: 5px;
        }
        .update-button:hover, .checkout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <form action="cart.php" method="POST">
            <?php if (!empty($cart_items_with_images)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items_with_images as $index => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td>₱<?php echo number_format($item['price'], 2); ?></td>
                                <td><input type="number" name="quantity[]" min="0" value="<?php echo htmlspecialchars($item['quantity']); ?>"></td>
                                <td>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="submit" name="remove_item" value="Remove" class="remove-button" onclick="document.getElementById('remove_index').value = '<?php echo $index; ?>';">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong></strong></td>
                            <td><strong>₱<?php echo number_format($total_amount, 2); ?></strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="remove_index" id="remove_index" value="">
                <button type="submit" name="update_cart" class="update-button">Update Cart</button>
                <button type="submit" formaction="checkout.php" formmethod="POST" class="checkout-button">Checkout</button>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
