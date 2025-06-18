<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cricket_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert sample data
$sql = "INSERT INTO player_wickets (player_name, wickets)
        VALUES ('Player 1', 50),
               ('Player 2', 45),
               ('Player 3', 60),
               ('Player 4', 55)";

if ($conn->query($sql) === TRUE) {
    echo "Sample data inserted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Retrieve data
$sql = "SELECT player_name, wickets FROM player_wickets";
$result = $conn->query($sql);

// Close the MySQL connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <!-localllllll- Load Google Charts API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Player Name');
            data.addColumn('number', 'Number of Wickets');

            // Add data from PHP to the chart
            data.addRows([
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "['" . $row["player_name"] . "', " . $row["wickets"] . "],";
                    }
                }
                ?>
            ]);

            var options = {
                 title: 'Player Wickets',
                width: 400,
                height: 300
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <div id="chart_div"></div>
</body>
</html>