<?php
require 'maketheInventoryinbackend.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Inventory</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #FFC0CB;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1> Inventory List</h1>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Expiry Date</th>
            <th>Category</th>
            <th>Storage Type</th>
        </tr>
        <?php foreach ($inventory as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['p.item_name']) ?></td>
                <td><?= htmlspecialchars($item['expiry_date']) ?></td>
                <td><?= htmlspecialchars($item['c.category_name']) ?></td>
                <td><?= htmlspecialchars($item['s.storage_type_name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>