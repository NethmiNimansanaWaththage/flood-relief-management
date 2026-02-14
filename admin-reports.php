<?php
session_start();
require_once("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}


$filter_district = $_GET['district'] ?? '';
$filter_relief = $_GET['relief_type'] ?? '';
$filter_severity = $_GET['severity'] ?? '';


$where = "WHERE 1=1";
if ($filter_district) {
    $where .= " AND district = '$filter_district'";
}
if ($filter_relief) {
    $where .= " AND relief_type = '$filter_relief'";
}
if ($filter_severity) {
    $where .= " AND severity = '$filter_severity'";
}


$total_users_sql = "SELECT COUNT(*) as total FROM Users";
$total_requests_sql = "SELECT COUNT(*) as total FROM Relief_requests $where";
$high_severity_sql = "SELECT COUNT(*) as total FROM Relief_requests WHERE severity = 'High'";
$food_requests_sql = "SELECT COUNT(*) as total FROM Relief_requests WHERE relief_type = 'food'";
$medicine_requests_sql = "SELECT COUNT(*) as total FROM Relief_requests WHERE relief_type = 'medicine'";
$water_requests_sql = "SELECT COUNT(*) as total FROM Relief_requests WHERE relief_type = 'water'";
$shelter_requests_sql = "SELECT COUNT(*) as total FROM Relief_requests WHERE relief_type = 'shelter'";

$total_users = mysqli_fetch_assoc(mysqli_query($conn, $total_users_sql))['total'];
$total_requests = mysqli_fetch_assoc(mysqli_query($conn, $total_requests_sql))['total'];
$high_severity = mysqli_fetch_assoc(mysqli_query($conn, $high_severity_sql))['total'];
$food_requests = mysqli_fetch_assoc(mysqli_query($conn, $food_requests_sql))['total'];
$medicine_requests = mysqli_fetch_assoc(mysqli_query($conn, $medicine_requests_sql))['total'];
$water_requests = mysqli_fetch_assoc(mysqli_query($conn, $water_requests_sql))['total'];
$shelter_requests = mysqli_fetch_assoc(mysqli_query($conn, $shelter_requests_sql))['total'];


$requests_sql = "SELECT r.*, u.fullname, u.contact FROM Relief_requests r 
                 LEFT JOIN Users u ON r.user_id = u.user_id 
                 $where ORDER BY r.request_id DESC";
$requests_result = mysqli_query($conn, $requests_sql);
?>

<?php include_once("header.php"); ?>

<h2>System Reports (Admin)</h2>

<div style="background: #e9ffe9; padding: 15px; margin: 20px 0; border-radius: 5px;">
    <h3>Summary Statistics</h3>
    <p>Total Registered Users: <strong><?php echo $total_users; ?></strong></p>
    <p>Total Relief Requests: <strong><?php echo $total_requests; ?></strong></p>
    <p>High Severity Households: <strong><?php echo $high_severity; ?></strong></p>
    <p>Food Requests: <strong><?php echo $food_requests; ?></strong></p>
    <p>Medicine Requests: <strong><?php echo $medicine_requests; ?></strong></p>
    <p>Water Requests: <strong><?php echo $water_requests; ?></strong></p>
    <p>Shelter Requests: <strong><?php echo $shelter_requests; ?></strong></p>
</div>

<h3>Filter Reports</h3>
<form method="get" action="">
    <label>District:</label>
    <select name="district">
        <option value="">All Districts</option>
        <option value="Colombo" <?php echo ($filter_district == 'Colombo') ? 'selected' : ''; ?>>Colombo</option>
        <option value="Gampaha" <?php echo ($filter_district == 'Gampaha') ? 'selected' : ''; ?>>Gampaha</option>
        <option value="Kalutara" <?php echo ($filter_district == 'Kalutara') ? 'selected' : ''; ?>>Kalutara</option>
        <option value="Kandy" <?php echo ($filter_district == 'Kandy') ? 'selected' : ''; ?>>Kandy</option>
        <option value="Matale" <?php echo ($filter_district == 'Matale') ? 'selected' : ''; ?>>Matale</option>
        <option value="Nuwara Eliya" <?php echo ($filter_district == 'Nuwara Eliya') ? 'selected' : ''; ?>>Nuwara Eliya</option>
        <option value="Galle" <?php echo ($filter_district == 'Galle') ? 'selected' : ''; ?>>Galle</option>
        <option value="Matara" <?php echo ($filter_district == 'Matara') ? 'selected' : ''; ?>>Matara</option>
        <option value="Hambantota" <?php echo ($filter_district == 'Hambantota') ? 'selected' : ''; ?>>Hambantota</option>
        <option value="Jaffna" <?php echo ($filter_district == 'Jaffna') ? 'selected' : ''; ?>>Jaffna</option>

    </select>

    <label>Severity:</label>
    <select name="severity">
        <option value="">All Severities</option>
        <option value="Low" <?php echo ($filter_severity == 'Low') ? 'selected' : ''; ?>>Low</option>
        <option value="Medium" <?php echo ($filter_severity == 'Medium') ? 'selected' : ''; ?>>Medium</option>
        <option value="High" <?php echo ($filter_severity == 'High') ? 'selected' : ''; ?>>High</option>
    </select>

    <label>Relief Type:</label>
    <select name="relief_type">
        <option value="">All Types</option>
        <option value="food" <?php echo ($filter_relief == 'food') ? 'selected' : ''; ?>>Food</option>
        <option value="water" <?php echo ($filter_relief == 'water') ? 'selected' : ''; ?>>Water</option>
        <option value="medicine" <?php echo ($filter_relief == 'medicine') ? 'selected' : ''; ?>>Medicine</option>
        <option value="shelter" <?php echo ($filter_relief == 'shelter') ? 'selected' : ''; ?>>Shelter</option>
    </select>

    <button type="submit">Apply Filters</button>
</form>

<a href="admin-reports.php">Clear All Filters</a></br></br>

<h3>Filtered Requests</h3>
<?php if (mysqli_num_rows($requests_result) > 0): ?>
    <table class="table table-bordered">
        <tr>
            <th>Request ID</th>
            <th>User</th>
            <th>Contact</th>
            <th>Relief Type</th>
            <th>District</th>
            <th>Severity</th>
            <th>Description</th>
        </tr>
        <?php while ($request = mysqli_fetch_assoc($requests_result)): ?>
            <tr>
                <td><?php echo $request['request_id']; ?></td>
                <td><?php echo $request['fullname']; ?></td>
                <td><?php echo $request['contact']; ?></td>
                <td><?php echo ucfirst($request['relief_type']); ?></td>
                <td><?php echo $request['district']; ?></td>
                <td>
                    <span <?php
                            if ($request['severity'] == 'High') echo 'danger';
                            elseif ($request['severity'] == 'Medium') echo 'warning';
                            else echo 'success';
                            ?>>
                        <?php echo $request['severity']; ?>
                    </span>
                </td>
                <td><?php echo substr($request['description'], 0, 50) . '...'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No requests found with current filters.</p>
<?php endif; ?>