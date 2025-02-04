<?php

include("db_connect.php");

// Initialize variables for user data
$errors = [];
$success_message = "";

// Handle Create/Update/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_user'])) {
        // Add a new user
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';

        if (empty($name) || empty($email)) {
            $errors[] = "Name and Email are required!";
        } else {
            $sql = "INSERT INTO Benutzer (name, email) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $name, $email);
            if ($stmt->execute()) {
                $success_message = "User added successfully!";
            } else {
                $errors[] = "Error adding user: " . $conn->error;
            }
        }
    } elseif (isset($_POST['edit_user'])) {
        // Edit an existing user
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        if (empty($name) || empty($email)) {
            $errors[] = "Name and Email are required!";
        } else {
            $sql = "UPDATE Benutzer SET name = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $email, $id);
            if ($stmt->execute()) {
                $success_message = "User updated successfully!";
            } else {
                $errors[] = "Error updating user: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_user'])) {
        // Delete a user
        $id = $_POST['id'];

        $sql = "DELETE FROM Benutzer WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "User deleted successfully!";
        } else {
            $errors[] = "Error deleting user: " . $conn->error;
        }
    }
}

// Fetch all users
$sql = "SELECT * FROM Benutzer";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Benutzerverwaltung</h1>

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

    <!-- Add User Form -->
    <form method="post" class="mb-4">
        <h2>Add User</h2>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
    </form>

    <!-- User Table -->
    <h2>Users</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['erstellt_am']); ?></td>
                    <td>
                        <!-- Edit Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                            <button type="submit" name="edit_user" class="btn btn-warning btn-sm">Edit</button>
                        </form>

                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
