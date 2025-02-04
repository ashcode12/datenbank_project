<?php
// Include the database connection
include("db_connect.php");

// Initialize variables for shopping list data
$errors = [];
$success_message = "";

// Handle Create/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_shopping_list'])) {
        // Add a new shopping list
        $benutzer_id = $_POST['benutzer_id'] ?? null;

        if (empty($benutzer_id)) {
            $errors[] = "User is required!";
        } else {
            $sql = "INSERT INTO Einkaufslisten (benutzer_id) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $benutzer_id);
            if ($stmt->execute()) {
                $success_message = "Shopping list added successfully!";
            } else {
                $errors[] = "Error adding shopping list: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_shopping_list'])) {
        // Delete a shopping list
        $id = $_POST['id'];

        $sql = "DELETE FROM Einkaufslisten WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Shopping list deleted successfully!";
        } else {
            $errors[] = "Error deleting shopping list: " . $conn->error;
        }
    }
}

// Fetch all shopping lists
$sql = "SELECT el.id, b.name AS user, el.erstellt_am
        FROM Einkaufslisten el
        JOIN Benutzer b ON el.benutzer_id = b.id";
$result = $conn->query($sql);
$shopping_lists = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all users for dropdown
$sql = "SELECT id, name FROM Benutzer";
$users_result = $conn->query($sql);
$users = $users_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einkaufslistenverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Einkaufslistenverwaltung</h1>

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

    <!-- Add Shopping List Form -->
    <form method="post" class="mb-4">
        <h2>Add Shopping List</h2>
        <div class="mb-3">
            <label for="benutzer_id" class="form-label">User</label>
            <select name="benutzer_id" id="benutzer_id" class="form-control" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="add_shopping_list" class="btn btn-primary">Add Shopping List</button>
    </form>

    <!-- Shopping Lists Table -->
    <h2>Shopping Lists</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shopping_lists as $list): ?>
                <tr>
                    <td><?= htmlspecialchars($list['id']); ?></td>
                    <td><?= htmlspecialchars($list['user']); ?></td>
                    <td><?= htmlspecialchars($list['erstellt_am']); ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $list['id']; ?>">
                            <button type="submit" name="delete_shopping_list" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
