<?php
session_start();
require_once("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['user_id'])) {
    header("Location: admin-users.php");
    exit();
}

$user_id = mysqli_real_escape_string($conn, $_GET['user_id']);


$user_sql = "SELECT * FROM Users WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);

if (mysqli_num_rows($user_result) == 0) {
    header("Location: admin-users.php");
    exit();
}

$user = mysqli_fetch_assoc($user_result);


$requests_sql = "SELECT * FROM Relief_requests WHERE user_id = '$user_id' ORDER BY request_id DESC";
$requests_result = mysqli_query($conn, $requests_sql);
$request_count = mysqli_num_rows($requests_result);
?>

<?php include_once("header.php"); ?>

<div class="container mt-4">

    <a href="admin-users.php" class="btn btn-secondary mb-3">← Back to Users</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>User Details Report</h3>
        </div>

        <div class="row">

            <!-- Personal Information -->
            <div class="col-md-6">
                <h4>Personal Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">User ID</th>
                        <td><?php echo $user['user_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span <?php echo $user['role'] == 'admin' ? 'danger' : 'primary'; ?>>
                                <?php echo ucfirst($user['role']); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td><?php echo htmlspecialchars($user['contact']); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Location & Family Details -->
            <div class="col-md-6">
                <h4>Location & Family Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">District</th>
                        <td><?php echo htmlspecialchars($user['district']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($user['address'] ?: 'Not provided'); ?></td>
                    </tr>
                    <tr>
                        <th>Divisional Secretariat</th>
                        <td><?php echo htmlspecialchars($user['divisional_secretariat'] ?: 'Not provided'); ?></td>
                    </tr>
                    <tr>
                        <th>GN Division</th>
                        <td><?php echo htmlspecialchars($user['gn_division'] ?: 'Not provided'); ?></td>
                    </tr>
                    <tr>
                        <th>Family Members</th>
                        <td><?php echo $user['family_members'] ?: '0'; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-header bg-primary text-white">
            <h4>Relief Requests Summary</h4>
        </div>
        <div>
            <strong>Total Requests Submitted:</strong> <?php echo $request_count; ?>
        </div>

        <?php if ($request_count > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Relief Type</th>
                            <th>District</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($request = mysqli_fetch_assoc($requests_result)): ?>
                            <tr>
                                <td><?php echo $request['request_id']; ?></td>
                                <td>
                                    <?php echo ucfirst($request['relief_type']); ?>

                                </td>
                                <td><?php echo htmlspecialchars($request['district']); ?></td>
                                <td>
                                    <span <?php
                                            if ($request['severity'] == 'High') echo 'danger';
                                            elseif ($request['severity'] == 'Medium') echo 'warning';
                                            else echo 'success';
                                            ?>>
                                        <?php echo $request['severity']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span <?php
                                            if ($request['status'] == 'Approved') echo 'success';
                                            elseif ($request['status'] == 'Rejected') echo 'danger';
                                            else echo 'secondary';
                                            ?>>
                                        <?php echo ucfirst($request['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars(substr($request['description'], 0, 80)) . '...'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No relief requests submitted by this user.</p>
        <?php endif; ?>
    </div>

    <div class="card-footer text-muted">
        Report generated on: <?php echo date('Y-m-d H:i:s'); ?>
    </div>
</div>
</div>

<?php include_once("footer.php"); ?>