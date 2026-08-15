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
        const dots = root.querySelector('[data-carousel-dots]');
        if (!track) return;

        const originalSlides = [...track.children];
        const N = originalSlides.length;
        if (N <= 1) return;

        const theme = root.getAttribute('data-carousel-theme') || 'light';
        const autoplay = root.getAttribute('data-carousel-autoplay') !== 'false';
        const loop = root.getAttribute('data-carousel-loop') !== 'false';
        const featuredCenter = root.getAttribute('data-carousel-featured-center') === 'true';
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        let slides = originalSlides;
        const isLooping = loop && N > 1;

        if (isLooping) {
            track.innerHTML = '';
            const set0 = originalSlides.map((el) => el.cloneNode(true));
            const set1 = originalSlides.map((el) => el.cloneNode(true));
            const set2 = originalSlides.map((el) => el.cloneNode(true));

            set0.forEach((el) => track.appendChild(el));
            set1.forEach((el) => track.appendChild(el));
            set2.forEach((el) => track.appendChild(el));

            slides = [...track.children];
        }

        let currentIndex = isLooping ? N : 0;
        let isAnimating = false;
        let animationTimeout = null;

        const prevBtn = root.querySelector('[data-carousel-prev]');
        const nextBtn = root.querySelector('[data-carousel-next]');

        const getWSet = () => {
            if (!isLooping) return 0;
            return slides[N] && slides[0] ? slides[N].offsetLeft - slides[0].offsetLeft : 0;
        };

        const syncFeatured = (currIndex) => {
            if (!featuredCenter) return;

            const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
            slides.forEach((slide) => {
                slide.querySelector('[data-carousel-feature-card]')?.classList.remove('agency-service-card--featured');
            });

            if (!isDesktop || N < 3) return;

            const idx = typeof currIndex === 'number' ? currIndex : currentIndex;
            const centerIndex = isLooping
                ? Math.max(0, Math.min(idx + 1, slides.length - 1))
                : Math.max(0, Math.min(idx + 1, slides.length - 1));

            slides[centerIndex]?.querySelector('[data-carousel-feature-card]')?.classList.add('agency-service-card--featured');
        };

        const syncDots = (currIndex) => {
            if (!dots) return;
            const activeDot = isLooping ? ((currIndex % N) + N) % N : currIndex;
            dots.querySelectorAll('button').forEach((btn, i) => {
                const active = i === activeDot;
                if (theme === 'dark') {
                    btn.classList.toggle('bg-white', active);
                    btn.classList.toggle('bg-white/25', !active);
                } else {
                    btn.classList.toggle('bg-slate-900', active);
                    btn.classList.toggle('bg-slate-300/70', !active);
                }
                btn.setAttribute('aria-current', active ? 'true' : 'false');
            });
        };

        const normalizeBoundaryInstant = () => {
            if (!isLooping) return;
            const wSet = getWSet();
            if (wSet <= 0) return;

            if (currentIndex >= 2 * N) {
                currentIndex = currentIndex - N;
                track.style.scrollBehavior = 'auto';
                track.scrollLeft = slides[currentIndex].offsetLeft;
                track.style.scrollBehavior = '';
            } else if (currentIndex < N) {
                currentIndex = currentIndex + N;
                track.style.scrollBehavior = 'auto';
                track.scrollLeft = slides[currentIndex].offsetLeft;
                track.style.scrollBehavior = '';
            }
        };

        const scrollToTarget = (targetIdx, behavior = 'smooth') => {
            const slide = slides[targetIdx];
            if (!slide) return;

            currentIndex = targetIdx;
            isAnimating = behavior === 'smooth' && !prefersReducedMotion;

            track.scrollTo({ left: slide.offsetLeft, behavior: prefersReducedMotion ? 'auto' : behavior });

            syncDots(currentIndex);
            syncFeatured(currentIndex);

            if (animationTimeout) clearTimeout(animationTimeout);
            animationTimeout = setTimeout(() => {
                isAnimating = false;
                normalizeBoundaryInstant();
                syncDots(currentIndex);
                syncFeatured(currentIndex);
            }, prefersReducedMotion ? 50 : 380);
        };

        // Initialize Dots
        if (dots) {
            dots.innerHTML = '';
            for (let i = 0; i < N; i++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'h-2.5 w-2.5 rounded-full transition';
                btn.addEventListener('click', () => {
                    if (isAnimating) return;
                    const currentDot = ((currentIndex % N) + N) % N;
                    let step = i - currentDot;
                    if (step < 0) step += N;
                    scrollToTarget(currentIndex + step, 'smooth');
                });
                dots.appendChild(btn);
            }
        }

        prevBtn?.addEventListener('click', () => {
            if (isAnimating) return;
            const step = 1;
            scrollToTarget(currentIndex - step, 'smooth');
        });

        nextBtn?.addEventListener('click', () => {
            if (isAnimating) return;
            const step = 1;
            scrollToTarget(currentIndex + step, 'smooth');
        });

        // Mouse Drag to Scroll (Desktop)
        let isMouseDown = false;
        let startX = 0;
        let scrollLeftStart = 0;
        let hasDragged = false;

        track.style.cursor = 'grab';

        track.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return;
            isMouseDown = true;
            hasDragged = false;
            startX = e.pageX - track.offsetLeft;
            scrollLeftStart = track.scrollLeft;
            track.style.scrollBehavior = 'auto';
            track.style.userSelect = 'none';
            track.style.cursor = 'grabbing';
        });

        window.addEventListener('mousemove', (e) => {
            if (!isMouseDown) return;
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.1;
            if (Math.abs(walk) > 5) {
                hasDragged = true;
            }
            track.scrollLeft = scrollLeftStart - walk;
        });

        const handleDragEnd = () => {
            if (!isMouseDown) return;
            isMouseDown = false;
            track.style.scrollBehavior = '';
            track.style.removeProperty('user-select');
            track.style.cursor = 'grab';
            if (hasDragged) {
                const centered = getCenteredIndex();
                currentIndex = centered;
                normalizeBoundaryInstant();
                syncDots(currentIndex);
                syncFeatured(currentIndex);
            }
        };

        window.addEventListener('mouseup', handleDragEnd);

        track.addEventListener('click', (e) => {
            if (hasDragged) {
                e.preventDefault();
                e.stopPropagation();
                hasDragged = false;
            }
        }, true);

        // Scroll listener for manual swipe / scroll
        let raf = null;
        track.addEventListener(
            'scroll',
            () => {
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(() => {
                    if (!isAnimating && !isMouseDown) {
                        const centered = getCenteredIndex();
                        const wSet = getWSet();
                        if (wSet > 0 && isLooping) {
                            if (track.scrollLeft >= 2 * wSet) {
                                track.scrollLeft -= wSet;
                                currentIndex = getCenteredIndex();
                            } else if (track.scrollLeft <= 0.2 * wSet) {
                                track.scrollLeft += wSet;
                                currentIndex = getCenteredIndex();
                            } else {
                                currentIndex = centered;
                            }
                        } else {
                            currentIndex = centered;
                        }
                        syncDots(currentIndex);
                        syncFeatured(currentIndex);
                    }
                });
            },
            { passive: true }
        );

        window.addEventListener('resize', () => {
            scrollToTarget(currentIndex, 'auto');
        });

        if (isLooping) {
            requestAnimationFrame(() => {
                currentIndex = N;
                const initialTarget = slides[N];
                if (initialTarget) {
                    track.style.scrollBehavior = 'auto';
                    track.scrollLeft = initialTarget.offsetLeft;
                    track.style.scrollBehavior = '';
                }
                syncDots(currentIndex);
                syncFeatured(currentIndex);
            });
        } else {
            scrollToTarget(0, 'auto');
        }
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
