<?php
require '../includes/db.php';
require '../includes/auth.php';

// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is a counselor
if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

// Fetch all students (no search filter in the query initially)
$query = "SELECT * FROM students";  
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Students - Counselor Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
            text-align: center;
        }

        /* Google-style search bar */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-input {
            width: 50%;
            padding: 15px;
            font-size: 16px;
            border-radius: 50px;
            border: 1px solid #ccc;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #4CAF50;
            box-shadow: 0 1px 8px rgba(76, 175, 80, 0.5);
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }


        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .search-input {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="content">
        <h1>Students List</h1>

        <!-- Search Bar with Google-style design -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="Search for students..." onkeyup="searchTable()" />
        </div>

        <table id="studentsTable">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Parent Name</th>
                    <th>Parent Contact</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each student and display the information
                while ($student = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($student['student_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['student_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['gender']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['parent_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['parent_contact_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($student['created_at']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript to handle search functionality
        function searchTable() {
            // Get the value of the search input
            var input = document.getElementById('searchInput');
            var filter = input.value.toLowerCase();
            var table = document.getElementById('studentsTable');
            var tr = table.getElementsByTagName('tr');

            // Loop through all table rows, except the first one (headers)
            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName('td');
                var found = false;

                // Loop through each column in the row
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].textContent.toLowerCase().includes(filter)) {
                            found = true;
                            break; // If match found, no need to check other columns
                        }
                    }
                }

                // Show or hide the row based on search match
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>

</body>
</html>
