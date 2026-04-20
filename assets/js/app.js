/**
 * SUI Innova GmbH — Frontend JavaScript
 */

// =============================================
// Header Scroll (Transparent → Weiss)
// =============================================
function headerScroll(isHomepage) {
    return {
        scrolled: !isHomepage,
        mobileMenuOpen: false,

        init() {
            if (!isHomepage) {
                this.scrolled = true;
                return;
            }

            const update = () => {
                this.scrolled = window.scrollY > 50;
            };

            window.addEventListener('scroll', update, { passive: true });
            update();
        }
    };
}

// =============================================
// DOMContentLoaded
// =============================================
document.addEventListener('DOMContentLoaded', () => {

    // --- Smooth Scroll fuer Anker-Links ---
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', (e) => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const headerHeight = document.querySelector('header')?.offsetHeight || 68;
                const top = target.getBoundingClientRect().top + window.scrollY - headerHeight;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    // --- Intersection Observer fuer Einblend-Animationen ---
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
        );

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    }

    // --- Mobile Parallax ---
    const parallaxImages = document.querySelectorAll('[data-parallax]');
    if (parallaxImages.length > 0) {
        const updateParallax = () => {
            parallaxImages.forEach(img => {
                const section = img.parentElement;
                const rect = section.getBoundingClientRect();
                const windowH = window.innerHeight;

                // Nur wenn sichtbar
                if (rect.bottom > 0 && rect.top < windowH) {
                    // -1 bis 1: wo ist die Section im Viewport
                    const progress = (rect.top + rect.height / 2 - windowH / 2) / windowH;
                    // Bild verschieben (max ±15%)
                    const translateY = progress * -15;
                    img.style.transform = `translateY(${translateY}%)`;
                }
            });
        };

        window.addEventListener('scroll', updateParallax, { passive: true });
        updateParallax();
    }
});
