<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/schedule.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="calendar.php">Calendar</a></li>
                <li><a href="reminders.php">Reminders</a></li>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="../view/loginpage.html">Logout</a></li>
            </ul>
        </aside>
        
        <!-- Main content -->
        <main class="content">
            <h1>Academic Years</h1>
            <button id="new-academic-year-btn">New Academic Year</button>
            <div id="academic-year-form" class="academic-year-form">
                <form id="academic-year-form" action="../action/add_academic_year_action.php" method="post">
                        <h2>New Academic Year</h2>
                        <label for="start-date">Start Date:</label>
                        <input type="date" id="start-date" name="start_date" required>
                        <label for="scheduling-terms">Scheduling Terms:</label>
                        <select id="scheduling-terms" name="scheduling_terms" required>
                            <option value="weekly">Weekly</option>
                            <option value="bi-weekly">Bi-Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        <label for="end-date">End Date:</label>
                        <input type="date" id="end-date" name="end_date" required>
                        <button type="submit">Create</button>
                    </form>

            </div>
            <div class="academic-year-list">
                <!-- Dynamically generated academic year cards -->
                <div class="academic-year-card">
                    <h3>Academic Year 1</h3>
                    <p>Start Date: April 7, 2024</p>
                    <p>Scheduling Terms: Weekly</p>
                    <p>End Date: October 7, 2024</p>
                </div>
                <!-- More academic year cards -->
            </div>

            <ul id='reminder-list'></ul>
        </main>
    </div>
    <script src="../js/academic_year.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <script>

function sendEmail(message,time) {
              var templateParams = {
                  message: "You have task to ".message."at ".time,
                //   "username": <?php echo $_SESSION['username'] ?>,
              };
              emailjs.send("service_67r5b8d", "template_v2z8je9", templateParams, "oyhKpuE8pEN_nUEBp")
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
                    console.log("KAFWJSAGFUAJ",reminder)
                    // reminder.
                    // sendEmail(message,currentTime);
                });
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
