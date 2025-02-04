<?php
// Include the database connection
include("db_connect.php");

// Initialize variables for recipe data
$errors = [];
$success_message = "";

// Handle Create/Update/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_recipe'])) {
        // Add a new recipe
        $name = $_POST['name'] ?? '';
        $kategorie_id = $_POST['kategorie_id'] ?? null;
        $zubereitungszeit = $_POST['zubereitungszeit'] ?? null;
        $anleitung = $_POST['anleitung'] ?? '';

        if (empty($name) || empty($anleitung) || empty($kategorie_id)) {
            $errors[] = "Name, Category, and Instructions are required!";
        } else {
            $sql = "INSERT INTO Rezepte (name, kategorie_id, zubereitungszeit, anleitung) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siis", $name, $kategorie_id, $zubereitungszeit, $anleitung);
            if ($stmt->execute()) {
                $success_message = "Recipe added successfully!";
            } else {
                $errors[] = "Error adding recipe: " . $conn->error;
            }
        }
    } elseif (isset($_POST['edit_recipe'])) {
        // Edit an existing recipe
        $id = $_POST['id'];
        $name = $_POST['name'];
        $kategorie_id = $_POST['kategorie_id'];
        $zubereitungszeit = $_POST['zubereitungszeit'];
        $anleitung = $_POST['anleitung'];

        if (empty($name) || empty($anleitung) || empty($kategorie_id)) {
            $errors[] = "Name, Category, and Instructions are required!";
        } else {
            $sql = "UPDATE Rezepte SET name = ?, kategorie_id = ?, zubereitungszeit = ?, anleitung = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siisi", $name, $kategorie_id, $zubereitungszeit, $anleitung, $id);
            if ($stmt->execute()) {
                $success_message = "Recipe updated successfully!";
            } else {
                $errors[] = "Error updating recipe: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_recipe'])) {
        // Delete a recipe
        $id = $_POST['id'];

        $sql = "DELETE FROM Rezepte WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Recipe deleted successfully!";
        } else {
            $errors[] = "Error deleting recipe: " . $conn->error;
        }
    }
}

// Fetch all recipes
$sql = "SELECT r.*, k.name AS category_name FROM Rezepte r LEFT JOIN Kategorien k ON r.kategorie_id = k.id";
$result = $conn->query($sql);
$recipes = $result->fetch_all(MYSQLI_ASSOC);

// Fetch categories for dropdown
$sql = "SELECT * FROM Kategorien";
$categories_result = $conn->query($sql);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezeptverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Rezeptverwaltung</h1>

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

    <!-- Add Recipe Form -->
    <form method="post" class="mb-4">
        <h2>Add Recipe</h2>
        <div class="mb-3">
            <label for="name" class="form-label">Recipe Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kategorie_id" class="form-label">Category</label>
            <select name="kategorie_id" id="kategorie_id" class="form-control" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="zubereitungszeit" class="form-label">Preparation Time (minutes)</label>
            <input type="number" name="zubereitungszeit" id="zubereitungszeit" class="form-control">
        </div>
        <div class="mb-3">
            <label for="anleitung" class="form-label">Instructions</label>
            <textarea name="anleitung" id="anleitung" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_recipe" class="btn btn-primary">Add Recipe</button>
    </form>

    <!-- Recipe Table -->
    <h2>Recipes</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Prep Time</th>
                <th>Instructions</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?= htmlspecialchars($recipe['id']); ?></td>
                    <td><?= htmlspecialchars($recipe['name']); ?></td>
                    <td><?= htmlspecialchars($recipe['category_name']); ?></td>
                    <td><?= htmlspecialchars($recipe['zubereitungszeit']); ?></td>
                    <td><?= htmlspecialchars($recipe['anleitung']); ?></td>
                    <td><?= htmlspecialchars($recipe['erstellt_am']); ?></td>
                    <td>
                        <!-- Edit Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $recipe['id']; ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($recipe['name']); ?>" required>
                            <input type="number" name="zubereitungszeit" value="<?= htmlspecialchars($recipe['zubereitungszeit']); ?>">
                            <textarea name="anleitung" required><?= htmlspecialchars($recipe['anleitung']); ?></textarea>
                            <select name="kategorie_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id']; ?>" <?= $category['id'] == $recipe['kategorie_id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="edit_recipe" class="btn btn-warning btn-sm">Edit</button>
                        </form>

                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $recipe['id']; ?>">
                            <button type="submit" name="delete_recipe" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
