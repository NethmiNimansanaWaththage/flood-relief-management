<?php
session_start();
require_once("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['delete_user'])) {
    $user_id_to_delete = mysqli_real_escape_string($conn, $_GET['delete_user']);

    $check_sql = "SELECT role, fullname FROM Users WHERE user_id = '$user_id_to_delete'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $user_data = mysqli_fetch_assoc($check_result);

        if ($user_id_to_delete == $_SESSION['user_id']) {
            echo "<script>alert('You cannot delete your own account.');</script>";
        } elseif ($user_data['role'] == 'admin') {
            echo "<script>alert('Cannot delete admin accounts. Only regular users can be deleted.');</script>";
        } else {
            $delete_requests = "DELETE FROM Relief_requests WHERE user_id = '$user_id_to_delete'";
            mysqli_query($conn, $delete_requests);

            $delete_user = "DELETE FROM Users WHERE user_id = '$user_id_to_delete'";
            if (mysqli_query($conn, $delete_user)) {
                echo "<script>alert('User \"" . $user_data['fullname'] . "\" deleted successfully.');</script>";
            }
        }
    }

    header("Location: admin-users.php");
    exit();
}


$sql = "SELECT * FROM Users ORDER BY user_id DESC";
$result = mysqli_query($conn, $sql);


$count_sql = "SELECT COUNT(*) as total FROM Users";
$count_result = mysqli_query($conn, $count_sql);
$total_users = mysqli_fetch_assoc($count_result)['total'];
?>

<?php include_once("header.php"); ?>

<h2>Manage Users (Admin)</h2>

<div style="background: #e9ffe9; padding: 15px; margin: 20px 0; border-radius: 5px;">
    <h3>System Summary</h3>
    <p>Total Registered Users: <strong><?php echo $total_users; ?></strong></p>
</div>

<h3>All Registered Users</h3>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>District</th>
            <th>Contact</th>
            <th>Family Members</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td>
                    <span <?php echo $row['role']  ?>>
                        <?php echo ucfirst($row['role']); ?>
                    </span>
                </td>
                <td><?php echo $row['district']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['family_members'] ?: '0'; ?></td>
                <td>
                    <button onclick="window.location.href='user-details-report.php?user_id=<?php echo $row['user_id']; ?>'">
                        View Details Report
                    </button>

                    <?php if ($row['role'] == 'user' && $row['user_id'] != $_SESSION['user_id']): ?>
                        <button onclick="deleteUser(<?php echo $row['user_id']; ?>, '<?php echo $row['fullname']; ?>', '<?php echo $row['role']; ?>')">Delete</button>
                    <?php elseif ($row['role'] == 'admin'): ?>
                        <span style="color: #6c757d; font-size: 12px;">Admin</span>
                    <?php elseif ($row['user_id'] == $_SESSION['user_id']): ?>
                        <span style="color: #6c757d; font-size: 12px;">Current User</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No users registered yet.</p>
<?php endif; ?>

<script>
    function deleteUser(userId, userName, userRole) {
        if (userRole === 'admin') {
            alert('Cannot delete admin accounts.');
            return false;
        }

        if (confirm('Are you sure you want to delete user: ' + userName + '?\nThis will also delete all their relief requests.')) {
            window.location.href = 'admin-users.php?delete_user=' + userId;
        }
    }
</script>

<?php include_once("footer.php"); ?>