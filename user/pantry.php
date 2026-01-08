<?php
include "../config/db.php";
include "../includes/auth.php";

$user_id = $_SESSION['user_id'];

// ADD ITEM
if (isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $category = $_POST['category'];
    $qty = $_POST['quantity'];
    $unit = $_POST['unit'];
    $expiry = $_POST['expiry'];
    $date = date("Y-m-d");

    $sql = "INSERT INTO pantry 
            (user_id, item_name, category, quantity, unit, expiry_date, date_added)
            VALUES 
            ('$user_id', '$name', '$category', '$qty', '$unit', '$expiry', '$date')";

    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pantry</title>
</head>
<body>

<h2>🏠 Pantry Inventory</h2>

<!-- ADD ITEM FORM -->
<form method="POST">
    <input type="text" name="item_name" placeholder="Item Name" required>
    <input type="text" name="category" placeholder="Category (e.g Grain)" required>
    <input type="number" step="0.1" name="quantity" placeholder="Quantity" required>
    <input type="text" name="unit" placeholder="Unit (Kg, Litre)" required>
    <input type="date" name="expiry" required>
    <button name="add_item">Add Item</button>
</form>

<br>

<!-- PANTRY TABLE -->
<table border="1" cellpadding="8">
<tr>
    <th>Item</th>
    <th>Category</th>
    <th>Quantity</th>
    <th>Unit</th>
    <th>Expiry</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM pantry WHERE user_id='$user_id'");

while ($row = mysqli_fetch_assoc($result)) {

    // STATUS LOGIC
    if ($row['quantity'] <= 0) {
        $status = "❌ Out";
    } elseif ($row['quantity'] < 1) {
        $status = "⚠ Low";
    } else {
        $status = "✅ Available";
    }

    echo "<tr>
        <td>{$row['item_name']}</td>
        <td>{$row['category']}</td>
        <td>{$row['quantity']}</td>
        <td>{$row['unit']}</td>
        <td>{$row['expiry_date']}</td>
        <td>$status</td>
        <td>
            <a href='delete_pantry.php?id={$row['pantry_id']}'>Delete</a>
        </td>
    </tr>";
}
?>

</table>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
