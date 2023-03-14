// Get the links in the sidebar
var sidebarLinks = document.querySelectorAll('.sidebar a');

// Add an "active" class to the current link
sidebarLinks.forEach(function(link) {
    link.addEventListener('click', function() {
        // Remove the "active" class from all links
        sidebarLinks.forEach(function(link) {
            link.classList.remove('active');
        });

        // Add the "active" class to the clicked link
        this.classList.add('active');
    });
});
