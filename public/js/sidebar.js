document.addEventListener('DOMContentLoaded', function() {
    // Encontra todos os itens do menu que têm submenus
    const menuItems = document.querySelectorAll('.nav-item');

    menuItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        const submenu = item.querySelector('ul');

        if (submenu) {
            // Adiciona um indicador de submenu
            if (!link.querySelector('.submenu-indicator')) {
                const indicator = document.createElement('i');
                indicator.className = 'fas fa-chevron-right submenu-indicator ms-auto';
                link.appendChild(indicator);
            }

            // Adiciona evento de clique para mostrar/esconder submenu em dispositivos móveis
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                    indicator.classList.toggle('fa-chevron-down');
                    indicator.classList.toggle('fa-chevron-right');
                }
            });
        }
    });

    // Adiciona evento para fechar o menu em dispositivos móveis quando clicar fora
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const sidebar = document.querySelector('.sidebar');
            const target = e.target;

            if (!sidebar.contains(target) && !target.closest('.navbar-toggler')) {
                const submenus = sidebar.querySelectorAll('.nav-item ul');
                submenus.forEach(submenu => {
                    submenu.style.display = 'none';
                });

                const indicators = sidebar.querySelectorAll('.submenu-indicator');
                indicators.forEach(indicator => {
                    indicator.classList.remove('fa-chevron-down');
                    indicator.classList.add('fa-chevron-right');
                });
            }
        }
    });

    // Marca o item atual como ativo
    const currentPath = window.location.pathname;
    const links = document.querySelectorAll('.nav-link');

    links.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            
            // Expande os menus pais
            let parent = link.closest('.nav-item').parentElement;
            while (parent && parent.classList.contains('nav-item')) {
                const parentLink = parent.querySelector('.nav-link');
                parentLink.classList.add('active');
                parent = parent.parentElement;
            }
        }
    });
});
