document.addEventListener('DOMContentLoaded', function() {
    // Sample data for assignments (replace with actual data)
    const assignmentsData = [
      { id: 1, title: 'Assignment 1', dueDate: 'March 30, 2024' },
      { id: 2, title: 'Assignment 2', dueDate: 'April 15, 2024' },
      // Add more assignment data as needed
    ];
  
    const assignmentList = document.querySelector('.assignment-list');
  
    // Function to generate assignment cards
    function generateAssignmentCard(assignment) {
      const card = document.createElement('div');
      card.classList.add('assignment-card');
      card.innerHTML = `
        <h3>${assignment.title}</h3>
        <p>Due Date: ${assignment.dueDate}</p>
        <button class="mark-complete-btn">Mark as Complete</button>
      `;
      return card;
    }
  
    // Populate assignment list
    assignmentsData.forEach(function(assignment) {
      const card = generateAssignmentCard(assignment);
      assignmentList.appendChild(card);
    });
  
    // Event listener for marking assignments as complete
    assignmentList.addEventListener('click', function(event) {
      if (event.target.classList.contains('mark-complete-btn')) {
        const card = event.target.parentElement;
        // Add styling to visually indicate completion (optional)
        card.style.opacity = '0.6';
        card.style.backgroundColor = '#ccc';
        card.querySelector('.mark-complete-btn').textContent = 'Completed';
        card.querySelector('.mark-complete-btn').disabled = true;
        // You can add logic here to handle backend updates (e.g., marking as complete in the database)
      }
    });
  });
