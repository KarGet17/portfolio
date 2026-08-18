<script setup lang="ts">
import { ArrowUpRight, Mail, Menu, MoveDown, X } from '@lucide/vue';
import { onMounted, ref } from 'vue';

const isMenuOpen = ref(false);
const currentYear = new Date().getFullYear();

const navItems = [
    { label: 'Home', id: 'home' },
    { label: 'About', id: 'about' },
    { label: 'Projects', id: 'projects' },
    { label: 'Services', id: 'services' },
    { label: 'Process', id: 'process' },
    { label: 'Contact', id: 'contact' },
];

const strengths = [
    'Architectural composition',
    'Balanced material palettes',
    'Clear zoning and flow',
    'Quiet, functional details',
];

const projects = [
    {
        title: 'Residential Interior Concept',
        type: 'Interior Design',
        description:
            'A calm living environment direction focused on proportion, texture, natural light, and practical daily use.',
        tone: 'warm',
        featured: true,
    },
    {
        title: 'Spatial Planning Study',
        type: 'Space Planning',
        description:
            'A layout-led direction for refining circulation, furniture scale, and the relationship between open and private zones.',
        tone: 'stone',
        featured: false,
    },
    {
        title: 'Material & Furniture Palette',
        type: 'Furniture Selection',
        description:
            'A curated design language built from restrained finishes, soft contrast, and tactile surfaces.',
        tone: 'charcoal',
        featured: false,
    },
];

const services = [
    'Interior Design',
    '3D Visualization',
    'Space Planning',
    'Concept Development',
    'Furniture & Material Selection',
];

const processSteps = [
    'Brief',
    'Concept',
    'Planning',
    '3D Visualization',
    'Final Design',
];

const closeMenu = () => {
    isMenuOpen.value = false;
};

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.16 },
    );

    document
        .querySelectorAll<HTMLElement>('[data-reveal]')
        .forEach((element) => observer.observe(element));
});
</script>

<template>
    <div class="portfolio-page">
        <header class="site-header">
            <a class="brand" href="#home" @click="closeMenu">
                <span>Karina Getmanenko</span>
                <small>Interior Design</small>
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
                <X v-if="isMenuOpen" :size="20" />
                <Menu v-else :size="20" />
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
                    <p class="eyebrow">Interior Designer / Interior Design</p>
                    <h1>Karina</h1>
                    <p class="hero-text">
                        Contemporary interiors shaped with quiet structure,
                        refined materials, and a clear sense of everyday
                        comfort.
                    </p>

                    <div class="hero-actions" aria-label="Primary actions">
                        <a class="button button-primary" href="#projects">
                            View Projects
                            <MoveDown :size="17" />
                        </a>
                        <a class="button button-secondary" href="#contact">
                            Contact
                            <ArrowUpRight :size="17" />
                        </a>
                    </div>
                </div>

                <div class="hero-visual" aria-hidden="true">
                    <div class="visual-frame visual-frame-large">
                        <div class="room-plane ceiling"></div>
                        <div class="room-plane wall"></div>
                        <div class="room-plane floor"></div>
                        <div class="furniture sofa"></div>
                        <div class="furniture table"></div>
                        <div class="furniture lamp"></div>
                    </div>
                    <div class="visual-frame visual-frame-small">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </section>

            <section id="about" class="about section-shell" data-reveal>
                <div class="section-kicker">About</div>
                <div class="section-grid">
                    <h2>
                        Interior design with an editorial eye and a practical
                        plan.
                    </h2>
                    <div class="section-copy">
                        <p>
                            I create interior design concepts that bring
                            architecture, materials, furniture, and light into
                            one coherent atmosphere.
                        </p>
                        <p>
                            The approach is restrained and intentional: clear
                            planning first, expressive texture second, and
                            details that support how the space is actually lived
                            in.
                        </p>
                        <div class="strength-list">
                            <span v-for="strength in strengths" :key="strength">
                                {{ strength }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="projects" class="projects section-shell" data-reveal>
                <div class="section-heading">
                    <div>
                        <div class="section-kicker">Selected Projects</div>
                        <h2>Composed directions for interior work.</h2>
                    </div>
                    <p>
                        No project photography was present in the current
                        repository, so these cards avoid invented client facts
                        and focus on available design services.
                    </p>
                </div>

                <div class="project-grid">
                    <article
                        v-for="project in projects"
                        :key="project.title"
                        class="project-card"
                        :class="[
                            `tone-${project.tone}`,
                            { featured: project.featured },
                        ]"
                    >
                        <div class="project-image" aria-hidden="true">
                            <div class="image-grid"></div>
                            <div class="image-block block-one"></div>
                            <div class="image-block block-two"></div>
                            <div class="image-block block-three"></div>
                        </div>
                        <div class="project-meta">
                            <span>{{ project.type }}</span>
                            <ArrowUpRight :size="18" />
                        </div>
                        <h3>{{ project.title }}</h3>
                        <p>{{ project.description }}</p>
                    </article>
                </div>
            </section>

            <section id="services" class="services section-shell" data-reveal>
                <div class="section-kicker">Services</div>
                <div class="service-list">
                    <div
                        v-for="(service, index) in services"
                        :key="service"
                        class="service-row"
                    >
                        <span>{{ String(index + 1).padStart(2, '0') }}</span>
                        <h3>{{ service }}</h3>
                    </div>
                </div>
            </section>

            <section id="process" class="process section-shell" data-reveal>
                <div class="section-heading">
                    <div>
                        <div class="section-kicker">Process</div>
                        <h2>From first brief to final design.</h2>
                    </div>
                    <p>
                        A simple sequence keeps the visual concept and practical
                        decisions moving together.
                    </p>
                </div>

                <div class="process-track">
                    <div
                        v-for="(step, index) in processSteps"
                        :key="step"
                        class="process-step"
                    >
                        <span>{{ String(index + 1).padStart(2, '0') }}</span>
                        <strong>{{ step }}</strong>
                    </div>
                </div>
            </section>

            <section id="contact" class="contact section-shell" data-reveal>
                <div class="contact-panel">
                    <p class="eyebrow">Contact</p>
                    <h2>
                        Let us shape a space with calm, purpose, and texture.
                    </h2>
                    <p>
                        Share the brief, room type, and the atmosphere you want
                        to create. Contact details can be connected here once
                        they are added to the project.
                    </p>
                    <a class="button button-primary" href="#home">
                        Start from the Top
                        <Mail :size="17" />
                    </a>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <span>Karina Getmanenko</span>
            <span>{{ currentYear }}</span>
        </footer>
    </div>
