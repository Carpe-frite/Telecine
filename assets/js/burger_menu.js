document.addEventListener('turbo:load', () => {
    const burger_button = document.getElementById("burger-button");
    const menu_content = document.getElementById("menu-content");

    burger_button.addEventListener('click', () => {
          menu_content.classList.toggle('hidden');
        menu_content.classList.toggle('flex');
    });

    document.addEventListener('click', (e) => {
        if (!burger_button.contains(e.target) && !menu_content.contains(e.target)) {
            menu_content.classList.add('hidden');
            menu_content.classList.remove('flex');
        }
    });
});