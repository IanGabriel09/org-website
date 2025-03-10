const scriptComponentLocation = document.currentScript.src;
const scriptComponentDir = scriptComponentLocation.substring(0, scriptComponentLocation.lastIndexOf('/') + 1);

// Creates Foot component
const createFoot = () => {
    const foot = document.createElement('div');
    foot.innerHTML = `
    <div class="footer footer-bg-color p-5">
        <div class="container">
            <div class="d-lg-flex d-md-block">
                <div class="col-md-3 col-sm-12 mb-3">
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/about/about.html" class="custom-text-color text-decoration-underline">About Us</a></div>
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/orgChart/orgChart.html" class="custom-text-color text-decoration-underline">Org Chart</a></div>
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/companies/companies.html" class="custom-text-color text-decoration-underline">Companies</a></div>
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/activity/activity.html" class="custom-text-color text-decoration-underline">Activity</a></div>
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/news/news.html" class="custom-text-color text-decoration-underline">News</a></div>
                    <div class="mb-1"><a href="${scriptComponentDir}../src/pages/members/members.html" class="custom-text-color text-decoration-underline">Members</a></div>
                </div>

                <div class="col-md-3 col-sm-12 mb-3">
                    <div class="mb-3 d-flex align-items-center"><i class="custom-text-color fs-3 bi bi-facebook"></i> <a href="#" class="custom-text-color mx-2 text-decoration-none">Facebook</a></div>
                    <div class="mb-3 d-flex align-items-center"><i class="custom-text-color fs-3 bi bi-instagram"></i> <a href="#" class="custom-text-color mx-2 text-decoration-none">Instagram</a></div>
                    <div class="mb-3 d-flex align-items-center"><i class="custom-text-color fs-3 bi bi-twitter-x"></i> <a href="#" class="custom-text-color mx-2 text-decoration-none">Twitter-X</a></div>
                </div>

                <div class="col-md-3 col-sm-12 mb-3">
                    <p class="custom-text-color lead fw-bold m-0">Contacts & Address</p>
                    <p class="custom-text-color m-0">+123-456-789</p>
                    <p class="custom-text-color"> 307-A J. Figueras Street, Sampaloc Manila</p>
                    <p class="custom-text-color m-0">Open Monday-Saturday</p>
                    <p class="custom-text-color">8:00 AM to 5:00 PM</p>
                </div>

                <div class="col-md-3 col-sm-12 mb-3 text-center">
                    <img src="https://placehold.co/200x100" alt="" class="img-fluid foot-img">
                    <p class="custom-text-color lead mt-1 mb-0">PRIVACY POLICY</p>
                    <p class="custom-text-color custom-text-sm">© 2025 Sample Company , ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </div>
    `;

    return foot;
};


const createNav = () => {
    const nav = document.createElement('div');
    nav.innerHTML = `
        <nav class="navbar navbar-expand-lg bg-body-tertiary custom-box-shadow">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <img src="${scriptComponentDir}../assets/img/TCS-logo.png" alt="" class="nav-logo img-fluid">
                    <a class="navbar-brand" href="${scriptComponentDir}../index.html"><h4>Taiwanese chamber <br> of the South Phils</h4></a>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse py-2" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/about/about.html">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/orgChart/orgChart.html">Org Chart</a></li>
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/companies/companies.html">Companies</a></li>
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/activity/activity.html">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/news/news.html">News</a></li>
                        <li class="nav-item"><a class="nav-link" href="${scriptComponentDir}../src/pages/members/members.html">Members</a></li>
                    </ul>

                    <div id="authContainer" class="d-flex align-items-center">
                        <div id="auth" class="d-none">
                            <a href="${scriptComponentDir}../src/pages/_auth/auth.html" class="btn btn-outline-primary">Sign-In</a>
                            <a href="${scriptComponentDir}../src/pages/_auth/register.html" class="btn btn-outline-primary ms-2">Register</a>
                        </div>

                        <div id="logOut" class="d-none px-3">
                            <a href="${scriptComponentDir}../src/pages/_auth/auth.html"><i class="bi bi-box-arrow-right fs-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    `;

    // Highlight the active nav link
    const currentPage = window.location.pathname.split('/').pop();  // Get the current page filename
    const navLinks = nav.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href').split('/').pop();  // Extract the filename from the href
        
        // Special case for orgChart or viewOrg.html
        if (linkHref === 'orgChart.html' || linkHref === 'viewOrg.html') {
            if (currentPage === 'orgChart.html' || currentPage === 'viewOrg.html') {
                link.classList.add('active');
            }
        } else if (linkHref === currentPage) {
            link.classList.add('active');  // Add the 'active' class to the matching link
        }
    });

    return nav;
};


document.addEventListener('DOMContentLoaded', function() {
    // Gets foot component
    const footer = document.getElementById('footer');
    const footerContent = createFoot();

    // Gets Nav component
    const nav = document.getElementById('nav');
    const navContent = createNav();

    // Reusable components
    nav.appendChild(navContent);
    footer.appendChild(footerContent);
});
