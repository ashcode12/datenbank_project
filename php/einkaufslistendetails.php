<?php
// Include the database connection
include("db_connect.php");

// Initialize variables
$errors = [];
$success_message = "";

// Handle Create/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_item'])) {
        // Add an item to the shopping list
        $einkaufsliste_id = $_POST['einkaufsliste_id'] ?? null;
        $zutat_id = $_POST['zutat_id'] ?? null;
        $menge = $_POST['menge'] ?? '';

        if (empty($einkaufsliste_id) || empty($zutat_id) || empty($menge)) {
            $errors[] = "Shopping List, Ingredient, and Quantity are required!";
        } else {
            $sql = "INSERT INTO EinkaufslistenDetails (einkaufsliste_id, zutat_id, menge) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $einkaufsliste_id, $zutat_id, $menge);
            if ($stmt->execute()) {
                $success_message = "Item added to shopping list successfully!";
            } else {
                $errors[] = "Error adding item: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_item'])) {
        // Delete an item from the shopping list
        $id = $_POST['id'];

        $sql = "DELETE FROM EinkaufslistenDetails WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Item removed successfully!";
        } else {
            $errors[] = "Error removing item: " . $conn->error;
        }
    }
}

// Fetch all shopping list details
$sql = "SELECT ed.id, el.id AS shopping_list_id, z.name AS ingredient, ed.menge
        FROM EinkaufslistenDetails ed
        JOIN Einkaufslisten el ON ed.einkaufsliste_id = el.id
        JOIN Zutaten z ON ed.zutat_id = z.id";
$result = $conn->query($sql);
$list_details = $result->fetch_all(MYSQLI_ASSOC);

// Fetch shopping lists and ingredients for dropdowns
$sql = "SELECT id FROM Einkaufslisten";
$shopping_lists_result = $conn->query($sql);
$shopping_lists = $shopping_lists_result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT id, name FROM Zutaten";
$ingredients_result = $conn->query($sql);
$ingredients = $ingredients_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einkaufslistendetailsverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Einkaufslistendetailsverwaltung</h1>

    <!-- Success and Error Messages -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?= $success_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Add Item Form -->
    <form method="post" class="mb-4">
        <h2>Add Item to Shopping List</h2>
        <div class="mb-3">
            <label for="einkaufsliste_id" class="form-label">Shopping List</label>
            <select name="einkaufsliste_id" id="einkaufsliste_id" class="form-control" required>
                <option value="">Select Shopping List</option>
                <?php foreach ($shopping_lists as $list): ?>
                    <option value="<?= $list['id']; ?>">List #<?= $list['id']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="zutat_id" class="form-label">Ingredient</label>
            <select name="zutat_id" id="zutat_id" class="form-control" required>
                <option value="">Select Ingredient</option>
                <?php foreach ($ingredients as $ingredient): ?>
                    <option value="<?= $ingredient['id']; ?>"><?= htmlspecialchars($ingredient['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="menge" class="form-label">Quantity</label>
            <input type="text" name="menge" id="menge" class="form-control" required>
        </div>
        <button type="submit" name="add_item" class="btn btn-primary">Add Item</button>
    </form>

    <!-- Shopping List Details Table -->
    <h2>Shopping List Details</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Shopping List</th>
                <th>Ingredient</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_details as $detail): ?>
                <tr>
                    <td><?= htmlspecialchars($detail['id']); ?></td>
                    <td><?= htmlspecialchars($detail['shopping_list_id']); ?></td>
                    <td><?= htmlspecialchars($detail['ingredient']); ?></td>
                    <td><?= htmlspecialchars($detail['menge']); ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $detail['id']; ?>">
                            <button type="submit" name="delete_item" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
