document.addEventListener("DOMContentLoaded", function() {
  const nav = document.querySelector('.main-navigation');
  const toggleButton = document.createElement('button');
  toggleButton.classList.add('menu-toggle');
  toggleButton.setAttribute('aria-expanded', 'false');
  toggleButton.innerText = 'Menu';

  nav.parentNode.insertBefore(toggleButton, nav);

  toggleButton.addEventListener('click', () => {
    const expanded = toggleButton.getAttribute('aria-expanded') === 'true';
    toggleButton.setAttribute('aria-expanded', String(!expanded));
    nav.classList.toggle('active');
  });

  const subMenus = nav.querySelectorAll('.menu-item-has-children > a');
  subMenus.forEach(link => {
    link.addEventListener('click', e => {
      const parent = link.parentNode;
      const submenu = parent.querySelector('.sub-menu');
      if (submenu) {
        e.preventDefault();
        const expanded = link.getAttribute('aria-expanded') === 'true';
        link.setAttribute('aria-expanded', String(!expanded));
        submenu.style.display = expanded ? 'none' : 'block';
      }
    });
  });
});
