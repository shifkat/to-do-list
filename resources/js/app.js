// --- Dark / light theme toggle ---------------------------------------------
const root = document.documentElement;
const themeToggle = document.getElementById('theme-toggle');

function applyTheme(theme) {
    root.classList.toggle('dark', theme === 'dark');
    localStorage.setItem('theme', theme);
}

themeToggle?.addEventListener('click', () => {
    applyTheme(root.classList.contains('dark') ? 'light' : 'dark');
});

// --- Feedback modal --------------------------------------------------------
const modal = document.getElementById('feedback-modal');
const openBtn = document.getElementById('feedback-open');
const closeEls = document.querySelectorAll('[data-feedback-close]');

function toggleModal(show) {
    modal?.classList.toggle('hidden', !show);
    modal?.classList.toggle('flex', show);
}

openBtn?.addEventListener('click', () => toggleModal(true));
closeEls.forEach((el) => el.addEventListener('click', () => toggleModal(false)));

// Close on backdrop click or Escape key
modal?.addEventListener('click', (e) => {
    if (e.target === modal) toggleModal(false);
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') toggleModal(false);
});

// Open automatically if validation failed on the feedback form
if (modal?.dataset.open === '1') toggleModal(true);
