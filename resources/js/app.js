import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar');
        const textElements = document.querySelectorAll('.text-change');

        if (window.scrollY > 50) {
          navbar.classList.remove('bg-transparent');
          navbar.classList.add('bg-softyellow', 'shadow-md');

          textElements.forEach(el => {
            el.classList.remove('text-white');
            el.classList.add('text-black');
          });
        } else {
          navbar.classList.add('bg-transparent');
          navbar.classList.remove('bg-softyellow', 'shadow-md');

          textElements.forEach(el => {
            el.classList.remove('text-black');
            el.classList.add('text-white');
          });
        }
      });

      document.addEventListener('DOMContentLoaded', () => {
        let selectedUnit = 'all';
        let selectedCategory = 'all';

        const unitButtons = document.querySelectorAll('.filter-unit-btn');
        const categoryButtons = document.querySelectorAll('.filter-category-btn');
        const artikelCards = document.querySelectorAll('.artikel-card');

        function filterCards() {
            artikelCards.forEach(card => {
                const cardUnit = card.getAttribute('data-unit');
                const cardCategory = card.querySelector('span').textContent.trim().toLowerCase();

                const matchUnit = (selectedUnit === 'all' || cardUnit === selectedUnit);
                const matchCategory = (selectedCategory === 'all' || cardCategory === selectedCategory);

                if (matchUnit && matchCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        unitButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedUnit = btn.getAttribute('data-unit');
                unitButtons.forEach(b => b.classList.remove('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500'));
                btn.classList.add('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500');
                filterCards();
            });
        });

        categoryButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedCategory = btn.getAttribute('data-category').toLowerCase();
                categoryButtons.forEach(b => b.classList.remove('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500'));
                btn.classList.add('text-yellow-500', 'font-semibold', 'border-b-2', 'border-yellow-500');
                filterCards();
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        new Glide('.glide', {
            type: 'carousel',
            autoplay: 4000,
            hoverpause: true,
            perView: 1, // Karena per slide berisi 4 kartu
            gap: 0
        }).mount();
    });
