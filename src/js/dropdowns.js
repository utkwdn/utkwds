const toggles = document.querySelectorAll('[data-toggle="dropdown"]');

toggles.forEach(toggle => {
	const menu = toggle.nextElementSibling;


	toggle.addEventListener('click', (e) => {
		e.stopPropagation();

		document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
          	if (openMenu !== menu) {
            	openMenu.classList.remove('show');
				const otherToggle = openMenu.previousElementSibling;
				if (otherToggle) {
					otherToggle.setAttribute('aria-expanded', 'false');
				}
          	}
        });

		const isOpen = menu.classList.toggle('show');
    	toggle.setAttribute('aria-expanded', isOpen.toString());
	});

	menu.addEventListener('click', (e) => {
		if (e.target.classList.contains('dropdown-item')) {
			menu.classList.remove('show');
			toggle.setAttribute('aria-expanded', 'false');
		}
	});
});

document.addEventListener('click', () => {
	document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
        menu.classList.remove('show');
		const toggle = menu.previousElementSibling;
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'false');
		}
    });
});