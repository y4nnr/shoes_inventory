// scripts.js

$(document).ready(function () {
    // Initialize DataTable with sorting, search, and responsiveness enabled
    $('#shoesTable').DataTable({
        responsive: true, // Make the table responsive for smaller screens
        paging: true, // Enable pagination
        ordering: true, // Enable column-based sorting
        info: true, // Show table information (e.g., entries count)
        searching: true, // Enable search functionality
        language: {
            search: "Filter:", // Custom label for the search box
            lengthMenu: "Show _MENU_ entries",
        },
        columnDefs: [
            { orderable: true, targets: '_all' }, // Make all columns sortable
        ],
        // Customize page length options and default page length
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        search: {
            caseInsensitive: true, // Case-insensitive search
        },
    });
});
