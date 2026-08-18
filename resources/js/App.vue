<script setup lang="ts">
import {
    ArrowUpRight,
    Headphones,
    Layers3,
    Mail,
    Menu,
    MonitorSmartphone,
    Phone,
    Rocket,
    Send,
    Share2,
    ShieldCheck,
    Smartphone,
    X,
} from '@lucide/vue';
import { onMounted, onUnmounted, ref } from 'vue';

const isMenuOpen = ref(false);
const languageSection = ref<HTMLElement | null>(null);
const currentYear = new Date().getFullYear();

const navItems = [
    { label: 'Home', id: 'home' },
    { label: 'Work', id: 'work' },
    { label: 'Stack', id: 'stack' },
    { label: 'Services', id: 'services' },
    { label: 'Process', id: 'process' },
    { label: 'Contact', id: 'contact' },
];

const valueCards = [
    {
        title: 'What I do',
        items: [
            'Turnkey website development',
            'Responsive design and mobile-first layouts',
            'SEO-friendly structure and performance optimization',
            'Modern UI/UX interfaces and admin panels',
        ],
    },
    {
        title: 'Why working with me is easy',
        items: [
            'Modern approach and clean execution',
            'Fast communication during the project',
            'Reasonable pricing for business websites',
            'An individual design direction for each client',
        ],
    },
];

const projects = [
    {
        title: 'Portfolio SPA',
        type: 'Vue / Laravel',
        image: '/images/projects/portfolio-spa.png',
        description:
            'One-page portfolio experience with smooth section navigation, responsive layout, and production-ready build flow.',
    },
    {
        title: 'Admin Interface',
        type: 'Dashboard UI',
        image: '/images/projects/admin-interface.png',
        description:
            'Dense but readable interface pattern for managing data, forms, states, and repeated workflows.',
    },
    {
        title: 'Landing System',
        type: 'Conversion Page',
        image: '/images/projects/landing-system.png',
        description:
            'Fast marketing page structure with clear hierarchy, reusable sections, and accessible interactions.',
    },
];

const stack = [
    'Laravel',
    'Vue 3',
    'TypeScript',
    'Vite',
    'Tailwind CSS',
    'Inertia.js',
    'REST APIs',
    'Responsive UI',
];

const languageColumns = {
    left: [
        {
            title: 'HTML.CSS',
            text: 'Semantic structure and responsive markup/Clean layouts, design systems, and responsiveness.',
        },
        {
            title: 'JavaScript',
            text: 'Interactivity, component behavior, and interface logic.',
        },
        {
            title: 'PHP',
            text: 'Server-side functionality and business logic.',
        },
        {
            title: 'UI/UX',
            text: 'Clear user flows, readable screens, thoughtful spacing, and interfaces that feel easy to use.',
        },
    ],
    right: [
        {
            title: 'Git',
            text: 'Version control, safe iteration, and collaboration.',
        },
        {
            title: 'Node.js',
            text: 'Scalable applications and custom backend features.',
        },
        {
            title: 'Laravel',
            text: 'Structured backend, CMS flows, and API work',
        },
    ],
};

const services = [
    {
        icon: MonitorSmartphone,
        title: 'Responsive Websites',
        text: 'Adaptive pages that work cleanly on desktop, tablet, and mobile without layout breaks.',
    },
    {
        icon: Layers3,
        title: 'Interface Development',
        text: 'Reusable UI sections, components, forms, dashboards, and interaction states.',
    },
    {
        icon: ShieldCheck,
        title: 'Frontend Quality',
        text: 'Typed code, linting, build checks, accessibility basics, and careful responsive polish.',
    },
];

const pricingItems = [
    {
        icon: MonitorSmartphone,
        title: 'Custom Design',
        text: 'Unique design that reflects your brand',
    },
    {
        icon: Smartphone,
        title: 'Responsive Development',
        text: 'Perfect experience on all devices',
    },
    {
        icon: Rocket,
        title: 'Launch & Basic SEO',
        text: 'Your site goes live, optimized for visibility',
    },
    {
        icon: Headphones,
        title: 'Support',
        text: 'Post-launch assistance and updates',
    },
];

const contactTags = [
    'Fast communication',
    'Clean process',
    'Business-focused result',
];

const contactLinks = [
    { icon: Phone, label: 'WhatsApp: +37125293592' },
    { icon: Mail, label: 'Email: Katya5122004@gmail.com' },
    { icon: Send, label: 'Telegram: @Karinchik_karafinchik' },
];

const closeMenu = () => {
    isMenuOpen.value = false;
};

let revealObserver: IntersectionObserver | null = null;
let cleanupLanguageCursor: (() => void) | null = null;

