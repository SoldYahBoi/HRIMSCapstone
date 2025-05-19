document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainMenu = document.getElementById('main-menu');
    
    if (mobileMenuToggle && mainMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded attribute
            this.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle the active class on the menu
            mainMenu.classList.toggle('active');
            
            // Toggle the icon
            const icon = this.querySelector('i');
            if (icon) {
                if (isExpanded) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                    
                    // Add animation to the icon
                    icon.classList.add('fa-spin');
                    setTimeout(() => {
                        icon.classList.remove('fa-spin');
                    }, 300);
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mainMenu.contains(event.target) && !mobileMenuToggle.contains(event.target) && mainMenu.classList.contains('active')) {
                mainMenu.classList.remove('active');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                
                const icon = mobileMenuToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        
        // Add current year to footer
        const currentYearElement = document.getElementById('current-year');
        if (currentYearElement) {
            currentYearElement.textContent = new Date().getFullYear();
        }
    }
});

window.toggleProfileDropdown = function(event) {
    event.stopPropagation();
    const menu = document.getElementById('profileDropdownMenu');
    if (!menu) return;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    // Close dropdown when clicking outside
    document.addEventListener('click', function handler(e) {
        if (!menu.contains(e.target)) {
            menu.style.display = 'none';
            document.removeEventListener('click', handler);
        }
    });
}