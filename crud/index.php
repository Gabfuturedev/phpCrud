<?php
include 'connection.php';

// Add new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = $_POST["name"];
    $descr = $_POST["descr"];
    $price = $_POST["price"];

    // Perform the insertion into the database
    $sql = "INSERT INTO prut (name, descr, price) VALUES ('$name', '$descr', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "New record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete record
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    // Perform the deletion
    $sql = "DELETE FROM prut WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Edit record
if (isset($_POST['edit'])) {
    $edit_id = $_POST['edit'];

    // Fetch data for editing
    $edit_sql = "SELECT * FROM prut WHERE id = $edit_id";
    $edit_result = $conn->query($edit_sql);

    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
    } else {
        echo "Error fetching record for editing";
    }
}
// Update record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $update_id = $_POST['edit_id'];
    $name = $_POST["name"];
    $descr = $_POST["descr"];
    $price = $_POST["price"];

    // Perform the update in the database
    $update_sql = "UPDATE prut SET name='$name', descr='$descr', price='$price' WHERE id=$update_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
 
// Fetch data from the database
$sql = "SELECT * FROM prut";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your styles here */
    </style>
    <title>Document</title>
</head>
<body>
    <!-- Your HTML content here -->
    <div class="container">
        <!-- form -->
        <div class="sign">
            <?php
            // Display the form for adding or editing
            if (isset($edit_row)) {
                // If editing, pre-fill the form with existing data
                ?>
                <form action="index.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
                    <input type="text" name="name" placeholder="name" value="<?php echo $edit_row['name']; ?>">
                    <input type="text" name="descr" placeholder="Description" value="<?php echo $edit_row['descr']; ?>">
                    <input type="number" name="price" placeholder="price" value="<?php echo $edit_row['price']; ?>">
                    <button type="submit" name="update">Update</button>
                </form>
                <?php
            } else {
                // If not editing, display the regular form for adding
                ?>
                <form action="index.php" method="post">
                    <input type="text" name="name" placeholder="name">
                    <input type="text" name="descr" placeholder="Description">
                    <input type="number" name="price" placeholder="price">
                    <button type="submit" name="add">submit</button>
                </form>
                <?php
            }
            ?>
        </div>

        <!-- table side -->
        <div class="tab">
            <?php
            // Check if there are any records
            if ($result->num_rows > 0) {
            ?>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>name</th>
                        <th>Description</th>
                        <th>price</th>
                        <th>action</th>
                    </tr>
                    <?php
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["descr"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td>
                                <form action="index.php" method="post">
                                    <button type="submit" name="edit" value="<?php echo $row["id"]; ?>">edit</button>
                                    <button type="submit" name="delete" value="<?php echo $row["id"]; ?>">Delete</button>
                                    <button type="button">view</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            } else {
                echo "0 results";
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
