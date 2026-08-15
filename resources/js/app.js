const toggleNavbar = () => {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;

    const scrolled = window.scrollY > 12;

    const isLanding = document.body.classList.contains('landing-agency');
    if (isLanding) {
        navbar.classList.toggle('navbar--scrolled', scrolled);
        return;
    }

    navbar.classList.toggle('bg-white/75', scrolled);
    navbar.classList.toggle('backdrop-blur-xl', scrolled);
    navbar.classList.toggle('border-slate-200/60', scrolled);
    navbar.classList.toggle('shadow-sm', scrolled);
};

const initMobileMenu = () => {
    // State menu mobile dikelola secara reaktif dan mulus oleh Alpine.js di marketing-header.blade.php
};

const initAdminSidebar = () => {
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const openBtn = document.querySelector('[data-admin-sidebar-open]');
    const closeBtn = document.querySelector('[data-admin-sidebar-close]');
    const backdrop = document.querySelector('[data-admin-backdrop]');

    if (!sidebar || !openBtn) return;

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        backdrop?.classList.remove('hidden');
        document.documentElement.classList.add('overflow-hidden');
    };

    const close = () => {
        sidebar.classList.add('-translate-x-full');
        backdrop?.classList.add('hidden');
        document.documentElement.classList.remove('overflow-hidden');
    };

    openBtn.addEventListener('click', open);
    closeBtn?.addEventListener('click', close);
    backdrop?.addEventListener('click', close);

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
};

const initReveal = () => {
    const nodes = document.querySelectorAll('.reveal');
    if (!nodes.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        nodes.forEach((n) => n.classList.add('reveal--show'));
        return;
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('reveal--show');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 }
    );

    nodes.forEach((n) => io.observe(n));
};

const initCounters = () => {
    const nodes = document.querySelectorAll('[data-counter-target]');
    if (!nodes.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        nodes.forEach((n) => {
            const target = Number(n.getAttribute('data-counter-target') || '0');
            n.textContent = String(Number.isFinite(target) ? target : 0);
        });
        return;
    }

    const animate = (node) => {
        const target = Number(node.getAttribute('data-counter-target') || '0');
        if (!Number.isFinite(target) || target <= 0) return;

        const duration = 1100;
        const startTime = performance.now();
        const ease = (t) => 1 - Math.pow(1 - t, 3);

        const step = (now) => {
            const t = Math.min(1, (now - startTime) / duration);
            const value = Math.round(target * ease(t));
            node.textContent = String(value);
            if (t < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
    };

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    animate(e.target);
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.25 }
    );

    nodes.forEach((n) => io.observe(n));
};

const animateScrollTop = (el, to, duration) => {
    const start = el.scrollTop;
    const change = to - start;
    const startTime = performance.now();

    const ease = (t) => (t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2);

    const step = (now) => {
        const elapsed = now - startTime;
        const t = Math.min(1, elapsed / duration);
        el.scrollTop = start + change * ease(t);
        if (t < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
};

const initHoverShots = () => {
    const shots = document.querySelectorAll('[data-hover-shot]');
    if (!shots.length) return;

    shots.forEach((shot) => {
        const card = shot.closest('.group') || shot;
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Guarantee image starts at the very top (no center crop)
        shot.scrollTop = 0;

        const scrollTo = (to) => {
            if (prefersReducedMotion) {
                shot.scrollTop = to;
                return;
            }

            animateScrollTop(shot, to, 1800);
        };

        card.addEventListener('mouseenter', () => {
            const maxScroll = Math.max(0, shot.scrollHeight - shot.clientHeight);
            if (maxScroll > 0) {
                scrollTo(maxScroll);
            }
        });

        card.addEventListener('mouseleave', () => {
            scrollTo(0);
        });
    });
};

const initCarousel = () => {
    const roots = document.querySelectorAll('[data-carousel]');
    if (!roots.length) return;

    roots.forEach((root) => {
        const track = root.querySelector('[data-carousel-track]');
        if (!track) return;

        const prevBtn = root.querySelector('[data-carousel-prev]');
        const nextBtn = root.querySelector('[data-carousel-next]');
        const dots = root.querySelector('[data-carousel-dots]');

        const getScrollDistance = () => {
            const firstChild = track.firstElementChild;
            if (firstChild) {
                const style = window.getComputedStyle(track);
                const gap = parseInt(style.gap || '24') || 24;
                return firstChild.getBoundingClientRect().width + gap;
            }
            return track.clientWidth * 0.85;
        };

        if (prevBtn) {
            prevBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                const dist = getScrollDistance();
                if (track.scrollLeft <= 10) {
                    track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: -dist, behavior: 'smooth' });
                }
            };
        }

        if (nextBtn) {
            nextBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                const dist = getScrollDistance();
                const maxScroll = track.scrollWidth - track.clientWidth;
                if (track.scrollLeft >= maxScroll - 10) {
                    track.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: dist, behavior: 'smooth' });
                }
            };
        }

        // Mouse Drag to Scroll
        let isMouseDown = false;
        let startX = 0;
        let scrollLeftStart = 0;
        let hasDragged = false;

        track.style.cursor = 'grab';

        track.onmousedown = (e) => {
            if (e.button !== 0) return;
            isMouseDown = true;
            hasDragged = false;
            startX = e.pageX - track.offsetLeft;
            scrollLeftStart = track.scrollLeft;
            track.style.scrollBehavior = 'auto';
            track.style.userSelect = 'none';
            track.style.cursor = 'grabbing';
        };

        window.onmousemove = (e) => {
            if (!isMouseDown) return;
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.25;
            if (Math.abs(walk) > 4) {
                hasDragged = true;
            }
            track.scrollLeft = scrollLeftStart - walk;
        };

        const handleDragEnd = () => {
            if (!isMouseDown) return;
            isMouseDown = false;
            track.style.scrollBehavior = 'smooth';
            track.style.removeProperty('user-select');
            track.style.cursor = 'grab';
        };

        window.onmouseup = handleDragEnd;

        track.onclick = (e) => {
            if (hasDragged) {
                e.preventDefault();
                e.stopPropagation();
                hasDragged = false;
            }
        };
    });
};

document.addEventListener('DOMContentLoaded', () => {
    document.documentElement.classList.add('js');
    toggleNavbar();
    initMobileMenu();
    initAdminSidebar();
    initReveal();
    initCounters();
    initCarousel();
    initHoverShots();

    window.addEventListener('scroll', toggleNavbar, { passive: true });
});

document.addEventListener('livewire:navigated', () => {
    document.documentElement.classList.add('js');
    toggleNavbar();
    initMobileMenu();
    initAdminSidebar();
    initReveal();
    initCounters();
    initCarousel();
    initHoverShots();
});
