<?php
session_start();
require_once("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_request'])) {
    $relief_type = mysqli_real_escape_string($conn, $_POST['relief_type'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['district'] ?? '');
    $divisional_secretariat = mysqli_real_escape_string($conn, $_POST['divisional_secretariat'] ?? '');
    $gn_division = mysqli_real_escape_string($conn, $_POST['gn_division'] ?? '');
    $severity = mysqli_real_escape_string($conn, $_POST['severity'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');


    error_log("DEBUG: Form data received - Type: $relief_type, District: $district, Severity: $severity");


    $user_sql = "SELECT fullname, contact, address, family_members FROM Users WHERE user_id = '$user_id'";
    $user_result = mysqli_query($conn, $user_sql);


    if ($user_result === false) {
        error_log("DEBUG: User query failed: " . mysqli_error($conn));
        $_SESSION['error'] = "Database error: " . mysqli_error($conn);
    } else {
        $user = mysqli_fetch_assoc($user_result);

        if (!empty($relief_type) && !empty($district) && !empty($severity)) {

            $sql = "INSERT INTO Relief_requests (user_id, relief_type, district, divisional_secretariat, gn_division, severity, description) 
                    VALUES ('$user_id', '$relief_type', '$district', '$divisional_secretariat', '$gn_division', '$severity', '$description')";

            error_log("DEBUG: Executing SQL: " . $sql);

            if (mysqli_query($conn, $sql)) {
                echo "<script>window.location.href = 'my-requests.php';</script>";
                exit();
            } else {
                error_log("DEBUG: Insert failed: " . mysqli_error($conn));
                $_SESSION['error'] = "Error submitting request: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Please fill all required fields (marked with *)";
        }
    }
}
?>

<?php include_once("header.php"); ?>

<div class="form-container">
    <h2>Submit Flood Relief Request</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="" onsubmit="return validateRequestForm()">
        <h3>Type of Relief Needed *</h3>
        <select name="relief_type" required>
            <option value="">Select Type</option>
            <option value="food">Food</option>
            <option value="water">Water</option>
            <option value="medicine">Medicine</option>
            <option value="shelter">Shelter</option>
        </select>

        <h3>Location Details</h3>
        <label>District *</label>
        <select name="district" required>
            <option value="">Select District</option>
            <option value="Colombo">Colombo</option>
            <option value="Gampaha">Gampaha</option>
            <option value="Kalutara">Kalutara</option>
            <option value="Kandy">Kandy</option>
            <option value="Matale">Matale</option>
            <option value="Nuwara Eliya">Nuwara Eliya</option>
            <option value="Galle">Galle</option>
            <option value="Matara">Matara</option>
            <option value="Hambantota">Hambantota</option>
            <option value="Jaffna">Jaffna</option>
        </select>

        <label>Divisional Secretariat</label>
        <input type="text" name="divisional_secretariat">

        <label>GN Division</label>
        <input type="text" name="gn_division">

        <h3>Flood Severity Level *</h3>
        <div>
            <label><input type="radio" name="severity" value="Low" required> Low</label><br>
            <label><input type="radio" name="severity" value="Medium"> Medium</label><br>
            <label><input type="radio" name="severity" value="High"> High</label>
        </div>

        <h3>Description (Additional Requirements)</h3>
        <textarea name="description" rows="4" placeholder="Describe your situation and any special requirements..."></textarea>

        <p><small>Your contact details (name, phone, address) will be taken from your registration information.</small></p>

        <button type="submit" name="submit_request">Submit Request</button>
        <button type="button" onclick="window.location.href='my-requests.php'">View My Requests</button>
    </form>
</div>

<script>
    function validateRequestForm() {
        let reliefType = document.querySelector('select[name="relief_type"]').value;
        let district = document.querySelector('select[name="district"]').value;
        let severity = document.querySelector('input[name="severity"]:checked');

        if (!reliefType || !district || !severity) {
            alert("Please fill all required fields (marked with *)");
            return false;
        }
        return true;
    }
</script>

<?php include_once("footer.php"); ?>