<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminders | Lab-Track</title>
    <link rel="stylesheet" href="../css/reminders.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="calendar.php">Calendar</a></li>
                <li><a href="reminders.php">Reminders</a></li>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="../view/loginpage.html">Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <h1>Reminders</h1>
            <form class="reminder-form" id="reminder-form" action="../action/add_reminder.php" method="post">
                <label for="reminder-task">Task Name:</label>
                <input type="text" id="reminder-task" name="reminder-task" required>
                <label for="reminder-date">Reminder Date:</label>
                <input type="date" id="reminder-date" name="reminder-date" required>
                <label for="reminder-time">Reminder Time:</label>
                <input type="time" id="reminder-time" name="reminder-time" required>
                <button type="submit">Set Reminder</button>
            </form>
            <!-- Display area for reminders -->
            <div id="reminder-list">
                <!-- Dynamically generated reminder list will be displayed here -->
                <!-- Example: <div class="reminder-item">Reminder 1 - Task 1 - April 1, 2024 - 10:00 AM</div> -->
            </div>
        </div>
    </div>
    <ul id='reminder-list'></ul>

    <script src="../js/reminder.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>

function sendEmail(taskname, time, Email) {
    var templateParams = {
        message: "You have task to " + taskname + " at " + time,
        email: Email,
        // "username": <?php echo $_SESSION['username'] ?>,
    };
    emailjs.send("service_7z6vhfs", "template_9i2waod", templateParams, "4Db-CsnuLDY6ZL7z_")
        .then(function(response) {
            console.log("Email sent successfully:", response);
            // Redirect to the verification_view page
            window.location.href = "../login/verify_pin_view.php";
        }, function(error) {
            console.error("Error sending email:", error);
        });
}



       function fetchReminders() {
    $.ajax({
        url: '../functions/get_reminder.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Get current date and time
            var currentDate = new Date().toISOString().split('T')[0]; // Get current date in 'YYYY-MM-DD' format
            var currentTime = new Date().toLocaleTimeString([], {hour12: false}); // Get current time in 'HH:MM:SS' format
            
            // Filter reminders that have the current date and time
            var currentReminders = data.filter(function(reminder) {
                return reminder.reminder_date === currentDate && reminder.reminder_time.substring(0, 5) === currentTime.substring(0, 5);
            });
            
            // Check if there are any current reminders
            if (currentReminders.length > 0) {
                // Display current reminders
                $('#reminder-list').empty(); // Clear previous reminders
                $.each(currentReminders, function(index, reminder) {
                    console.log("KSFDHSFSIBISBI",index,reminder)
                    $('#reminder-list').append('<li>' + reminder.taskname + ' - ' + reminder.reminder_date + '</li>');
                    sendEmail(reminder.taskname,date,reminder.Email);
                });
            } else {
                // No current reminders
                $('#reminder-list').empty();
                $('#reminder-list').append('<li>No reminders for the current time</li>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching reminders:', error);
        }
    });
}

// Fetch reminders every 5 seconds
setInterval(fetchReminders, 5000); // 5 seconds in milliseconds

// Initial fetch on page load
$(document).ready(function() {
    fetchReminders();
});
    </script>
</body>
</html>
