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
    const toggle = document.querySelector('[data-mobile-toggle="true"]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    menu.querySelectorAll('a').forEach((a) => {
        a.addEventListener('click', () => {
            menu.classList.add('hidden');
        });
    });
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
        if (!track || !dots) return;

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

        let index = isLooping ? N : 0;
        let timer = null;
        let resumeTimer = null;
        let isAnimating = false;
        let animationTimeout = null;

        const prevBtn = root.querySelector('[data-carousel-prev]');
        const nextBtn = root.querySelector('[data-carousel-next]');

        const getWSet = () => {
            if (!isLooping) return 0;
            return slides[N] && slides[0] ? slides[N].offsetLeft - slides[0].offsetLeft : 0;
        };

        const getCenteredIndex = () => {
            const current = track.scrollLeft;
            let best = 0;
            let bestDist = Infinity;
            slides.forEach((el, i) => {
                const dist = Math.abs(el.offsetLeft - current);
                if (dist < bestDist) {
                    bestDist = dist;
                    best = i;
                }
            });
            return best;
        };

        const syncFeatured = (currIndex) => {
            if (!featuredCenter) return;

            const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
            slides.forEach((slide) => {
                slide.querySelector('[data-carousel-feature-card]')?.classList.remove('agency-service-card--featured');
            });

            if (!isDesktop || N < 3) return;

            const centerIndex = isLooping
                ? Math.max(1, Math.min(currIndex + 1, slides.length - 2))
                : Math.max(1, Math.min(currIndex + 1, slides.length - 2));

            slides[centerIndex]?.querySelector('[data-carousel-feature-card]')?.classList.add('agency-service-card--featured');
        };

        const syncDots = (currIndex) => {
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

        const syncArrows = (currIndex) => {
            if (isLooping) return;
            prevBtn?.toggleAttribute('disabled', currIndex <= 0);
            nextBtn?.toggleAttribute('disabled', currIndex >= slides.length - 1);
            prevBtn?.classList.toggle('opacity-40', currIndex <= 0);
            nextBtn?.classList.toggle('opacity-40', currIndex >= slides.length - 1);
            prevBtn?.classList.toggle('cursor-not-allowed', currIndex <= 0);
            nextBtn?.classList.toggle('cursor-not-allowed', currIndex >= slides.length - 1);
        };

        const checkBoundaryAndNormalize = () => {
            if (!isLooping) return;
            const wSet = getWSet();
            if (wSet <= 0) return;

            const current = track.scrollLeft;
            if (current >= wSet * 1.5) {
                track.scrollLeft -= wSet;
            } else if (current < wSet * 0.5) {
                track.scrollLeft += wSet;
            }
        };

        const goTo = (targetIndex, behavior = 'smooth') => {
            let target = targetIndex;
            if (!isLooping) {
                target = Math.max(0, Math.min(targetIndex, slides.length - 1));
            }

            const slide = slides[target];
            if (!slide) return;

            index = target;
            isAnimating = behavior === 'smooth' && !prefersReducedMotion;

            track.scrollTo({ left: slide.offsetLeft, behavior: prefersReducedMotion ? 'auto' : behavior });

            const curr = getCenteredIndex();
            syncDots(curr);
            syncFeatured(curr);
            syncArrows(curr);

            if (animationTimeout) clearTimeout(animationTimeout);
            animationTimeout = setTimeout(() => {
                isAnimating = false;
                checkBoundaryAndNormalize();
                const updatedIndex = getCenteredIndex();
                index = updatedIndex;
                syncDots(updatedIndex);
                syncFeatured(updatedIndex);
            }, prefersReducedMotion ? 50 : 400);
        };

        const syncFromScroll = () => {
            const curr = getCenteredIndex();
            index = curr;
            syncDots(curr);
            syncFeatured(curr);
            syncArrows(curr);

            if (!isAnimating) {
                checkBoundaryAndNormalize();
            }
        };

        const stop = () => {
            if (timer) window.clearInterval(timer);
            timer = null;
        };

        const start = () => {
            stop();
            if (prefersReducedMotion || !autoplay) return;
            timer = window.setInterval(() => {
                const curr = getCenteredIndex();
                goTo(curr + 1);
            }, 4500);
        };

        const scheduleResume = () => {
            if (resumeTimer) window.clearTimeout(resumeTimer);
            resumeTimer = window.setTimeout(start, 5000);
        };

        dots.innerHTML = '';
        for (let i = 0; i < N; i++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'h-2.5 w-2.5 rounded-full transition';
            btn.addEventListener('click', () => {
                stop();
                const curr = getCenteredIndex();
                const currentSet = isLooping ? Math.floor(curr / N) : 0;
                const targetIdx = isLooping ? currentSet * N + i : i;
                goTo(targetIdx);
                scheduleResume();
            });
            dots.appendChild(btn);
        }

        prevBtn?.addEventListener('click', () => {
            stop();
            const curr = getCenteredIndex();
            goTo(curr - 1);
            scheduleResume();
        });

        nextBtn?.addEventListener('click', () => {
            stop();
            const curr = getCenteredIndex();
            goTo(curr + 1);
            scheduleResume();
        });

        let raf = null;
        track.addEventListener(
            'scroll',
            () => {
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(syncFromScroll);
            },
            { passive: true }
        );

        ['pointerdown', 'touchstart', 'wheel'].forEach((evt) => {
            track.addEventListener(
                evt,
                () => {
                    stop();
                    scheduleResume();
                },
                { passive: true }
            );
        });

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);

        window.addEventListener('resize', () => {
            const curr = getCenteredIndex();
            goTo(curr, 'auto');
        });

        if (isLooping) {
            requestAnimationFrame(() => {
                const initialTarget = slides[N];
                if (initialTarget) {
                    track.scrollLeft = initialTarget.offsetLeft;
                }
                const curr = getCenteredIndex();
                index = curr;
                syncDots(curr);
                syncFeatured(curr);
            });
        } else {
            goTo(0, 'auto');
        }

        start();
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
