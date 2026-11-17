/**
 * BRIDA Kota Makassar - Main Application Script
 * Mengelola pembersihan transparansi logo, navigasi mobile, smooth scrolling, dan interaksi UI
 */

document.addEventListener('DOMContentLoaded', () => {
    // 0. Auto-Remove White Background from Logo Image (Menjadikan Logo 100% Transparan & Menyatu)
    const logoImg = document.getElementById('brida-logo');
    if (logoImg) {
        const processLogo = () => {
            try {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = logoImg.naturalWidth || logoImg.width;
                canvas.height = logoImg.naturalHeight || logoImg.height;

                if (canvas.width > 0 && canvas.height > 0) {
                    ctx.drawImage(logoImg, 0, 0);
                    const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const d = imgData.data;

                    for (let i = 0; i < d.length; i += 4) {
                        const r = d[i];
                        const g = d[i + 1];
                        const b = d[i + 2];
                        if (r > 235 && g > 235 && b > 235) {
                            d[i + 3] = 0;
                        }
                    }

                    ctx.putImageData(imgData, 0, 0);
                    logoImg.src = canvas.toDataURL('image/png');
                }
            } catch (err) {
                // Jika canvas dibatasi, mix-blend-multiply tetap menjaga logo menyatu
            }
        };

        if (logoImg.complete && logoImg.naturalWidth !== 0) {
            processLogo();
        } else {
            logoImg.addEventListener('load', processLogo, { once: true });
        }
    }

    // 1. Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Tutup menu mobile ketika link di-klik
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // 2. Mobile Submenu Accordion
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    mobileDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const submenu = toggle.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('hidden');
                const icon = toggle.querySelector('.fa-chevron-down');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            }
        });
    });

    // 3. Smooth Anchor Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '') return;
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // 4. Hero Background Slideshow Controller (Rotasi Gambar Otomatis Tiap 5 Detik)
    const heroSlides = document.querySelectorAll('.hero-slide');
    if (heroSlides.length > 1) {
        let currentSlideIdx = 0;
        setInterval(() => {
            heroSlides[currentSlideIdx].classList.remove('active');
            currentSlideIdx = (currentSlideIdx + 1) % heroSlides.length;
            heroSlides[currentSlideIdx].classList.add('active');
        }, 5000);
    }

    console.log('BRIDA Kota Makassar: Portal Scripts Initialized.');
});
