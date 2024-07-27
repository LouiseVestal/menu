<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error_message = "Invalid request: The request method is not POST.";
} elseif (empty($_SESSION['cart'])) {
    $error_message = "Invalid request: The cart is empty.";
} else {
    $order_items = $_SESSION['cart'];
    $total_amount = 0;

    foreach ($order_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    $stmt = $conn->prepare("INSERT INTO orders (total_amount) VALUES (?)");
    $stmt->bind_param("d", $total_amount);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity) VALUES (?, ?, ?)");
        foreach ($order_items as $item) {
            $stmt->bind_param("iii", $order_id, $item['id'], $item['quantity']);
            $stmt->execute();
        }
        $stmt->close();

        unset($_SESSION['cart']);
        $success_message = "Thank you for your order! Your order ID is $order_id.";
    } else {
        $error_message = "Failed to place order. Please try again.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
            text-align: center;
        }
        .message {
            margin: 20px 0;
            font-size: 1.2em;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .order-summary {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
            <div class="order-summary">
                <h2>Order Summary</h2>
                <p>Order ID: <?php echo htmlspecialchars($order_id); ?></p>
                <p>Total Amount: ₱<?php echo number_format($total_amount, 2); ?></p>
                <h3>Items</h3>
                <ul>
                    <?php foreach ($order_items as $item): ?>
                        <li><?php echo htmlspecialchars($item['name']); ?> (<?php echo htmlspecialchars($item['quantity']); ?> x ₱<?php echo number_format($item['price'], 2); ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif (isset($error_message)): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php else: ?>
            <p class="message error">There was an error processing your request.</p>
        <?php endif; ?>
    </div>
</body>
</html>
