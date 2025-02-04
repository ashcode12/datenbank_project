<?php
// Include the database connection
include("db_connect.php");

// Initialize variables
$errors = [];
$success_message = "";

// Handle Create/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_recipe_ingredient'])) {
        // Add a new recipe-ingredient relationship
        $rezept_id = $_POST['rezept_id'] ?? null;
        $zutat_id = $_POST['zutat_id'] ?? null;
        $menge = $_POST['menge'] ?? '';

        if (empty($rezept_id) || empty($zutat_id) || empty($menge)) {
            $errors[] = "Recipe, Ingredient, and Quantity are required!";
        } else {
            $sql = "INSERT INTO Rezeptzutaten (rezept_id, zutat_id, menge) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $rezept_id, $zutat_id, $menge);
            if ($stmt->execute()) {
                $success_message = "Ingredient added to recipe successfully!";
            } else {
                $errors[] = "Error adding ingredient to recipe: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_recipe_ingredient'])) {
        // Delete a recipe-ingredient relationship
        $id = $_POST['id'];

        $sql = "DELETE FROM Rezeptzutaten WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Ingredient removed from recipe successfully!";
        } else {
            $errors[] = "Error removing ingredient from recipe: " . $conn->error;
        }
    }
}

// Fetch all recipe-ingredient relationships
$sql = "SELECT rz.id, r.name AS recipe, z.name AS ingredient, rz.menge
        FROM Rezeptzutaten rz
        JOIN Rezepte r ON rz.rezept_id = r.id
        JOIN Zutaten z ON rz.zutat_id = z.id";
$result = $conn->query($sql);
$recipe_ingredients = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all recipes and ingredients for dropdowns
$sql = "SELECT id, name FROM Rezepte";
$recipes_result = $conn->query($sql);
$recipes = $recipes_result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT id, name FROM Zutaten";
$ingredients_result = $conn->query($sql);
$ingredients = $ingredients_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezeptzutatenverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Rezeptzutatenverwaltung</h1>

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

    <!-- Add Recipe-Ingredient Form -->
    <form method="post" class="mb-4">
        <h2>Add Ingredient to Recipe</h2>
        <div class="mb-3">
            <label for="rezept_id" class="form-label">Recipe</label>
            <select name="rezept_id" id="rezept_id" class="form-control" required>
                <option value="">Select Recipe</option>
                <?php foreach ($recipes as $recipe): ?>
                    <option value="<?= $recipe['id']; ?>"><?= htmlspecialchars($recipe['name']); ?></option>
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
        <button type="submit" name="add_recipe_ingredient" class="btn btn-primary">Add</button>
    </form>

    <!-- Recipe-Ingredient Table -->
    <h2>Recipe Ingredients</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Recipe</th>
                <th>Ingredient</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipe_ingredients as $ri): ?>
                <tr>
                    <td><?= htmlspecialchars($ri['id']); ?></td>
                    <td><?= htmlspecialchars($ri['recipe']); ?></td>
                    <td><?= htmlspecialchars($ri['ingredient']); ?></td>
                    <td><?= htmlspecialchars($ri['menge']); ?></td>
                    <td>
                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $ri['id']; ?>">
                            <button type="submit" name="delete_recipe_ingredient" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
