<?php
// add_record.php
require_once "config.php";

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $patient_name = trim($_POST["patient_name"]);
    $record_date = trim($_POST["record_date"]);
    $description = trim($_POST["description"]);

    if(!empty($patient_name) && !empty($record_date) && !empty($description)){

        $sql = "INSERT INTO medical_records (patient_name, record_date, description) 
                VALUES (:patient_name, :record_date, :description)";

        if($stmt = $pdo->prepare($sql)){

            $stmt->bindParam(":patient_name", $patient_name);
            $stmt->bindParam(":record_date", $record_date);
            $stmt->bindParam(":description", $description);

            if($stmt->execute()){
                $message = "Record added successfully!";
            } else{
                $message = "Something went wrong. Please try again.";
            }
        }

        unset($stmt);
    } else{
        $message = "Please fill all fields.";
    }
}

unset($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Medical Record</title>
</head>
<body>

<h2>Add Medical Record</h2>

<?php 
if(!empty($message)){
    echo "<p>$message</p>";
}
?>

<form method="post" action="add_record.php">

    <label>Patient Name:</label><br>
    <input type="text" name="patient_name" required><br><br>

    <label>Record Date:</label><br>
    <input type="date" name="record_date" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <input type="submit" value="Add Record">

</form>

</body>
</html>