</template>

<style scoped>
.portfolio-page {
    min-height: 100vh;
    overflow-x: hidden;
    background: #f4f0e9;
    color: #171512;
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
    border-bottom: 1px solid rgba(23, 21, 18, 0.12);
    background: rgba(244, 240, 233, 0.82);
    padding: 18px clamp(18px, 4vw, 56px);
    backdrop-filter: blur(18px);
}

.brand {
    display: inline-flex;
    width: fit-content;
    flex-direction: column;
    color: inherit;
    text-decoration: none;
}

.brand span {
    font-size: 15px;
    font-weight: 600;
    line-height: 1.1;
}

.brand small {
    margin-top: 3px;
    color: #746c60;
    font-size: 11px;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.desktop-nav {
    display: flex;
    align-items: center;
    gap: 22px;
}

.desktop-nav a,
.mobile-nav a {
    color: #342f28;
    font-size: 13px;
    text-decoration: none;
    transition:
        color 180ms ease,
        opacity 180ms ease;
}

.desktop-nav a:hover,
.mobile-nav a:hover {
    color: #8d5f3d;
}

.menu-button {
    display: none;
    place-self: end;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(23, 21, 18, 0.16);
    border-radius: 8px;
    background: #fffaf1;
    color: #171512;
}

.mobile-nav {
    display: none;
}

.section-shell {
    width: min(100% - 36px, 1180px);
    margin: 0 auto;
}

.hero {
    display: grid;
    min-height: 100vh;
    grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
    align-items: center;
    gap: clamp(28px, 4vw, 64px);
    padding-top: 116px;
    padding-bottom: 70px;
}

.hero-copy {
    animation: hero-in 850ms ease both;
}

.eyebrow,
.section-kicker {
    color: #8d5f3d;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}

.hero h1 {
    max-width: 760px;
    margin: 22px 0 24px;
    overflow-wrap: anywhere;
    font-size: clamp(56px, 7.2vw, 116px);
    font-weight: 500;
    line-height: 0.92;
}

.hero-text {
    max-width: 590px;
    color: #50483d;
    font-size: clamp(18px, 2vw, 24px);
    line-height: 1.45;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 34px;
}

.button {
    display: inline-flex;
    min-height: 48px;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 8px;
    padding: 0 20px;
    font-size: 14px;
    font-weight: 600;
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
    border: 1px solid #171512;
    background: #171512;
    color: #fffaf1;
}

.button-secondary {
    border: 1px solid rgba(23, 21, 18, 0.2);
    background: transparent;
    color: #171512;
}

.hero-visual {
    position: relative;
    min-height: 620px;
    animation: hero-in 950ms 120ms ease both;
}

.visual-frame {
    position: absolute;
    overflow: hidden;
    border: 1px solid rgba(23, 21, 18, 0.12);
    border-radius: 8px;
    background: #d8d0c4;
    box-shadow: 0 24px 70px rgba(49, 40, 31, 0.16);
}

.visual-frame-large {
    inset: 0 8% 8% 0;
}

.visual-frame-small {
    right: 0;
    bottom: 0;
    display: grid;
    width: 44%;
    min-width: 230px;
    aspect-ratio: 1 / 1.05;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    padding: 16px;
    background: #eee8dc;
}

.visual-frame-small span {
    border-radius: 6px;
}

.visual-frame-small span:nth-child(1) {
    background: #aa8d71;
}

.visual-frame-small span:nth-child(2) {
    background: #282721;
}

.visual-frame-small span:nth-child(3) {
    background: #cfc3b2;
}

.room-plane {
    position: absolute;
}

.ceiling {
    inset: 0 0 auto;
    height: 30%;
    background: linear-gradient(120deg, #ebe3d6, #c6b8a7);
}

.wall {
    inset: 24% 8% 22%;
    border-radius: 8px;
    background:
        linear-gradient(90deg, rgba(255, 255, 255, 0.38), transparent 30%),
        #b9aa98;
}

.floor {
    right: -8%;
    bottom: -22%;
    left: -8%;
    height: 48%;
    transform: skewY(-8deg);
    background:
        repeating-linear-gradient(
            90deg,
            rgba(255, 255, 255, 0.17) 0 1px,
            transparent 1px 82px
        ),
        #8e806f;
}

.furniture {
    position: absolute;
    border-radius: 8px;
}

.sofa {
    right: 12%;
    bottom: 22%;
    width: 58%;
    height: 17%;
    background: #e7ded2;
    box-shadow: 0 18px 30px rgba(23, 21, 18, 0.18);
}

.table {
    right: 22%;
    bottom: 14%;
    width: 28%;
    height: 5%;
    background: #312c25;
}

.lamp {
    top: 16%;
    left: 16%;
    width: 4px;
    height: 45%;
    background: #312c25;
}

.lamp::after {
    position: absolute;
    top: 36%;
    left: 50%;
    width: 90px;
    height: 90px;
    transform: translateX(-50%);
    border-radius: 50%;
    background: rgba(255, 250, 241, 0.45);
    content: '';
}

.about,
.projects,
.services,
.process,
.contact {
    padding: clamp(76px, 10vw, 132px) 0;
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

.section-grid,
.section-heading {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(280px, 0.65fr);
    gap: clamp(30px, 7vw, 88px);
}

.section-grid h2,
.section-heading h2,
.contact h2 {
    margin: 14px 0 0;
    font-size: clamp(36px, 5.8vw, 76px);
    font-weight: 500;
    line-height: 0.96;
}

.section-copy,
.section-heading p,
.contact p {
    color: #5b5247;
    font-size: 17px;
    line-height: 1.7;
}

.section-copy p + p {
    margin-top: 18px;
}

.strength-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 26px;
}

.strength-list span {
    border: 1px solid rgba(23, 21, 18, 0.14);
    border-radius: 999px;
    padding: 9px 12px;
    color: #342f28;
    font-size: 13px;
}

.project-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-top: 46px;
}

.project-card {
    min-height: 520px;
    overflow: hidden;
    border: 1px solid rgba(23, 21, 18, 0.12);
    border-radius: 8px;
    background: #fffaf1;
    transition:
        transform 220ms ease,
        box-shadow 220ms ease;
}

.project-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 60px rgba(49, 40, 31, 0.16);
}

.project-card.featured {
    grid-column: span 1;
}

.project-image {
    position: relative;
    height: 300px;
    overflow: hidden;
}

.image-grid {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(rgba(255, 255, 255, 0.24) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.24) 1px, transparent 1px);
    background-size: 46px 46px;
}

