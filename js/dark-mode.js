// Dark mode functionality
const darkModeToggle = document.getElementById('darkModeToggle');
const theme = localStorage.getItem('theme');

// Check for saved theme preference or default to light
if (theme) {
    document.documentElement.setAttribute('data-theme', theme);
    if (theme === 'dark') {
        darkModeToggle.checked = true;
    }
}

// Toggle dark mode
function toggleDarkMode(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

// Add event listener to toggle
darkModeToggle.addEventListener('change', toggleDarkMode);

// Add system theme preference detection
const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

function handleSystemThemeChange(e) {
    if (!localStorage.getItem('theme')) {
        if (e.matches) {
            document.documentElement.setAttribute('data-theme', 'dark');
            darkModeToggle.checked = true;
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            darkModeToggle.checked = false;
        }
    }
}

prefersDarkScheme.addListener(handleSystemThemeChange); 