onMounted(() => {
    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver?.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.16 },
    );

    document
        .querySelectorAll<HTMLElement>('[data-reveal]')
        .forEach((element) => revealObserver?.observe(element));

    const section = languageSection.value;
    const finePointer = window.matchMedia('(pointer: fine)');

    if (!section || !finePointer.matches) {
        return;
    }

    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;
    let frame = 0;

    const updateCursorPosition = (event: PointerEvent) => {
        const rect = section.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width;
        const y = (event.clientY - rect.top) / rect.height;

        targetX = Math.min(1, Math.max(0, x)) * 2 - 1;
        targetY = Math.min(1, Math.max(0, y)) * 2 - 1;
    };

    const resetCursorPosition = () => {
        targetX = 0;
        targetY = 0;
    };

    const renderCursorMotion = () => {
        currentX += (targetX - currentX) * 0.09;
        currentY += (targetY - currentY) * 0.09;

        section.style.setProperty(
            '--avatar-look-x',
            `${(currentX * 10).toFixed(2)}px`,
        );
        section.style.setProperty(
            '--avatar-look-y',
            `${(currentY * 8).toFixed(2)}px`,
        );
        section.style.setProperty(
            '--avatar-rotate-x',
            `${(currentY * -4).toFixed(2)}deg`,
        );
        section.style.setProperty(
            '--avatar-rotate-y',
            `${(currentX * 6).toFixed(2)}deg`,
        );
        section.style.setProperty(
            '--avatar-glow-x',
            `${(currentX * 16).toFixed(2)}px`,
        );
        section.style.setProperty(
            '--avatar-glow-y',
            `${(currentY * 12).toFixed(2)}px`,
        );

        frame = window.requestAnimationFrame(renderCursorMotion);
    };

    frame = window.requestAnimationFrame(renderCursorMotion);

    section.addEventListener('pointermove', updateCursorPosition, {
        passive: true,
    });
    section.addEventListener('pointerleave', resetCursorPosition);

    cleanupLanguageCursor = () => {
        window.cancelAnimationFrame(frame);
        section.removeEventListener('pointermove', updateCursorPosition);
        section.removeEventListener('pointerleave', resetCursorPosition);
    };
});

onUnmounted(() => {
    revealObserver?.disconnect();
    cleanupLanguageCursor?.();
});
</script>

