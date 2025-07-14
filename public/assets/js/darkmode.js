document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('darkToggle');
  toggle?.addEventListener('click', () => {
    document.body.classList.toggle('dark');
    localStorage.setItem('darkMode', document.body.classList.contains('dark'));
  });

  if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark');
  }
});