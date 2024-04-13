document.addEventListener('DOMContentLoaded', function() {
    const newAcademicYearBtn = document.getElementById("new-academic-year-btn");
    const academicYearForm = document.querySelector("#academic-year-form"); // Update selector to target the form element
    const academicYearList = document.querySelector(".academic-year-list");

    newAcademicYearBtn.addEventListener("click", () => {
        academicYearForm.style.display = "block";
    });

    academicYearForm.addEventListener("submit", function(event) {
        event.preventDefault();

        // Get form data
        const formData = new FormData(academicYearForm); // Update to target the form element
        const data = Object.fromEntries(formData.entries());

        // Send form data to the server
        fetch("../action/add_academic_year_action.php", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === "success") {
                // Add the new academic year to the UI
                const academicYearCard = generateAcademicYearCard(result.data);
                academicYearList.appendChild(academicYearCard);

                // Display success message
                alert(result.message);
            } else {
                // Display error message
                alert(result.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            // Display error message
            alert("An error occurred. Please try again.");
        });

        // Hide the form
        academicYearForm.style.display = "none";
    });

    // Function to generate an academic year card
    function generateAcademicYearCard(data) {
        const card = document.createElement("div");
        card.classList.add("academic-year-card");
        card.innerHTML = `
            <h3>${data.name}</h3>
            <p>Start Date: ${data.start_date}</p>
            <p>Scheduling Terms: ${data.scheduling_terms}</p>
            <p>End Date: ${data.end_date}</p>
        `;
        return card;
    }
});