<template>
    <div class="portfolio-page">
        <header class="site-header">
            <a class="brand" href="#home" @click="closeMenu">
                <img
                    src="/images/kg-logo.png"
                    alt="Karina Getmanenko portfolio logo"
                />
            </a>

            <nav class="desktop-nav" aria-label="Main navigation">
                <a
                    v-for="item in navItems"
                    :key="item.id"
                    :href="`#${item.id}`"
                >
                    {{ item.label }}
                </a>
            </nav>

            <button
                class="menu-button"
                type="button"
                :aria-expanded="isMenuOpen"
                aria-controls="mobile-navigation"
                aria-label="Toggle navigation"
                @click="isMenuOpen = !isMenuOpen"
            >
                <X v-if="isMenuOpen" :size="18" />
                <Menu v-else :size="18" />
            </button>

            <nav
                id="mobile-navigation"
                class="mobile-nav"
                :class="{ 'is-open': isMenuOpen }"
                aria-label="Mobile navigation"
            >
                <a
                    v-for="item in navItems"
                    :key="item.id"
                    :href="`#${item.id}`"
                    @click="closeMenu"
                >
                    {{ item.label }}
                </a>
            </nav>
        </header>

        <main>
            <section id="home" class="hero section-shell">
                <div class="hero-copy">
                    <p class="eyebrow">Web Developer in Riga</p>
                    <h1>Building clean digital interfaces.</h1>
                    <p class="hero-text">
                        I design and build modern websites for local businesses,
                        sports clubs, and service companies: clean UI,
                        responsive layouts, clear structure, and launch-ready
                        results.
                    </p>

                    <div class="hero-actions" aria-label="Primary actions">
                        <a class="button button-primary" href="#work">
                            View Work
                            <ArrowUpRight :size="15" />
                        </a>
                        <a class="button button-secondary" href="#contact">
                            Contact
                            <Mail :size="15" />
                        </a>
                    </div>
                </div>

                <div class="hero-visual" aria-label="Code interface preview">
                    <div class="browser-window">
                        <div class="window-bar">
                            <span></span>
                            <span></span>
                            <span></span>
                            <small>KG portfolio.app</small>
                        </div>
                        <div class="code-layout">
                            <aside>
                                <strong>src</strong>
                                <span>App.vue</span>
                                <span>components</span>
                                <span>styles.css</span>
                                <span>vite.config.ts</span>
                            </aside>
                            <div class="code-panel">
                                <div class="code-line accent"></div>
                                <div class="code-line wide"></div>
                                <div class="code-line"></div>
                                <div class="code-line short"></div>
                                <div class="preview-grid">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="terminal">
                                    <span>npm run build</span>
                                    <strong>✓ production ready</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section ref="languageSection" class="language-poster" data-reveal>
                <div class="language-sticky">
                    <div class="poster-heading section-shell">
                        <p class="eyebrow">Tech Identity</p>
                        <h2>
                            Tools I use to build stable, fast, and polished web
                            products
                        </h2>
                    </div>

                    <div class="poster-layout section-shell">
                        <div class="poster-column poster-column-left">
                            <article
                                v-for="item in languageColumns.left"
                                :key="item.title"
                                class="poster-note"
                            >
                                <h3>{{ item.title }}</h3>
                                <p>{{ item.text }}</p>
                            </article>
                        </div>

                        <div class="poster-avatar">
                            <img
                                src="/images/avatar-portfolio-cutout.png"
                                alt="Stylized portrait avatar for Karina portfolio"
                            />
                        </div>

                        <div class="poster-column poster-column-right">
                            <article
                                v-for="item in languageColumns.right"
                                :key="item.title"
                                class="poster-note"
                            >
                                <h3>{{ item.title }}</h3>
                                <p>{{ item.text }}</p>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section class="value-section" data-reveal>
                <div class="section-shell value-grid">
                    <article
                        v-for="card in valueCards"
                        :key="card.title"
                        class="value-card"
                    >
                        <h2>{{ card.title }}</h2>
                        <ul>
                            <li v-for="item in card.items" :key="item">
                                {{ item }}
                            </li>
                        </ul>
                    </article>
                </div>
            </section>

            <section id="work" class="work section-shell" data-reveal>
                <div class="section-heading">
                    <p class="eyebrow">Selected Work</p>
                    <h2>Focused web experiences for real workflows.</h2>
                </div>

                <div class="project-grid">
                    <article
                        v-for="project in projects"
                        :key="project.title"
                        class="project-card"
                    >
                        <div class="project-screen">
                            <img
                                :src="project.image"
                                :alt="`${project.title} fictional website preview`"
                            />
                        </div>
                        <div class="project-meta">
                            <span>{{ project.type }}</span>
                            <ArrowUpRight :size="15" />
                        </div>
                        <h3>{{ project.title }}</h3>
                        <p>{{ project.description }}</p>
                    </article>
                </div>
            </section>

            <section id="stack" class="stack-section" data-reveal>
                <div class="section-shell stack-grid">
                    <div>
                        <p class="eyebrow">Stack</p>
                        <h2>Modern tools, pragmatic implementation.</h2>
                    </div>
                    <div class="stack-list">
                        <span v-for="item in stack" :key="item">
                            {{ item }}
                        </span>
                    </div>
                </div>
            </section>

            <section id="services" class="services section-shell" data-reveal>
                <div class="section-heading">
                    <p class="eyebrow">Services</p>
                    <h2>From visual concept to production build.</h2>
                </div>

                <div class="service-grid">
                    <article
                        v-for="service in services"
                        :key="service.title"
                        class="service-card"
                    >
                        <component :is="service.icon" :size="22" />
                        <h3>{{ service.title }}</h3>
                        <p>{{ service.text }}</p>
                    </article>
                </div>
            </section>

            <section id="process" class="process section-shell" data-reveal>
                <div class="pricing-panel">
                    <div class="pricing-copy">
                        <p class="price-pill">Starting Price</p>
                        <div class="price-amount">
                            <span>from</span>
                            <strong>€200</strong>
                        </div>
                        <p>
                            A complete website solution tailored to your
                            business goals — from design to launch. Clean. Fast.
                            Responsive.
                        </p>
                        <a class="pricing-link" href="#contact">
                            Get Started
                            <ArrowUpRight :size="16" />
                        </a>
                    </div>

                    <div class="included-card">
                        <p class="eyebrow">What’s Included</p>
                        <div class="included-list">
                            <article
                                v-for="item in pricingItems"
                                :key="item.title"
                                class="included-item"
                            >
                                <div class="included-icon">
                                    <component :is="item.icon" :size="20" />
                                </div>
                                <div>
                                    <h3>{{ item.title }}</h3>
                                    <p>{{ item.text }}</p>
                                </div>
                            </article>
                        </div>

                        <a class="included-cta" href="#contact">
                            Discuss Your Project
                            <span>
                                <ArrowUpRight :size="19" />
                            </span>
                        </a>
                    </div>
                </div>
            </section>

            <section id="contact" class="contact section-shell" data-reveal>
                <div class="contact-panel">
                    <div class="contact-copy">
                        <p class="eyebrow">Contact</p>
                        <h2>
                            Ready to discuss your project and create a modern
                            website that makes your business look stronger
                            online
                        </h2>
                        <p>
                            I create turnkey websites: from idea and design to
                            launch and support.
                        </p>

                        <div class="contact-tags">
                            <span v-for="tag in contactTags" :key="tag">
                                {{ tag }}
                            </span>
                        </div>

                        <a
                            class="button button-primary"
                            href="mailto:hello@example.com"
                        >
                            Start a Project
                            <Share2 class="button-mark" :size="15" />
                        </a>
                    </div>

                    <div class="contact-card">
                        <div class="contact-lines">
                            <div
                                v-for="item in contactLinks"
                                :key="item.label"
                                class="contact-line"
                            >
                                <component :is="item.icon" :size="15" />
                                <span>{{ item.label }}</span>
                            </div>
                        </div>

                        <div class="premium-flow">
                            <p class="eyebrow">Premium Flow</p>
                            <span>
                                You get direct contact, a calm process, and a
                                website designed to look credible from the first
                                screen.
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer section-shell">
            <span>Karina Getmanenko</span>
            <span>{{ currentYear }}</span>
        </footer>
    </div>
</template>

<style scoped>
.portfolio-page {
    min-height: 100vh;
    overflow-x: hidden;
    background:
        radial-gradient(
            circle at 8% 0%,
            rgba(255, 107, 34, 0.5),
            transparent 28rem
        ),
        radial-gradient(
            circle at 92% 72%,
            rgba(117, 24, 17, 0.65),
            transparent 34rem
        ),
        #080807;
    color: #f6f7fb;
    font-family:
        Instrument Sans,
        ui-sans-serif,
        system-ui,
        sans-serif;
    scroll-behavior: smooth;
}

