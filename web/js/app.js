/* Theme Name: Admiria - Admin Dashboard & Frontend Template
   Author: Themesbrand
   File Description:Main JS file of the template
*/



//  Window scroll sticky class add

function windowScroll() {
    const navbar = document.getElementById("navbar-example");
    if (
        document.body.scrollTop >= 50 ||
        document.documentElement.scrollTop >= 50
    ) {
        navbar.classList.add("is-sticky");
    } else {
        navbar.classList.remove("is-sticky");
    }
}

window.addEventListener('scroll', (ev) => {
    ev.preventDefault();
    windowScroll();
})



// GLightbox Popup

const lightbox = GLightbox({
    selector: '.image-popup'
});