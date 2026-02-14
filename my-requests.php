<?php
session_start();
require_once("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);

    $check_sql = "SELECT user_id FROM Relief_requests WHERE request_id = '$delete_id'";
    $check_result = mysqli_query($conn, $check_sql);
    $request = mysqli_fetch_assoc($check_result);

    if ($request && $request['user_id'] == $user_id) {
        $delete_sql = "DELETE FROM Relief_requests WHERE request_id = '$delete_id'";
        if (mysqli_query($conn, $delete_sql)) {
            echo "<script>alert('Request deleted successfully.');</script>";
        }
    }
    header("Location: my-requests.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_request'])) {
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $relief_type = mysqli_real_escape_string($conn, $_POST['relief_type']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $divisional_secretariat = mysqli_real_escape_string($conn, $_POST['divisional_secretariat']);
    $gn_division = mysqli_real_escape_string($conn, $_POST['gn_division']);
    $severity = mysqli_real_escape_string($conn, $_POST['severity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $check_sql = "SELECT user_id FROM Relief_requests WHERE request_id = '$request_id'";
    $check_result = mysqli_query($conn, $check_sql);
    $request = mysqli_fetch_assoc($check_result);

    if ($request && $request['user_id'] == $user_id) {
        $update_sql = "UPDATE Relief_requests SET 
                      relief_type = '$relief_type',
                      district = '$district',
                      divisional_secretariat = '$divisional_secretariat',
                      gn_division = '$gn_division',
                      severity = '$severity',
                      description = '$description'
                      WHERE request_id = '$request_id'";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Request updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating request.');</script>";
        }
    }
}

$sql = "SELECT * FROM Relief_requests WHERE user_id = '$user_id' ORDER BY request_id DESC";
$result = mysqli_query($conn, $sql);
?>

<?php include_once("header.php"); ?>

<h2>My Relief Requests</h2>

<p><a href="relief-request.php">Submit New Request</a></p>

<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="table-container">
    <table>
        <tr>
            <th>Request ID</th>
            <th>Relief Type</th>
            <th>District</th>
            <th>Severity</th>
            <th>Status</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr id="row-<?php echo $row['request_id']; ?>">
                <td><?php echo $row['request_id']; ?></td>
                <td id="type-<?php echo $row['request_id']; ?>"><?php echo ucfirst($row['relief_type']); ?></td>
                <td id="district-<?php echo $row['request_id']; ?>"><?php echo $row['district']; ?></td>
                <td>
                    <span id="severity-<?php echo $row['request_id']; ?>"
                        <?php
                        if ($row['severity'] == 'High') echo 'danger';
                        elseif ($row['severity'] == 'Medium') echo 'warning';
                        else echo 'success';
                        ?>>
                        <?php echo $row['severity']; ?>
                    </span>
                </td>
                <td>
                    <span <?php
                            if ($row['status'] == 'Approved') echo 'success';
                            elseif ($row['status'] == 'Rejected') echo 'danger';
                            else echo 'secondary';
                            ?>>
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </td>
                <td id="desc-<?php echo $row['request_id']; ?>"><?php echo substr($row['description'], 0, 50) . '...'; ?></td>
                <td>
                <td>
                    <button onclick="viewRequest(<?php echo $row['request_id']; ?>)">View</button>
                    <button onclick="showEditForm(<?php echo $row['request_id']; ?>)">Edit</button>
                    <button onclick="deleteRequest(<?php echo $row['request_id']; ?>)">Delete</button>
                </td>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
<?php else: ?>
    <p>No relief requests submitted yet. <a href="relief-request.php">Submit your first request</a></p>
<?php endif; ?>

<!--Hidden Edit Form -->
<div id="editPopup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:white; padding:20px; border:2px solid #007bff; z-index:1000; width:400px;">
    <h3>Edit Request</h3>
    <form method="post" action="" id="editForm">
        <input type="hidden" name="request_id" id="editRequestId">

        <label>Relief Type:</label>
        <select name="relief_type" id="editReliefType" required>
            <option value="food">Food</option>
            <option value="water">Water</option>
            <option value="medicine">Medicine</option>
            <option value="shelter">Shelter</option>
        </select><br><br>

        <label>District:</label>
        <select name="district" id="editDistrict" required>
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
        </select><br><br>

        <label>Divisional Secretariat:</label>
        <input type="text" name="divisional_secretariat" id="editDS"><br><br>

        <label>GN Division:</label>
        <input type="text" name="gn_division" id="editGND"><br><br>

        <label>Severity:</label><br>
        <input type="radio" name="severity" value="Low" id="severityLow"> Low
        <input type="radio" name="severity" value="Medium" id="severityMedium"> Medium
        <input type="radio" name="severity" value="High" id="severityHigh"> High<br><br>

        <label>Description:</label><br>
        <textarea name="description" id="editDescription" rows="3" style="width:100%;"></textarea><br><br>

        <button type="submit" name="update_request">Update</button>
        <button type="button" onclick="closeEditForm()">Cancel</button>
    </form>
</div>

<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>

<script>
    function viewRequest(id) {
        alert('Viewing details for request #' + id);
    }

    function showEditForm(id) {

        let currentType = document.getElementById('type-' + id).textContent.toLowerCase();
        let currentDistrict = document.getElementById('district-' + id).textContent;
        let currentSeverity = document.getElementById('severity-' + id).textContent;
        let currentDesc = document.getElementById('desc-' + id).textContent;

        document.getElementById('editRequestId').value = id;
        document.getElementById('editReliefType').value = currentType;
        document.getElementById('editDistrict').value = currentDistrict;

        document.getElementById('severityLow').checked = (currentSeverity === 'Low');
        document.getElementById('severityMedium').checked = (currentSeverity === 'Medium');
        document.getElementById('severityHigh').checked = (currentSeverity === 'High');

        document.getElementById('editDescription').value = currentDesc;

        document.getElementById('editPopup').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function closeEditForm() {
        document.getElementById('editPopup').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }

    function deleteRequest(id) {
        if (confirm('Are you sure you want to delete request #' + id + '?')) {
            window.location.href = 'my-requests.php?delete_id=' + id;
        }
    }

    document.getElementById('overlay').onclick = closeEditForm;
</script>

<?php include_once("footer.php"); ?>