.portfolio-page :global(html) {
    scroll-behavior: smooth;
}

.section-shell {
    width: min(100% - 36px, 1180px);
    margin: 0 auto;
}

.site-header {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    z-index: 40;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(8, 10, 15, 0.76);
    padding: 18px clamp(18px, 4vw, 56px);
    backdrop-filter: blur(18px);
}

.brand {
    position: relative;
    display: inline-flex;
    width: fit-content;
    align-items: center;
    color: inherit;
    text-decoration: none;
}

.brand::before {
    position: absolute;
    inset: 9px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(255, 255, 255, 0.34),
        rgba(255, 107, 34, 0.18) 42%,
        transparent 72%
    );
    filter: blur(14px);
    content: '';
}

.brand img {
    position: relative;
    width: 58px;
    height: 58px;
    object-fit: contain;
    filter: brightness(1.45) contrast(1.18)
        drop-shadow(0 0 10px rgba(255, 255, 255, 0.2))
        drop-shadow(0 0 20px rgba(255, 61, 31, 0.62));
}

.desktop-nav a,
.mobile-nav a,
.eyebrow {
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.desktop-nav {
    display: flex;
    align-items: center;
    gap: 22px;
}

.desktop-nav a,
.mobile-nav a {
    color: #d8d3cc;
    font-size: 12px;
    text-decoration: none;
    transition: color 180ms ease;
}

.desktop-nav a:hover,
.mobile-nav a:hover {
    color: #f6f7fb;
}

.menu-button {
    display: none;
    place-self: end;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 8px;
    background: #15110f;
    color: #f6f7fb;
}

.mobile-nav {
    display: none;
}

.hero {
    position: relative;
    display: grid;
    min-height: 100vh;
    grid-template-columns: minmax(0, 0.86fr) minmax(360px, 1fr);
    align-items: center;
    gap: clamp(24px, 4vw, 58px);
    padding-top: 116px;
    padding-bottom: 70px;
}

.hero::before {
    position: absolute;
    inset: 92px 0 auto;
    z-index: 0;
    height: min(62vh, 590px);
    border-radius: 34px;
    background:
        radial-gradient(
            circle at 58% 40%,
            rgba(255, 255, 255, 0.17),
            transparent 9rem
        ),
        linear-gradient(135deg, #d93118 0%, #d84b18 42%, #5b120d 100%);
    box-shadow: 0 42px 110px rgba(216, 75, 24, 0.2);
    content: '';
}

.hero-copy {
    position: relative;
    z-index: 1;
    padding-left: clamp(22px, 5vw, 72px);
    animation: hero-in 780ms ease both;
}

.eyebrow {
    margin: 0;
    color: rgba(255, 255, 255, 0.86);
    font-size: 11px;
    font-weight: 700;
}

.section-heading h2,
.stack-grid h2,
.contact h2 {
    margin: 18px 0 22px;
    font-size: clamp(34px, 5vw, 64px);
    font-weight: 700;
    line-height: 1;
}

.hero h1 {
    max-width: 600px;
    margin: 18px 0 22px;
    overflow-wrap: normal;
    color: #ffffff;
    font-size: clamp(42px, 5vw, 72px);
    font-weight: 800;
    line-height: 0.98;
    text-wrap: balance;
}

.hero-text {
    max-width: 560px;
    margin-top: clamp(42px, 7vh, 82px);
    color: #cfc8bf;
    font-size: 16px;
    line-height: 1.65;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 26px;
}

.button {
    display: inline-flex;
    min-height: 48px;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 8px;
    padding: 0 18px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition:
        transform 180ms ease,
        border-color 180ms ease,
        background 180ms ease;
}

.button:hover {
    transform: translateY(-2px);
}

.button-primary {
    border: 1px solid #ff6b22;
    background: #ff6b22;
    color: #090909;
}

.button-secondary {
    border: 1px solid rgba(255, 255, 255, 0.18);
    background: rgba(255, 107, 34, 0.08);
    color: #f6f7fb;
}

.hero-visual {
    position: relative;
    z-index: 1;
    animation: hero-in 820ms 90ms ease both;
}

.browser-window,
.project-card,
.service-card,
.contact-panel {
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 28px;
    background: #10100f;
    box-shadow: 0 28px 90px rgba(0, 0, 0, 0.34);
}

.browser-window {
    overflow: hidden;
}

.window-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 14px 16px;
}

.window-bar span {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #2a2724;
}

.window-bar span:nth-child(1) {
    background: #ff3d1f;
}

.window-bar span:nth-child(2) {
    background: #ff8a1d;
}

.window-bar span:nth-child(3) {
    background: #ffffff;
}

.window-bar small {
    margin-left: auto;
    color: #8f8983;
    font-size: 12px;
}

.code-layout {
    display: grid;
    grid-template-columns: 150px 1fr;
    min-height: 460px;
}

.code-layout aside {
    display: grid;
    align-content: start;
    gap: 14px;
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    padding: 22px;
    color: #a49b92;
    font-size: 13px;
}

.code-layout aside strong {
    color: #f6f7fb;
}

.code-panel {
    display: grid;
    align-content: start;
    gap: 16px;
    padding: 28px;
}

.code-line {
    width: 68%;
    height: 13px;
    border-radius: 999px;
    background: #2b2622;
}

.code-line.accent {
    width: 42%;
    background: #ff6b22;
}

.code-line.wide {
    width: 88%;
}

.code-line.short {
    width: 54%;
}

.preview-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 14px;
    margin-top: 20px;
}

