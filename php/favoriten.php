<?php
// Include the database connection
include("db_connect.php");

// Initialize variables
$errors = [];
$success_message = "";

// Handle Create/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_favorite'])) {
        // Add a recipe to the user's favorites
        $benutzer_id = $_POST['benutzer_id'] ?? null;
        $rezept_id = $_POST['rezept_id'] ?? null;

        if (empty($benutzer_id) || empty($rezept_id)) {
            $errors[] = "User and Recipe are required!";
        } else {
            $sql = "INSERT INTO Favoriten (benutzer_id, rezept_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $benutzer_id, $rezept_id);
            if ($stmt->execute()) {
                $success_message = "Recipe added to favorites successfully!";
            } else {
                $errors[] = "Error adding favorite: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_favorite'])) {
        // Remove a recipe from the user's favorites
        $id = $_POST['id'];

        $sql = "DELETE FROM Favoriten WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Favorite removed successfully!";
        } else {
            $errors[] = "Error removing favorite: " . $conn->error;
        }
    }
}

// Fetch all favorites
$sql = "SELECT f.id, b.name AS user, r.name AS recipe
        FROM Favoriten f
        JOIN Benutzer b ON f.benutzer_id = b.id
        JOIN Rezepte r ON f.rezept_id = r.id";
$result = $conn->query($sql);
$favorites = $result->fetch_all(MYSQLI_ASSOC);

// Fetch users and recipes for dropdowns
$sql = "SELECT id, name FROM Benutzer";
$users_result = $conn->query($sql);
$users = $users_result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT id, name FROM Rezepte";
$recipes_result = $conn->query($sql);
$recipes = $recipes_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritenverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Favoritenverwaltung</h1>

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

    <!-- Add Favorite Form -->
    <form method="post" class="mb-4">
        <h2>Add Favorite</h2>
        <div class="mb-3">
            <label for="benutzer_id" class="form-label">User</label>
            <select name="benutzer_id" id="benutzer_id" class="form-control" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="rezept_id" class="form-label">Recipe</label>
            <select name="rezept_id" id="rezept_id" class="form-control" required>
                <option value="">Select Recipe</option>
                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?= $recipe['id']; ?>"><?= htmlspecialchars($recipe['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="add_favorite" class="btn btn-primary">Add Favorite</button>
    </form>

    <!-- Favorites Table -->
    <h2>Favorites</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Recipe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($favorites as $favorite): ?>
                <tr>
                    <td><?= htmlspecialchars($favorite['id']); ?></td>
                    <td><?= htmlspecialchars($favorite['user']); ?></td>
                    <td><?= htmlspecialchars($favorite['recipe']); ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $favorite['id']; ?>">
                            <button type="submit" name="delete_favorite" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
