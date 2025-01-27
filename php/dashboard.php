<?php
session_start();
include 'db_connection.php';

// Fetch data for stats
$login_query = "SELECT COUNT(*) AS total_logins FROM users WHERE last_login IS NOT NULL";
$login_result = mysqli_query($conn, $login_query);
$total_logins = mysqli_fetch_assoc($login_result)['total_logins'];

$contact_query = "SELECT COUNT(*) AS total_contacts FROM contact";
$contact_result = mysqli_query($conn, $contact_query);
$total_contacts = mysqli_fetch_assoc($contact_result)['total_contacts'];

// Fetch detailed data
$users_query = "SELECT username, last_login FROM users";
$users_result = mysqli_query($conn, $users_query);

$contacts_query = "SELECT name, email, subject, message, created_at FROM contact";
$contacts_result = mysqli_query($conn, $contacts_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color: #fff;
            padding-top: 30px;
            position: fixed;
            height:100vh;
           
        }
        .sidebar h2{
            padding:25px;
            color: green;
        }
        .sidebar a {
            display: block;
            padding: 25px;
            color:white;
            text-decoration: none;
            font-size: 20px;
        }
        .sidebar a:hover {
            background-color: green;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            overflow-y: auto;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 5rem;
            margin-bottom: 20px;
        }
        .stat-box {
            background: green;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat-box h2 {
            font-size: 36px;
            color: #2C3E50;
        }
        .stat-box p {
            font-size: 20px;
            font-weight:700;
            color:rgb(240, 244, 244);
        }
        .details-section {
            display: none;
            margin-top: 2rem;
        }
        .details-section a:hover {
             color:rgb(0, 240, 140);
        }
        .details-section h1 {
          padding: 20px;
        }
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #34495E;
            color: white;
        }
        .active {
            display: block !important;
        }
    </style>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.details-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#" onclick="showSection('dashboard-section')">Dashboard</a>
        <a href="#" onclick="showSection('user-logins-section')">User Login Details</a>
        <a href="#" onclick="showSection('contact-details-section')">Contact Details</a>
        <a href="index.html">Home</a>
        <!-- <a href="logout.php" class="logout-btn">Logout</a> -->
    </div>

    <div class="main-content">
        <!-- Dashboard Section -->
        <div id="dashboard-section" class="details-section active">
            <h1 style="text-align:center">Admin Dashboard</h1>
            <div class="stats">
                <div class="stat-box">
                    <h2><?php echo $total_logins; ?></h2>
                    <p>Total User Logins</p>
                </div>
                <div class="stat-box">
                    <h2><?php echo $total_contacts; ?></h2>
                    <p>Total Contact Submissions</p>
                </div>
            </div>
        </div>

        <!-- User Logins Section -->
        <div id="user-logins-section" class="details-section">
            <h1>User Login Details</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Last Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($users_result)): ?>
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['last_login']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contact Details Section -->
        <div id="contact-details-section" class="details-section">
            <h1>Contact Details</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($contacts_result)): ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['subject']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