.preview-grid div {
    min-height: 120px;
    border-radius: 8px;
    background: linear-gradient(135deg, #ff4b1f, #7b1715);
}

.preview-grid div:nth-child(2) {
    background: linear-gradient(135deg, #ff8a1d, #2b100b);
}

.preview-grid div:nth-child(3) {
    grid-column: span 2;
    min-height: 88px;
    background: linear-gradient(135deg, #231f1c, #15110f);
}

.terminal {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-top: 14px;
    border-radius: 8px;
    background: #080807;
    padding: 14px;
    color: #ffb27a;
    font-family: Consolas, Monaco, monospace;
    font-size: 13px;
}

.terminal strong {
    color: #ffffff;
}

.value-section,
.work,
.stack-section,
.services,
.process,
.contact {
    padding: clamp(76px, 9vw, 124px) 0;
}

.language-poster {
    position: relative;
    margin-top: -10px;
    padding: clamp(64px, 8vw, 104px) 0;
    --avatar-glow-x: 0px;
    --avatar-glow-y: 0px;
    --avatar-look-x: 0px;
    --avatar-look-y: 0px;
    --avatar-rotate-x: 0deg;
    --avatar-rotate-y: 0deg;
}

.language-sticky {
    position: relative;
    display: grid;
    overflow: hidden;
    align-content: center;
    padding: clamp(42px, 6vw, 70px) 0;
    perspective: 1300px;
    isolation: isolate;
}

.language-sticky::before,
.language-sticky::after {
    position: absolute;
    content: '';
    pointer-events: none;
}

.language-sticky::before {
    inset: 4% 0 5%;
    z-index: 0;
    background:
        radial-gradient(
            circle at 50% 42%,
            rgba(255, 58, 24, 0.44),
            transparent 27rem
        ),
        linear-gradient(90deg, #090707, #160605 48%, #090707);
    transform: translate3d(0, 0, -80px) scale(1.04);
    filter: saturate(1.06);
}

.language-sticky::after {
    inset: 0;
    z-index: 1;
    background:
        radial-gradient(circle at 50% 50%, transparent 32%, #050505 90%),
        linear-gradient(
            180deg,
            #050505 0%,
            transparent 18%,
            transparent 84%,
            #050505 100%
        );
    opacity: 0.72;
}

.poster-heading {
    position: relative;
    z-index: 3;
    max-width: 680px;
    margin: 0 auto;
    padding-top: 0;
    padding-right: clamp(22px, 4vw, 48px);
    padding-left: clamp(22px, 4vw, 48px);
    text-align: center;
    transform: translate3d(0, 0, 80px);
    transform-origin: center top;
}

.poster-heading h2 {
    margin: 10px 0 0;
    font-size: clamp(34px, 4vw, 52px);
    line-height: 1.06;
}

.poster-layout {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns:
        minmax(220px, 0.86fr) minmax(230px, 0.76fr)
        minmax(220px, 0.86fr);
    align-items: center;
    gap: clamp(16px, 2.4vw, 34px);
    min-height: min(52vh, 470px);
    margin-top: clamp(8px, 2vh, 18px);
    padding: clamp(18px, 3vw, 36px);
    transform-style: preserve-3d;
}

.poster-column {
    display: grid;
    gap: clamp(18px, 2.5vw, 30px);
    align-content: center;
}

.poster-column-left {
    justify-items: end;
    text-align: right;
    transform: translate3d(0, 0, 40px);
    transform-origin: right center;
}

.poster-column-right {
    justify-items: start;
    text-align: left;
    transform: translate3d(0, 0, 40px);
    transform-origin: left center;
}

.poster-column-right .poster-note {
    transform: translateY(clamp(0px, 0.35vw, 5px));
}

.poster-note {
    width: min(100%, 270px);
}

.poster-note h3 {
    margin: 0 0 8px;
    color: #ffffff;
    font-size: clamp(14px, 1.8vw, 21px);
    font-weight: 900;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.poster-note p {
    max-width: 260px;
    margin: 0;
    color: #b9b0a8;
    font-size: 12px;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

.poster-column-right .poster-note p {
    margin-left: 0;
}

.poster-avatar {
    position: relative;
    z-index: 2;
    justify-self: center;
    width: min(100%, 340px);
    aspect-ratio: 1;
    transform: translate3d(var(--avatar-look-x), var(--avatar-look-y), 160px)
        rotateX(var(--avatar-rotate-x)) rotateY(var(--avatar-rotate-y));
    transform-origin: 50% 48%;
    transform-style: preserve-3d;
    will-change: transform;
}

.poster-avatar::before,
.poster-avatar::after {
    position: absolute;
    content: '';
}

.poster-avatar::before {
    inset: -24%;
    z-index: -1;
    border-radius: 50%;
    background:
        radial-gradient(
            circle at 50% 46%,
            rgba(255, 118, 48, 0.78),
            rgba(210, 31, 22, 0.5) 30%,
            rgba(92, 2, 2, 0.24) 58%,
            transparent 76%
        ),
        radial-gradient(
            circle at 50% 38%,
            rgba(255, 255, 255, 0.16),
            transparent 42%
        );
    filter: blur(44px);
    opacity: 0.86;
    transform: translate3d(var(--avatar-glow-x), var(--avatar-glow-y), -30px);
    will-change: transform;
}

.poster-avatar::after {
    inset: 4% 3% 0;
    z-index: -2;
    border-radius: 44%;
    background: radial-gradient(
        circle,
        rgba(255, 57, 30, 0.28),
        transparent 68%
    );
    filter: blur(64px);
}

.poster-avatar img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    filter: drop-shadow(0 34px 46px rgba(0, 0, 0, 0.46))
        drop-shadow(0 0 26px rgba(255, 65, 32, 0.42));
    backface-visibility: hidden;
    transform: translateZ(24px);
}

.value-section {
    background: #000000;
    color: #f6f7fb;
}

.value-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: clamp(18px, 3vw, 34px);
    justify-content: start;
}

.value-card {
    min-height: 420px;
    border: 1px solid rgba(255, 107, 34, 0.28);
    border-radius: 28px;
    background:
        linear-gradient(145deg, rgba(255, 107, 34, 0.08), transparent 40%),
        rgba(16, 16, 15, 0.9);
    padding: clamp(28px, 4vw, 48px);
    box-shadow: 0 28px 90px rgba(0, 0, 0, 0.34);
    backdrop-filter: blur(14px);
}

.value-card h2 {
    margin: 0 0 30px;
    color: #ff6b22;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 0.24em;
    line-height: 1.35;
    text-transform: uppercase;
}

.value-card ul {
    display: grid;
    gap: 22px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.value-card li {
    position: relative;
    padding-left: 22px;
    color: #cfc8bf;
    font-size: 16px;
    line-height: 1.65;
}

.value-card li::before {
    position: absolute;
    top: 0.78em;
    left: 0;
    width: 8px;
    height: 8px;
    transform: translateY(-50%);
    border-radius: 50%;
    background: #ff6b22;
    box-shadow: 0 0 18px rgba(255, 107, 34, 0.62);
    content: '';
}

.section-heading {
    max-width: 780px;
}

.section-heading h2,
.stack-grid h2,
.contact h2 {
    font-size: clamp(32px, 4.4vw, 56px);
}

.project-grid,
.service-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-top: 42px;
}

.project-card,
.service-card {
    overflow: hidden;
    transition:
        transform 220ms ease,
        border-color 220ms ease;
}

.project-card:hover,
.service-card:hover {
    transform: translateY(-6px);
    border-color: rgba(255, 107, 34, 0.56);
}

.project-screen {
    aspect-ratio: 16 / 9;
    overflow: hidden;
    background: #15110f;
}

.project-screen img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    transform: scale(1.01);
    transition: transform 260ms ease;
}

.project-card:hover .project-screen img {
    transform: scale(1.045);
}

.project-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 22px 0;
    color: #ff6b22;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.project-card h3,
.service-card h3 {
    margin: 18px 22px 10px;
    font-size: 22px;
    line-height: 1.14;
}

.project-card p,
.service-card p,
.contact p {
    color: #cfc8bf;
    font-size: 16px;
    line-height: 1.65;
}

.project-card p {
    margin: 0 22px 28px;
}

.stack-section {
    background: #11100f;
}

.stack-grid {
    display: grid;
    grid-template-columns: minmax(0, 0.78fr) minmax(300px, 1fr);
    align-items: start;
    gap: clamp(32px, 7vw, 90px);
}

.stack-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.stack-list span {
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 999px;
    background: rgba(255, 107, 34, 0.08);
    padding: 12px 14px;
    color: #f3eee8;
    font-size: 13px;
}

.service-card {
    padding: 24px;
}

.service-card svg {
    color: #ff6b22;
}

.service-card h3 {
    margin-right: 0;
    margin-left: 0;
}

.section-heading.split {
    display: grid;
    max-width: 940px;
    grid-template-columns: 1fr;
    gap: 14px;
    text-align: left;
}

.section-heading.split h2 {
    max-width: 900px;
    margin-right: 0;
    margin-left: 0;
}

.pricing-panel {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 0.95fr) minmax(340px, 1.05fr);
    gap: clamp(28px, 6vw, 86px);
    align-items: center;
    overflow: hidden;
    min-height: 560px;
    border-radius: 8px;
    background:
        radial-gradient(
            circle at 78% 105%,
            rgba(255, 72, 35, 0.28),
            transparent 30rem
        ),
        radial-gradient(
            circle at 35% 45%,
            rgba(255, 72, 35, 0.14),
            transparent 28rem
        ),
        #080807;
    padding: clamp(34px, 6vw, 72px);
}

.pricing-panel::before {
    position: absolute;
    top: 20%;
    left: 8%;
    width: min(48vw, 640px);
    height: 280px;
    transform: skewY(-12deg) rotate(-8deg);
    border: 1px solid rgba(255, 107, 34, 0.38);
    border-radius: 12px;
    background: linear-gradient(
        135deg,
        rgba(255, 107, 34, 0.12),
        transparent 62%
    );
    box-shadow: 0 0 58px rgba(255, 61, 31, 0.18);
    content: '';
    pointer-events: none;
}

.pricing-copy,
.included-card {
    position: relative;
    z-index: 1;
}

.price-pill {
    display: inline-flex;
    align-items: center;
    min-height: 42px;
    border: 1px solid rgba(255, 107, 34, 0.58);
    border-radius: 999px;
    padding: 0 18px;
    color: #ff6b22;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.price-amount {
    display: grid;
    gap: 8px;
    margin: clamp(58px, 8vw, 94px) 0 30px;
}

.price-amount span {
    color: #ffffff;
    font-size: clamp(34px, 4vw, 56px);
    font-weight: 800;
    line-height: 1;
}

.price-amount strong {
    background: linear-gradient(135deg, #ff3425, #ff8a23);
    background-clip: text;
    color: transparent;
    font-size: clamp(88px, 13vw, 164px);
    font-weight: 900;
    line-height: 0.82;
}

.pricing-copy p {
    max-width: 500px;
    margin: 0;
    color: #cfc8bf;
    font-size: 16px;
    line-height: 1.7;
}

.pricing-link {
    display: inline-flex;
    align-items: center;
    gap: 34px;
    margin-top: 50px;
    border-bottom: 1px solid rgba(255, 107, 34, 0.48);
    padding-bottom: 12px;
    color: #ff6b22;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 0.16em;
    text-decoration: none;
    text-transform: uppercase;
}

.included-card {
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 34px;
    background:
        radial-gradient(
            circle at 22% 18%,
            rgba(255, 107, 34, 0.08),
            transparent 18rem
        ),
        rgba(16, 16, 15, 0.9);
    padding: clamp(26px, 4vw, 54px);
    box-shadow: 0 34px 110px rgba(0, 0, 0, 0.38);
}

.included-card > .eyebrow {
    color: #ff6b22;
}

.included-list {
    display: grid;
    gap: 0;
    margin-top: 28px;
}

.included-item {
    display: grid;
    grid-template-columns: 72px 1fr;
    gap: 24px;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 22px 0;
}

.included-item:first-child {
    padding-top: 0;
}

.included-icon {
    display: grid;
    width: 54px;
    height: 54px;
    place-items: center;
    border-radius: 50%;
    background:
        radial-gradient(
            circle at 50% 40%,
            rgba(255, 107, 34, 0.24),
            transparent 70%
        ),
        #201b18;
    color: #ff6b22;
}

.included-item h3 {
    margin: 0 0 6px;
    color: #ffffff;
    font-size: 20px;
    line-height: 1.15;
}

.included-item p {
    margin: 0;
    color: #b9b0a8;
    font-size: 15px;
    line-height: 1.5;
}

.included-cta {
    display: inline-flex;
    align-items: center;
    gap: 24px;
    margin-top: 34px;
    color: #ff6b22;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 0.16em;
    text-decoration: none;
    text-transform: uppercase;
}

.included-cta > span {
    display: grid;
    width: 54px;
    height: 54px;
    place-items: center;
    border-radius: 50%;
    background: rgba(255, 107, 34, 0.08);
    box-shadow: 0 0 30px rgba(255, 107, 34, 0.22);
}

.contact-panel {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(320px, 0.78fr);
    gap: clamp(28px, 5vw, 70px);
    align-items: start;
    padding: clamp(28px, 7vw, 78px);
}

.contact-copy h2 {
    max-width: 800px;
}

.contact-copy p {
    max-width: 640px;
}

.contact-panel .button {
    margin-top: 34px;
}

.button-mark {
    color: #090909;
    stroke-width: 2.4;
}

.contact-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 26px;
}

.contact-tags span {
    border: 1px solid rgba(255, 107, 34, 0.34);
    border-radius: 999px;
    background: rgba(255, 107, 34, 0.08);
    padding: 11px 14px;
    color: #ff8a4c;
    font-size: 13px;
    font-weight: 800;
}

.contact-card {
    border: 1px solid rgba(255, 107, 34, 0.28);
    border-radius: 8px;
    background:
        radial-gradient(
            circle at 88% 0%,
            rgba(255, 107, 34, 0.16),
            transparent 15rem
        ),
        #080807;
    padding: clamp(20px, 3vw, 32px);
}

.contact-lines {
    display: grid;
    gap: 14px;
}

.contact-line {
    display: flex;
    min-height: 54px;
    align-items: center;
    gap: 12px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.035);
    padding: 0 16px;
    color: #f6f7fb;
    font-size: 15px;
}

.contact-line svg {
    flex: 0 0 auto;
    color: #ff6b22;
    stroke-width: 2;
}

.premium-flow {
    margin-top: 22px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    padding-top: 22px;
}

.premium-flow span {
    display: block;
    margin-top: 16px;
    color: #cfc8bf;
    font-size: 16px;
    line-height: 1.65;
}

.site-footer {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
    padding: 26px 0 34px;
    color: #a49b92;
    font-size: 13px;
}

[data-reveal] {
    transform: translateY(34px);
    opacity: 0;
    transition:
        opacity 700ms ease,
        transform 700ms ease;
}

[data-reveal].is-visible {
    transform: translateY(0);
    opacity: 1;
}

@keyframes hero-in {
    from {
        transform: translateY(24px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 1020px) {
    .site-header {
        grid-template-columns: 1fr auto;
    }

    .desktop-nav {
        display: none;
    }

    .menu-button {
        display: inline-flex;
    }

    .mobile-nav {
        position: fixed;
        top: 78px;
        right: 18px;
        left: 18px;
        display: grid;
        max-height: 0;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        background: #15110f;
        opacity: 0;
        transition:
            max-height 220ms ease,
            opacity 220ms ease;
    }

    .mobile-nav.is-open {
        max-height: 360px;
        opacity: 1;
    }

    .mobile-nav a {
        padding: 16px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 14px;
    }

    .hero,
    .stack-grid,
    .contact-panel,
    .section-heading.split {
        grid-template-columns: 1fr;
    }

    .hero {
        min-height: auto;
        padding-top: 128px;
    }

    .hero-copy {
        padding-left: 0;
    }

    .project-grid,
    .service-grid,
    .value-grid,
    .pricing-panel {
        grid-template-columns: 1fr;
    }

    .poster-heading {
        max-width: min(100%, 560px);
        margin: 0 auto;
        padding-right: 22px;
        padding-left: 22px;
        text-align: center;
    }

    .poster-heading h2 {
        font-size: clamp(34px, 8vw, 48px);
    }

    .poster-layout {
        grid-template-columns: 1fr;
        justify-items: center;
        min-height: 0;
        padding-top: 12px;
    }

    .poster-column {
        width: min(100%, 620px);
        grid-template-columns: repeat(2, minmax(0, 1fr));
        order: 2;
        justify-items: center;
        text-align: center;
    }

    .poster-column-left,
    .poster-column-right {
        transform-origin: center;
    }

    .poster-column-right {
        text-align: center;
    }

    .poster-column-right .poster-note p {
        margin-left: auto;
    }

    .poster-note p {
        margin-right: auto;
        margin-left: auto;
    }

    .poster-avatar {
        order: 1;
        width: min(58vw, 270px);
    }

    .code-layout {
        grid-template-columns: 1fr;
    }

    .code-layout aside {
        display: none;
    }
}

@media (max-width: 620px) {
    .section-shell {
        width: min(100% - 28px, 1180px);
    }

    .site-header {
        padding: 14px;
    }

    .brand img {
        width: 48px;
        height: 48px;
    }

    .hero h1 {
        font-size: clamp(36px, 11vw, 54px);
    }

    .hero-actions {
        display: grid;
    }

    .button {
        width: 100%;
    }

    .browser-window {
        box-shadow: none;
    }

    .code-panel {
        padding: 20px;
    }

    .preview-grid {
        grid-template-columns: 1fr;
    }

    .preview-grid div:nth-child(3) {
        grid-column: auto;
    }

    .terminal {
        flex-direction: column;
    }

    .value-card {
        min-height: 0;
        border-radius: 22px;
        padding: 28px 24px;
    }

    .value-card li {
        font-size: 16px;
    }

    .pricing-panel {
        padding: 24px;
    }

    .pricing-panel::before {
        top: 18%;
        left: 18%;
        width: 80%;
        height: 190px;
    }

    .price-amount {
        margin: 42px 0 24px;
    }

    .price-amount strong {
        font-size: clamp(68px, 26vw, 108px);
    }

    .included-card {
        border-radius: 24px;
    }

    .included-item {
        grid-template-columns: 48px 1fr;
        gap: 14px;
    }

    .included-icon {
        width: 44px;
        height: 44px;
    }

    .included-cta {
        display: grid;
        justify-items: start;
    }

    .included-cta > span {
        width: 48px;
        height: 48px;
    }

    .contact-panel {
        padding: 24px;
    }

    .contact-tags span {
        width: 100%;
        text-align: center;
    }

    .contact-line {
        min-height: 50px;
        align-items: flex-start;
        padding: 14px;
        font-size: 14px;
    }

    .language-sticky {
        padding-top: 44px;
    }

    .poster-layout {
        gap: 22px;
        margin-top: 14px;
        padding-right: 22px;
        padding-left: 22px;
    }

    .poster-column {
        width: min(100%, 380px);
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .poster-note p {
        max-width: 320px;
    }

    .poster-avatar {
        width: min(74vw, 250px);
    }

    .site-footer {
        gap: 12px;
        flex-direction: column;
    }
}

@media (prefers-reduced-motion: reduce) {
    .language-poster {
        padding: clamp(72px, 9vw, 112px) 0;
    }

    .language-sticky {
        overflow: visible;
    }

    .poster-heading,
    .poster-column,
    .poster-avatar {
        transform: none;
        opacity: 1;
        filter: none;
        will-change: auto;
    }

    .poster-avatar::before {
        transform: none;
        will-change: auto;
    }
}
</style>