.image-block {
    position: absolute;
    border-radius: 8px;
}

.block-one {
    right: 10%;
    bottom: 16%;
    width: 58%;
    height: 34%;
}

.block-two {
    top: 12%;
    left: 12%;
    width: 36%;
    height: 54%;
}

.block-three {
    right: 14%;
    bottom: 54%;
    width: 26%;
    height: 18%;
}

.tone-warm .project-image {
    background: #c7aa8e;
}

.tone-warm .block-one,
.tone-warm .block-three {
    background: #f1e6d8;
}

.tone-warm .block-two {
    background: #6e5544;
}

.tone-stone .project-image {
    background: #a6aaa4;
}

.tone-stone .block-one,
.tone-stone .block-three {
    background: #e9e3d8;
}

.tone-stone .block-two {
    background: #53564d;
}

.tone-charcoal .project-image {
    background: #34342f;
}

.tone-charcoal .block-one,
.tone-charcoal .block-three {
    background: #c6bcae;
}

.tone-charcoal .block-two {
    background: #81705e;
}

.project-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 24px 0;
    color: #8d5f3d;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.project-card h3 {
    margin: 22px 24px 10px;
    font-size: 26px;
    font-weight: 500;
    line-height: 1.05;
}

.project-card p {
    margin: 0 24px 28px;
    color: #5b5247;
    line-height: 1.6;
}

