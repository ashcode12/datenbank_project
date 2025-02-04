<?php
// Include the database connection
include("db_connect.php");

// Initialize variables for ingredient data
$errors = [];
$success_message = "";

// Handle Create/Update/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_ingredient'])) {
        // Add a new ingredient
        $name = $_POST['name'] ?? '';
        $ist_allergen = $_POST['ist_allergen'] ?? 0;
        $kalorien = $_POST['kalorien'] ?? null;

        if (empty($name)) {
            $errors[] = "Name is required!";
        } else {
            $sql = "INSERT INTO Zutaten (name, ist_allergen, kalorien_pro_einheit) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $name, $ist_allergen, $kalorien);
            if ($stmt->execute()) {
                $success_message = "Ingredient added successfully!";
            } else {
                $errors[] = "Error adding ingredient: " . $conn->error;
            }
        }
    } elseif (isset($_POST['edit_ingredient'])) {
        // Edit an existing ingredient
        $id = $_POST['id'];
        $name = $_POST['name'];
        $ist_allergen = $_POST['ist_allergen'];
        $kalorien = $_POST['kalorien'];

        if (empty($name)) {
            $errors[] = "Name is required!";
        } else {
            $sql = "UPDATE Zutaten SET name = ?, ist_allergen = ?, kalorien_pro_einheit = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siii", $name, $ist_allergen, $kalorien, $id);
            if ($stmt->execute()) {
                $success_message = "Ingredient updated successfully!";
            } else {
                $errors[] = "Error updating ingredient: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_ingredient'])) {
        // Delete an ingredient
        $id = $_POST['id'];

        $sql = "DELETE FROM Zutaten WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success_message = "Ingredient deleted successfully!";
        } else {
            $errors[] = "Error deleting ingredient: " . $conn->error;
        }
    }
}

// Fetch all ingredients
$sql = "SELECT * FROM Zutaten";
$result = $conn->query($sql);
$ingredients = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zutatenverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Zutatenverwaltung</h1>

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

    <!-- Add Ingredient Form -->
    <form method="post" class="mb-4">
        <h2>Add Ingredient</h2>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="ist_allergen" class="form-label">Is Allergen?</label>
            <select name="ist_allergen" id="ist_allergen" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="kalorien" class="form-label">Calories per Unit</label>
            <input type="number" name="kalorien" id="kalorien" class="form-control">
        </div>
        <button type="submit" name="add_ingredient" class="btn btn-primary">Add Ingredient</button>
    </form>

    <!-- Ingredients Table -->
    <h2>Ingredients</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Is Allergen</th>
                <th>Calories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td><?= htmlspecialchars($ingredient['id']); ?></td>
                    <td><?= htmlspecialchars($ingredient['name']); ?></td>
                    <td><?= $ingredient['ist_allergen'] ? 'Yes' : 'No'; ?></td>
                    <td><?= htmlspecialchars($ingredient['kalorien_pro_einheit']); ?></td>
                    <td>
                        <!-- Edit Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $ingredient['id']; ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($ingredient['name']); ?>" required>
                            <select name="ist_allergen">
                                <option value="0" <?= $ingredient['ist_allergen'] == 0 ? 'selected' : ''; ?>>No</option>
                                <option value="1" <?= $ingredient['ist_allergen'] == 1 ? 'selected' : ''; ?>>Yes</option>
                            </select>
                            <input type="number" name="kalorien" value="<?= htmlspecialchars($ingredient['kalorien_pro_einheit']); ?>">
                            <button type="submit" name="edit_ingredient" class="btn btn-warning btn-sm">Edit</button>
                        </form>

                        <!-- Delete Form -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $ingredient['id']; ?>">
                            <button type="submit" name="delete_ingredient" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
