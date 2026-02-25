(function () {
  // --- Password show/hide (supports both fields) ---
  function bindPwToggle(inputId, btnId){
    const input = document.getElementById(inputId);
    const btn   = document.getElementById(btnId);
    btn?.addEventListener('click', () => {
      if (!input) return;
      const isPwd = input.type === 'password';
      input.type  = isPwd ? 'text' : 'password';
      btn.title   = isPwd ? 'Hide password' : 'Show password';
    });
  }
  bindPwToggle('password', 'passwordToggle');
  bindPwToggle('password_confirmation', 'confirmToggle');

  // --- Submit loader (login/register উভয়ের জন্য কাজ করবে) ---
  function bindSubmit(formId, btnId){
    const form = document.getElementById(formId);
    const btn  = document.getElementById(btnId);
    form?.addEventListener('submit', () => {
      btn?.setAttribute('aria-busy','true');
      btn?.setAttribute('disabled','disabled');
    });
  }
  bindSubmit('loginForm','submitBtn');
  bindSubmit('registerForm','registerBtn');

  // --- Theme toggle ---
  const root = document.documentElement;
  const themeBtn = document.getElementById('themeToggle');
  function setIcon(theme){ themeBtn.textContent = theme === 'dark' ? '☀️' : '🌙'; }
  function setTheme(next){ root.setAttribute('data-theme',next); localStorage.setItem('theme',next); setIcon(next); }
  setIcon(root.getAttribute('data-theme') || 'dark');
  themeBtn?.addEventListener('click', () => {
    const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    setTheme(next);
  });
})();
