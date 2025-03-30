const scriptComponentLocation = document.currentScript.src;
const scriptComponentDir = scriptComponentLocation.substring(0, scriptComponentLocation.lastIndexOf('/') + 1);

// Creates Foot component
const createFoot = () => {
    const foot = document.createElement('div');
    foot.innerHTML = `
        <div class="footer footer-bg-color p-5">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-12">
                        <p class="lead text-white fs-3">About</p>
                        <p class="p-custom text-light lead">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem ab sint, iure laborum architecto quod in ex quisquam corporis nulla temporibus ipsa, vero earum dolorum voluptatibus maiores iusto suscipit. Temporibus.
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <p class="lead text-white fs-3">Address</p>
                        <p class="p-custom text-light">Taiwanese chamber of the south Phils. #13 , 5th street , Golden Mile Business park Carmona Cavite , Philippines</p>
                    </div>

                    <div class="col-lg-3 col-md-6 px-md-5">
                        <p class="lead text-white fs-3 m-0">Quick Links</p>
                        <div><a href="${scriptComponentDir}../src/pages/about/about.html" class="a-custom text-decoration-none">About Us</a></div>
                        <div><a href="${scriptComponentDir}../src/pages/orgChart/orgChart.html" class="a-custom text-decoration-none">Org Chart</a></div>
                        <div><a href="${scriptComponentDir}../src/pages/companies/companies.html" class="a-custom text-decoration-none">Companies</a></div>
                        <div><a href="${scriptComponentDir}../src/pages/activity/activity.html" class="a-custom text-decoration-none">Activities</a></div>
                        <div><a href="${scriptComponentDir}../src/pages/members/members.html" class="a-custom text-decoration-none">Members</a></div>
                    </div>
                </div>

                <hr class="border-white">
                <div class="text-center">
                    <p class="p-custom">© 2025 Taiwanese Chamber of the South Philippines. All Rights Reserved.</p>
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
                        <li class="nav-item"><a class="nav-link fs-5" href="${scriptComponentDir}../src/pages/about/about.html">About Us</a></li>
                        <li class="nav-item"><a class="nav-link fs-5" href="${scriptComponentDir}../src/pages/orgChart/orgChart.html">Org Chart</a></li>
                        <li class="nav-item"><a class="nav-link fs-5" href="${scriptComponentDir}../src/pages/companies/companies.html">Companies</a></li>
                        <li class="nav-item"><a class="nav-link fs-5" href="${scriptComponentDir}../src/pages/activity/activity.html">Activity</a></li>
                        <li class="nav-item"><a class="nav-link fs-5" href="${scriptComponentDir}../src/pages/members/members.html">Members</a></li>
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
