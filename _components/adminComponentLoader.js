const scriptComponentLocation = document.currentScript.src;
const scriptComponentDir = scriptComponentLocation.substring(0, scriptComponentLocation.lastIndexOf('/') + 1);

const createNav = () => {
    return `
        <div class="sidebar-header text-center">
            <img src="../../../assets/img/TCS-logo.png" alt="" class="tcs-logo img-fluid">
        </div>

        <div class="sidebar-header-text p-2">
            <p class="custom-font fw-bold fs-2">Taiwanese Chamber of the South Phils</p>
        </div>

        <!-- Sidebar Links -->
        <div class="sidebar-links p-2">
            <ul class="list-unstyled">
                <li><a href="${scriptComponentDir}../src/pages_protected/blog_protected/blog_protected.html" class="nav-link"><i class="bi bi-journal-text"></i> Blog</a></li>
                <li><a href="${scriptComponentDir}../src/pages_protected/org-chart_protected/org-chart_protected.html" class="nav-link"><i class="bi bi-people-fill"></i> Org-Chart</a></li>
                <li><a href="${scriptComponentDir}../src/pages_protected/companies_protected/companies_protected.html" class="nav-link"><i class="bi bi-building-check"></i> Companies</a></li>
                <li><a href="${scriptComponentDir}../src/pages_protected/activities_protected/activities_protected.html" class="nav-link"><i class="bi bi-calendar-event"></i> Events</a></li>
                <li><a href="${scriptComponentDir}../src/pages_protected/news_protected/news_protected.html" class="nav-link"><i class="bi bi-newspaper"></i> News</a></li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer p-3 text-center">
            <p>&copy; 2025 Taiwanese Chamber of the South Philippines. All Rights Reserved.</p>
        </div>
    `;
};

// Add event listener once the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Gets the sidebar element
    const nav = document.getElementById('sidebar');

    // Append the new HTML directly into the sidebar without removing existing content
    nav.insertAdjacentHTML('beforeend', createNav());

    // Highlight the active nav link
    const currentPage = window.location.pathname.split('/').pop();  // Get the current page filename
    const navLinks = nav.querySelectorAll('.nav-link');  // Select the links with the 'nav-link' class

    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href').split('/').pop();  // Extract the filename from the href
        
        // Compare the current page with the nav link href
        if (linkHref === currentPage) {
            link.classList.add('active');  // Add the 'active' class to the matching link
        } else {
            link.classList.remove('active');  // Ensure 'active' is removed from other links
        }
    });
});