.service-list {
    border-top: 1px solid rgba(23, 21, 18, 0.14);
}

.service-row {
    display: grid;
    grid-template-columns: 88px 1fr;
    align-items: center;
    border-bottom: 1px solid rgba(23, 21, 18, 0.14);
    padding: 28px 0;
}

.service-row span,
.process-step span {
    color: #8d5f3d;
    font-size: 13px;
    font-weight: 600;
}

.service-row h3 {
    margin: 0;
    font-size: clamp(28px, 4.8vw, 58px);
    font-weight: 500;
    line-height: 1;
}

.process-track {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1px;
    margin-top: 48px;
    background: rgba(23, 21, 18, 0.14);
    border: 1px solid rgba(23, 21, 18, 0.14);
}

.process-step {
    min-height: 180px;
    background: #f4f0e9;
    padding: 22px;
}

.process-step strong {
    display: block;
    margin-top: 54px;
    font-size: 21px;
    font-weight: 500;
}

.contact-panel {
    display: grid;
    min-height: 430px;
    align-content: center;
    border-radius: 8px;
    background: #171512;
    padding: clamp(28px, 7vw, 80px);
    color: #fffaf1;
}

.contact-panel p {
    max-width: 650px;
    color: rgba(255, 250, 241, 0.72);
}

.contact-panel .button {
    width: fit-content;
    margin-top: 22px;
    border-color: #fffaf1;
    background: #fffaf1;
    color: #171512;
}

.site-footer {
    display: flex;
    justify-content: space-between;
    width: min(100% - 36px, 1180px);
    margin: 0 auto;
    border-top: 1px solid rgba(23, 21, 18, 0.14);
    padding: 26px 0 34px;
    color: #746c60;
    font-size: 13px;
}

@keyframes hero-in {
    from {
        transform: translateY(28px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 980px) {
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
        top: 79px;
        right: 18px;
        left: 18px;
        display: grid;
        max-height: 0;
        overflow: hidden;
        border: 1px solid rgba(23, 21, 18, 0.12);
        border-radius: 8px;
        background: #fffaf1;
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
        border-bottom: 1px solid rgba(23, 21, 18, 0.08);
        font-size: 15px;
    }

    .mobile-nav a:last-child {
        border-bottom: 0;
    }

    .hero,
    .section-grid,
    .section-heading {
        grid-template-columns: 1fr;
    }

    .hero {
        min-height: auto;
        padding-top: 126px;
    }

    .hero-visual {
        min-height: 520px;
    }

    .project-grid {
        grid-template-columns: 1fr;
    }

    .process-track {
        grid-template-columns: 1fr;
    }

    .process-step {
        min-height: 130px;
    }

    .process-step strong {
        margin-top: 34px;
    }
}

@media (max-width: 620px) {
    .section-shell,
    .site-footer {
        width: min(100% - 28px, 1180px);
    }

    .site-header {
        padding: 14px;
    }

    .brand span {
        font-size: 14px;
    }

    .brand small {
        font-size: 10px;
    }

    .hero h1 {
        font-size: clamp(52px, 20vw, 86px);
    }

    .hero-actions {
        display: grid;
    }

    .button {
        width: 100%;
    }

    .hero-visual {
        min-height: 410px;
    }

    .visual-frame-large {
        inset: 0 0 11% 0;
    }

    .visual-frame-small {
        width: 58%;
        min-width: 0;
    }

    .service-row {
        grid-template-columns: 54px 1fr;
    }

    .project-card {
        min-height: 0;
    }

    .project-image {
        height: 240px;
    }

    .site-footer {
        gap: 12px;
        flex-direction: column;
    }
}
</style>
