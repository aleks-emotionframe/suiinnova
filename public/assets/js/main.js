/**
 * SUI Innova GmbH — Main JavaScript
 */
(function () {
    'use strict';

    // --- Header scroll effect ---
    const header = document.getElementById('site-header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', function () {
            const y = window.scrollY;
            header.classList.toggle('is-scrolled', y > 40);
            lastScroll = y;
        }, { passive: true });
    }

    // --- Mobile navigation ---
    const toggle = document.getElementById('nav-toggle');
    const nav = document.getElementById('main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            const open = toggle.classList.toggle('is-open');
            nav.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open);
            document.body.style.overflow = open ? 'hidden' : '';
        });

        // Close on link click
        nav.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                toggle.classList.remove('is-open');
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) {
                toggle.classList.remove('is-open');
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                toggle.focus();
            }
        });
    }

    // --- Scroll Reveal ---
    var reveals = document.querySelectorAll('[data-reveal]');
    if (reveals.length > 0 && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        reveals.forEach(function (el) { observer.observe(el); });
    } else {
        // Fallback: show all
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
    }

    // --- Project filter (Referenzen page) ---
    var filterBtns = document.querySelectorAll('.filter-btn');
    var projectCards = document.querySelectorAll('.project-card');
    if (filterBtns.length > 0 && projectCards.length > 0) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var filter = btn.getAttribute('data-filter');

                filterBtns.forEach(function (b) { b.classList.remove('is-active'); });
                btn.classList.add('is-active');

                projectCards.forEach(function (card) {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.classList.remove('is-hidden');
                        card.style.display = '';
                    } else {
                        card.classList.add('is-hidden');
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // --- Contact form validation ---
    var form = document.querySelector('.contact-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            var name = form.querySelector('#name');
            var email = form.querySelector('#email');
            var message = form.querySelector('#message');
            var valid = true;

            [name, email, message].forEach(function (input) {
                if (input && !input.value.trim()) {
                    input.style.borderColor = '#b03a2e';
                    valid = false;
                } else if (input) {
                    input.style.borderColor = '';
                }
            });

            if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.style.borderColor = '#b03a2e';
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    // --- Smooth scroll for anchor links ---
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
