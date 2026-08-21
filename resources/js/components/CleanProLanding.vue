<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {
    ArrowRight,
    Check,
    Clock,
    Mail,
    MapPin,
    Menu,
    Phone,
    ShieldCheck,
    Sparkles,
    SprayCan,
    X,
} from '@lucide/vue';
import { computed, nextTick, onMounted, onUnmounted, ref } from 'vue';

type PageProps = {
    auth?: {
        user?: unknown;
    };
    flash?: {
        success?: string;
    };
};

const page = usePage<PageProps>();
const menuOpen = ref(false);
const isContentLeaving = ref(false);
const isTransitionLayerVisible = ref(false);
const isTransitionLayerLeaving = ref(false);
const isCategoryTransitioning = ref(false);
const activeTransitionLabel = ref('CleanPro');
const prefersReducedMotion = ref(false);
const currentYear = new Date().getFullYear();
const isAuthenticated = computed(() => Boolean(page.props.auth?.user));

const navItems = [
    { label: 'Услуги', href: '#services' },
    { label: 'Преимущества', href: '#benefits' },
    { label: 'Процесс', href: '#process' },
    { label: 'Заявка', href: '#request' },
    { label: 'Контакты', href: '#contacts' },
];

const services = [
    {
        title: 'Уборка квартир',
        text: 'Поддерживающая и генеральная уборка кухни, санузлов, комнат и прихожей.',
        image: '/images/generated/interior-kitchen.png',
    },
    {
        title: 'Уборка домов',
        text: 'Комплексный клининг частных домов, лестниц, гардеробных и жилых зон.',
        image: '/images/generated/interior-bedroom.png',
    },
    {
        title: 'Офисный клининг',
        text: 'Регулярная уборка рабочих мест, переговорных, кухни и входной группы.',
        image: '/images/generated/office-cleaning.jpg',
    },
];

const benefits = [
    'Выезд по Риге и ближайшим районам',
    'Безопасная бытовая химия и аккуратный инвентарь',
    'Понятная коммуникация до, во время и после уборки',
    'Можно заказать разовую или регулярную уборку',
];

const steps = [
    'Оставляете заявку на сайте',
    'Мы уточняем объём и удобное время',
    'Команда приезжает и выполняет уборку',
    'Вы принимаете работу и оплачиваете услугу',
];

const form = useForm({
    name: '',
    phone: '',
    email: '',
    service: 'Уборка квартиры',
    address: '',
    message: '',
});

const submitRequest = () => {
    form.post('/requests', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const closeMenu = () => {
    menuOpen.value = false;
};

const wait = (duration: number) =>
    new Promise((resolve) => window.setTimeout(resolve, duration));

const animateTargetSection = (target: HTMLElement) => {
    target.classList.remove('category-entering');
    target
        .querySelectorAll<HTMLElement>('.category-stagger-item')
        .forEach((element) => element.style.removeProperty('--stagger-index'));

    void target.offsetWidth;

    target
        .querySelectorAll<HTMLElement>('.category-stagger-item')
        .forEach((element, index) => {
            element.style.setProperty('--stagger-index', String(index));
        });

    target.classList.add('category-entering');
    window.setTimeout(() => target.classList.remove('category-entering'), 1200);
};

const openCategory = async (event: MouseEvent, href: string, label: string) => {
    if (!href.startsWith('#')) {
        return;
    }

    event.preventDefault();
    closeMenu();

    if (isCategoryTransitioning.value) {
        return;
    }

    const target = document.querySelector<HTMLElement>(href);

    if (!target) {
        return;
    }

    activeTransitionLabel.value = label;

    if (prefersReducedMotion.value) {
        target.scrollIntoView({ block: 'start' });
        window.history.pushState(null, '', href);
        return;
    }

    isCategoryTransitioning.value = true;
    isContentLeaving.value = true;
    isTransitionLayerLeaving.value = false;
    isTransitionLayerVisible.value = true;

    await wait(420);
    target.scrollIntoView({ block: 'start' });
    window.history.pushState(null, '', href);
    await nextTick();

    isContentLeaving.value = false;
    await wait(90);
    animateTargetSection(target);
    isTransitionLayerLeaving.value = true;

    await wait(780);
    isTransitionLayerVisible.value = false;
    isTransitionLayerLeaving.value = false;
    isCategoryTransitioning.value = false;
};

const replayCategoryFromHistory = async () => {
    const href = window.location.hash;

    if (!href || isCategoryTransitioning.value) {
        return;
    }

    const target = document.querySelector<HTMLElement>(href);

    if (!target) {
        return;
    }

    const item = navItems.find((navItem) => navItem.href === href);
    activeTransitionLabel.value = item?.label ?? 'CleanPro';

    if (prefersReducedMotion.value) {
        target.scrollIntoView({ block: 'start' });
        return;
    }

    isCategoryTransitioning.value = true;
    isContentLeaving.value = true;
    isTransitionLayerLeaving.value = false;
    isTransitionLayerVisible.value = true;

    await wait(420);
    target.scrollIntoView({ block: 'start' });
    await nextTick();

    isContentLeaving.value = false;
    await wait(90);
    animateTargetSection(target);
    isTransitionLayerLeaving.value = true;

    await wait(780);
    isTransitionLayerVisible.value = false;
    isTransitionLayerLeaving.value = false;
    isCategoryTransitioning.value = false;
};

let observer: IntersectionObserver | null = null;
let motionQuery: MediaQueryList | null = null;
let updateMotionPreference: ((event: MediaQueryListEvent) => void) | null =
    null;

onMounted(() => {
    motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    prefersReducedMotion.value = motionQuery.matches;

    updateMotionPreference = (event: MediaQueryListEvent) => {
        prefersReducedMotion.value = event.matches;
    };

    motionQuery.addEventListener('change', updateMotionPreference);
    window.addEventListener('popstate', replayCategoryFromHistory);

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer?.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.16 },
    );

    document
        .querySelectorAll<HTMLElement>('[data-reveal]')
        .forEach((element) => observer?.observe(element));
});

onUnmounted(() => {
    observer?.disconnect();
    window.removeEventListener('popstate', replayCategoryFromHistory);

    if (updateMotionPreference) {
        motionQuery?.removeEventListener('change', updateMotionPreference);
    }
});
</script>

<template>
    <div
        class="cleanpro-page"
        :class="{ 'is-content-leaving': isContentLeaving }"
    >
        <div
            v-if="isTransitionLayerVisible"
            class="page-transition-layer"
            :class="{ 'is-leaving': isTransitionLayerLeaving }"
            aria-hidden="true"
        >
            <span>{{ activeTransitionLabel }}</span>
        </div>

        <header class="site-header">
            <a class="brand" href="#top" @click="closeMenu">
                <span class="brand-mark">
                    <Sparkles :size="22" />
                </span>
                <span>CleanPro</span>
            </a>

            <nav class="desktop-nav" aria-label="Основная навигация">
                <a
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    @click="openCategory($event, item.href, item.label)"
                >
                    {{ item.label }}
                </a>
            </nav>

            <div class="header-actions">
                <a class="phone-link" href="tel:+37120123456">
                    <Phone :size="16" />
                    +371 20 123 456
                </a>
                <Link
                    v-if="isAuthenticated"
                    class="admin-link"
                    href="/dashboard"
                >
                    Админка
                </Link>
                <Link v-else class="admin-link" href="/login">Вход</Link>
            </div>

            <button
                class="menu-button"
                type="button"
                :aria-expanded="menuOpen"
                aria-controls="mobile-nav"
                aria-label="Открыть меню"
                @click="menuOpen = !menuOpen"
            >
                <X v-if="menuOpen" :size="20" />
                <Menu v-else :size="20" />
            </button>

            <nav
                id="mobile-nav"
                class="mobile-nav"
                :class="{ 'is-open': menuOpen }"
                aria-label="Мобильная навигация"
            >
                <a
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    @click="openCategory($event, item.href, item.label)"
                >
                    {{ item.label }}
                </a>
                <Link href="/login" @click="closeMenu">
                    Вход администратора
                </Link>
            </nav>
        </header>

        <main id="top">
            <section class="hero section-shell">
                <div class="hero-copy" data-reveal>
                    <p class="eyebrow">Клининговая компания в Риге</p>
                    <h1>CleanPro</h1>
                    <p class="hero-text">
                        Аккуратная уборка квартир, домов и офисов с понятным
                        сервисом, быстрым откликом и вниманием к деталям.
                    </p>
                    <div class="hero-actions">
                        <a
                            class="button button-primary"
                            href="#request"
                            @click="openCategory($event, '#request', 'Заявка')"
                        >
                            Оставить заявку
                            <ArrowRight :size="18" />
                        </a>
                        <a
                            class="button button-secondary"
                            href="#services"
                            @click="openCategory($event, '#services', 'Услуги')"
                        >
                            Смотреть услуги
                        </a>
                    </div>
                    <div class="hero-stats" aria-label="Преимущества CleanPro">
                        <span><strong>7 дней</strong> в неделю</span>
                        <span><strong>24 ч</strong> подтверждение</span>
                        <span><strong>100%</strong> порядок</span>
                    </div>
                </div>

                <div class="hero-visual" data-reveal>
                    <img
                        src="/images/generated/hero-vacuum-cleaning.jpg"
                        alt="Пылесос в чистой гостиной после уборки"
                    />
                    <div class="hero-card">
                        <ShieldCheck :size="22" />
                        <span>Проверенная команда и бережная уборка</span>
                    </div>
                </div>
            </section>

            <section id="services" class="section-shell services" data-reveal>
                <div class="section-heading category-stagger-item">
                    <p class="eyebrow">Услуги</p>
                    <h2>Уборка для дома, работы и спокойного графика.</h2>
                </div>

                <div class="service-grid">
                    <article
                        v-for="service in services"
                        :key="service.title"
                        class="service-card category-stagger-item"
                    >
                        <img :src="service.image" :alt="service.title" />
                        <div>
                            <h3>{{ service.title }}</h3>
                            <p>{{ service.text }}</p>
                        </div>
                    </article>
                </div>
            </section>

            <section id="benefits" class="benefits-band" data-reveal>
                <div class="section-shell benefits-grid">
                    <div class="category-stagger-item">
                        <p class="eyebrow">Почему CleanPro</p>
                        <h2>Современный клининг без лишней сложности.</h2>
                        <p>
                            Мы заранее уточняем детали, приезжаем вовремя и
                            оставляем после себя чистое пространство, в которое
                            приятно возвращаться.
                        </p>
                    </div>
                    <div class="benefit-list category-stagger-item">
                        <div
                            v-for="benefit in benefits"
                            :key="benefit"
                            class="benefit-item"
                        >
                            <Check :size="18" />
                            <span>{{ benefit }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="process" class="section-shell process" data-reveal>
                <div class="section-heading category-stagger-item">
                    <p class="eyebrow">Процесс</p>
                    <h2>От заявки до чистого результата за четыре шага.</h2>
                </div>

                <div class="step-grid">
                    <article
                        v-for="(step, index) in steps"
                        :key="step"
                        class="step-card category-stagger-item"
                    >
                        <span>{{ String(index + 1).padStart(2, '0') }}</span>
                        <p>{{ step }}</p>
                    </article>
                </div>
            </section>

            <section id="request" class="request-section" data-reveal>
                <div class="section-shell request-grid">
                    <div class="request-copy category-stagger-item">
                        <p class="eyebrow">Заявка</p>
                        <h2>Расскажите, что нужно убрать.</h2>
                        <p>
                            Заполните форму, и администратор CleanPro свяжется с
                            вами для уточнения деталей и расчёта стоимости.
                        </p>
                        <div class="request-note">
                            <Clock :size="20" />
                            <span class="request-hours">
                                <span>Пн-Пт: 08:00-19:00</span>
                                <span>Сб: 09:00-17:00</span>
                            </span>
                        </div>
                    </div>

                    <form
                        class="request-form category-stagger-item"
                        @submit.prevent="submitRequest"
                    >
                        <div
                            v-if="page.props.flash?.success"
                            class="success-message"
                        >
                            {{ page.props.flash.success }}
                        </div>

                        <label>
                            Имя
                            <input
                                v-model="form.name"
                                type="text"
                                name="name"
                            />
                            <small v-if="form.errors.name">
                                {{ form.errors.name }}
                            </small>
                        </label>

                        <label>
                            Телефон
                            <input
                                v-model="form.phone"
                                type="tel"
                                name="phone"
                                placeholder="+371"
                            />
                            <small v-if="form.errors.phone">
                                {{ form.errors.phone }}
                            </small>
                        </label>

                        <label>
                            E-mail
                            <input
                                v-model="form.email"
                                type="email"
                                name="email"
                            />
                            <small v-if="form.errors.email">
                                {{ form.errors.email }}
                            </small>
                        </label>

                        <label>
                            Услуга
                            <select v-model="form.service" name="service">
                                <option>Уборка квартиры</option>
                                <option>Уборка дома</option>
                                <option>Офисный клининг</option>
                                <option>Генеральная уборка</option>
                                <option>Другая услуга</option>
                            </select>
                            <small v-if="form.errors.service">
                                {{ form.errors.service }}
                            </small>
                        </label>

                        <label class="full">
                            Адрес
                            <input
                                v-model="form.address"
                                type="text"
                                name="address"
                            />
                            <small v-if="form.errors.address">
                                {{ form.errors.address }}
                            </small>
                        </label>

                        <label class="full">
                            Комментарий
                            <textarea
                                v-model="form.message"
                                name="message"
                                rows="4"
                            ></textarea>
                            <small v-if="form.errors.message">
                                {{ form.errors.message }}
                            </small>
                        </label>

                        <button
                            class="button button-primary full"
                            type="submit"
                            :disabled="form.processing"
                        >
                            {{
                                form.processing
                                    ? 'Отправляем...'
                                    : 'Отправить заявку'
                            }}
                            <SprayCan :size="18" />
                        </button>
                    </form>
                </div>
            </section>

            <section id="contacts" class="section-shell contacts" data-reveal>
                <div class="section-heading category-stagger-item">
                    <p class="eyebrow">Контакты</p>
                    <h2>CleanPro, Rīga, Latvija</h2>
                </div>

                <div class="contact-grid">
                    <div class="contact-card category-stagger-item">
                        <a href="tel:+37120123456">
                            <Phone :size="19" />
                            +371 20 123 456
                        </a>
                        <a href="mailto:info@cleanpro.lv">
                            <Mail :size="19" />
                            info@cleanpro.lv
                        </a>
                        <div>
                            <Clock :size="19" />
                            <span>
                                Пн-Пт: 08:00-19:00<br />
                                Сб: 09:00-17:00
                            </span>
                        </div>
                        <div>
                            <MapPin :size="19" />
                            <span>Rīga, Latvija</span>
                        </div>
                    </div>

                    <iframe
                        class="map-frame category-stagger-item"
                        title="Карта CleanPro в Риге"
                        src="https://www.openstreetmap.org/export/embed.html?bbox=23.947%2C56.879%2C24.245%2C57.023&layer=mapnik&marker=56.9496%2C24.1052"
                        loading="lazy"
                    ></iframe>
                </div>
            </section>
        </main>

        <footer class="site-footer section-shell">
            <div class="footer-brand">
                <Sparkles :size="19" />
                <strong>CleanPro</strong>
            </div>
            <nav aria-label="Навигация в footer">
                <a
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    @click="openCategory($event, item.href, item.label)"
                >
                    {{ item.label }}
                </a>
            </nav>
            <div class="footer-contacts">
                <a href="tel:+37120123456">+371 20 123 456</a>
                <a href="mailto:info@cleanpro.lv">info@cleanpro.lv</a>
            </div>
            <p>© {{ currentYear }} CleanPro. Все права защищены.</p>
        </footer>
    </div>
</template>

<style scoped>
.cleanpro-page {
    min-height: 100vh;
    background: #f5f7f3;
    color: #13211b;
    font-family:
        Inter,
        'Instrument Sans',
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        'Segoe UI',
        sans-serif;
    scroll-behavior: smooth;
}

.cleanpro-page main,
.cleanpro-page footer {
    transition:
        opacity 520ms cubic-bezier(0.22, 1, 0.36, 1),
        transform 520ms cubic-bezier(0.22, 1, 0.36, 1),
        filter 520ms cubic-bezier(0.22, 1, 0.36, 1);
}

.cleanpro-page.is-content-leaving main,
.cleanpro-page.is-content-leaving footer {
    transform: translateY(12px) scale(0.992);
    opacity: 0.42;
    filter: blur(2px);
}

.page-transition-layer {
    position: fixed;
    inset: 0;
    z-index: 80;
    display: grid;
    place-items: center;
    background:
        linear-gradient(135deg, rgba(168, 224, 200, 0.08), transparent 42%),
        #12281e;
    color: #e8f7ef;
    pointer-events: none;
    transform: translateY(0);
    opacity: 1;
    animation: transition-cover-in 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
}

.page-transition-layer::after {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(168, 224, 200, 0.54),
        transparent
    );
    content: '';
}

.page-transition-layer span {
    transform: translateY(10px);
    opacity: 0;
    font-size: clamp(28px, 6vw, 78px);
    font-weight: 950;
    letter-spacing: 0.02em;
    animation: transition-label-in 620ms cubic-bezier(0.22, 1, 0.36, 1) 120ms
        both;
}

.page-transition-layer.is-leaving {
    animation: transition-cover-out 780ms cubic-bezier(0.76, 0, 0.24, 1) both;
}

.section-shell {
    width: min(100% - 40px, 1180px);
    margin: 0 auto;
}

.site-header {
    position: sticky;
    top: 0;
    z-index: 20;
    display: grid;
    grid-template-columns: auto 1fr auto auto;
    align-items: center;
    gap: 24px;
    border-bottom: 1px solid rgba(22, 61, 42, 0.1);
    background: rgba(245, 247, 243, 0.88);
    padding: 16px clamp(20px, 4vw, 48px);
    backdrop-filter: blur(18px);
}

.brand,
.footer-brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #10251b;
    font-size: 22px;
    font-weight: 900;
    text-decoration: none;
}

.brand-mark,
.footer-brand svg {
    display: grid;
    width: 38px;
    height: 38px;
    place-items: center;
    border-radius: 8px;
    background: #1e6b4c;
    color: #ffffff;
}

.desktop-nav,
.site-footer nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 18px;
}

.desktop-nav a,
.site-footer nav a,
.footer-contacts a {
    color: #345045;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: color 180ms ease;
}

.desktop-nav a:hover,
.site-footer a:hover {
    color: #1e6b4c;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.phone-link,
.admin-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-height: 42px;
    border-radius: 8px;
    padding: 0 14px;
    color: #153225;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
}

.phone-link {
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(20, 53, 38, 0.08);
}

.admin-link {
    border: 1px solid rgba(30, 107, 76, 0.24);
}

.menu-button,
.mobile-nav {
    display: none;
}

.hero {
    display: grid;
    grid-template-columns: minmax(0, 0.92fr) minmax(360px, 1fr);
    gap: clamp(32px, 7vw, 86px);
    align-items: center;
    min-height: calc(100vh - 76px);
    padding: clamp(54px, 9vw, 104px) 0;
}

.eyebrow {
    margin: 0 0 12px;
    color: #2d7b5b;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}

h1,
h2,
h3,
p {
    margin-top: 0;
}

h1 {
    margin-bottom: 22px;
    font-size: clamp(58px, 10vw, 126px);
    font-weight: 950;
    line-height: 0.9;
}

h2 {
    max-width: 760px;
    margin-bottom: 18px;
    font-size: clamp(34px, 5vw, 64px);
    font-weight: 920;
    line-height: 1.02;
}

.hero-text,
.benefits-grid p,
.request-copy p {
    max-width: 640px;
    color: #52665d;
    font-size: clamp(17px, 2vw, 21px);
    line-height: 1.65;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 32px;
}

.button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 52px;
    border: 0;
    border-radius: 8px;
    padding: 0 20px;
    font-weight: 900;
    text-decoration: none;
    cursor: pointer;
    transition:
        transform 180ms ease,
        box-shadow 180ms ease,
        background 180ms ease;
}

.button:hover {
    transform: translateY(-2px);
}

.button-primary {
    background: #1e6b4c;
    color: #ffffff;
    box-shadow: 0 16px 38px rgba(30, 107, 76, 0.22);
}

.button-primary:hover {
    background: #15583d;
}

.button-secondary {
    border: 1px solid rgba(30, 107, 76, 0.22);
    background: #ffffff;
    color: #153225;
}

.hero-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 34px;
}

.hero-stats span {
    border-left: 3px solid #9ccfba;
    padding-left: 12px;
    color: #5a6c63;
    font-size: 14px;
}

.hero-stats strong {
    display: block;
    color: #153225;
    font-size: 22px;
}

.hero-visual {
    position: relative;
}

.hero-visual img {
    width: 100%;
    height: clamp(420px, 42vw, 460px);
    border-radius: 8px;
    object-fit: cover;
    object-position: center 70%;
    box-shadow: 0 30px 90px rgba(27, 62, 46, 0.2);
}

.hero-card {
    position: absolute;
    right: -18px;
    bottom: 28px;
    display: flex;
    max-width: 280px;
    align-items: center;
    gap: 12px;
    border-radius: 8px;
    background: #ffffff;
    padding: 18px;
    color: #193729;
    font-weight: 900;
    box-shadow: 0 24px 60px rgba(18, 49, 35, 0.16);
}

.services,
.process,
.contacts {
    padding: clamp(72px, 10vw, 128px) 0;
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-top: 38px;
}

.service-card {
    overflow: hidden;
    border: 1px solid rgba(22, 61, 42, 0.12);
    border-radius: 8px;
    background: #ffffff;
    box-shadow: 0 18px 46px rgba(16, 49, 34, 0.08);
    transition:
        transform 190ms ease,
        box-shadow 190ms ease;
}

.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 62px rgba(16, 49, 34, 0.13);
}

.service-card img {
    width: 100%;
    aspect-ratio: 4 / 3;
    object-fit: cover;
}

.service-card div {
    padding: 22px;
}

.service-card h3 {
    margin-bottom: 10px;
    font-size: 23px;
}

.service-card p,
.step-card p {
    color: #5b6d64;
    line-height: 1.6;
}

.benefits-band,
.request-section {
    background: #12281e;
    color: #ffffff;
    padding: clamp(76px, 10vw, 122px) 0;
}

.benefits-grid,
.request-grid,
.contact-grid {
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(340px, 1fr);
    gap: clamp(30px, 6vw, 84px);
    align-items: start;
}

.benefits-grid p,
.request-copy p {
    color: #c7d8d0;
}

.benefit-list {
    display: grid;
    gap: 14px;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 13px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.055);
    padding: 18px;
    font-weight: 800;
}

.benefit-item svg,
.request-note svg {
    flex: 0 0 auto;
    color: #a8e0c8;
}

.step-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-top: 34px;
}

.step-card {
    min-height: 178px;
    border: 1px solid rgba(22, 61, 42, 0.12);
    border-radius: 8px;
    background: #ffffff;
    padding: 22px;
}

.step-card span {
    display: block;
    margin-bottom: 28px;
    color: #2d7b5b;
    font-size: 13px;
    font-weight: 950;
    letter-spacing: 0.14em;
}

.request-note {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    max-width: 430px;
    margin-top: 28px;
    color: #deeee7;
    font-weight: 800;
}

.request-hours {
    display: grid;
    gap: 4px;
    line-height: 1.35;
}

.request-form {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
    border-radius: 8px;
    background: #ffffff;
    padding: clamp(20px, 4vw, 34px);
    color: #13211b;
    box-shadow: 0 26px 80px rgba(0, 0, 0, 0.18);
}

.request-form label {
    display: grid;
    gap: 8px;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.request-form input,
.request-form select,
.request-form textarea {
    width: 100%;
    border: 1px solid #dce5df;
    border-radius: 8px;
    background: #f8faf7;
    padding: 13px 14px;
    color: #13211b;
    font: inherit;
    font-size: 15px;
    outline: none;
    transition:
        border-color 160ms ease,
        box-shadow 160ms ease;
}

.request-form input:focus,
.request-form select:focus,
.request-form textarea:focus {
    border-color: #2d7b5b;
    box-shadow: 0 0 0 4px rgba(45, 123, 91, 0.13);
}

.request-form textarea {
    resize: vertical;
}

.request-form small {
    color: #b3261e;
    font-size: 12px;
    letter-spacing: 0;
    text-transform: none;
}

.full,
.success-message {
    grid-column: 1 / -1;
}

.success-message {
    border-radius: 8px;
    background: #e8f7ef;
    padding: 13px 14px;
    color: #15583d;
    font-weight: 900;
}

.button:disabled {
    cursor: wait;
    opacity: 0.72;
}

.contact-grid {
    margin-top: 32px;
}

.contact-card {
    display: grid;
    gap: 14px;
}

.contact-card a,
.contact-card div {
    display: flex;
    align-items: center;
    gap: 13px;
    border: 1px solid rgba(22, 61, 42, 0.12);
    border-radius: 8px;
    background: #ffffff;
    padding: 18px;
    color: #153225;
    font-weight: 850;
    text-decoration: none;
}

.contact-card svg {
    flex: 0 0 auto;
    color: #2d7b5b;
}

.map-frame {
    width: 100%;
    min-height: 360px;
    border: 0;
    border-radius: 8px;
    box-shadow: 0 18px 48px rgba(16, 49, 34, 0.1);
}

.site-footer {
    display: grid;
    grid-template-columns: auto minmax(220px, 1fr) auto;
    gap: 20px;
    align-items: center;
    border-top: 1px solid rgba(22, 61, 42, 0.12);
    padding: 28px 0 34px;
}

.footer-contacts {
    display: grid;
    gap: 7px;
    justify-items: end;
}

.site-footer p {
    grid-column: 1 / -1;
    margin: 0;
    color: #6a7d74;
    font-size: 13px;
    text-align: center;
}

[data-reveal] {
    transform: translateY(28px);
    opacity: 0;
    transition:
        opacity 650ms ease,
        transform 650ms ease;
}

[data-reveal].is-visible {
    transform: translateY(0);
    opacity: 1;
}

.category-entering .category-stagger-item {
    animation: category-stagger-in 820ms cubic-bezier(0.22, 1, 0.36, 1) both;
    animation-delay: calc(90ms + (var(--stagger-index, 0) * 90ms));
}

@keyframes transition-cover-in {
    from {
        transform: translateY(100%);
    }

    to {
        transform: translateY(0);
    }
}

@keyframes transition-cover-out {
    from {
        transform: translateY(0);
    }

    to {
        transform: translateY(-105%);
    }
}

@keyframes transition-label-in {
    from {
        transform: translateY(14px) scale(0.985);
        opacity: 0;
    }

    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

@keyframes category-stagger-in {
    from {
        transform: translateY(30px) scale(0.985);
        opacity: 0;
        filter: blur(4px);
    }

    to {
        transform: translateY(0) scale(1);
        opacity: 1;
        filter: blur(0);
    }
}

@media (max-width: 1040px) {
    .site-header {
        grid-template-columns: auto 1fr auto;
    }

    .desktop-nav,
    .header-actions {
        display: none;
    }

    .menu-button {
        display: inline-grid;
        width: 44px;
        height: 44px;
        place-items: center;
        justify-self: end;
        border: 1px solid rgba(30, 107, 76, 0.2);
        border-radius: 8px;
        background: #ffffff;
        color: #153225;
    }

    .mobile-nav {
        position: fixed;
        top: 76px;
        right: 18px;
        left: 18px;
        display: grid;
        max-height: 0;
        overflow: hidden;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 20px 50px rgba(16, 49, 34, 0.16);
        opacity: 0;
        transition:
            max-height 220ms ease,
            opacity 220ms ease;
    }

    .mobile-nav.is-open {
        max-height: 380px;
        opacity: 1;
    }

    .mobile-nav a {
        border-bottom: 1px solid #eef2ed;
        padding: 16px 18px;
        color: #153225;
        font-weight: 850;
        text-decoration: none;
    }

    .hero,
    .benefits-grid,
    .request-grid,
    .contact-grid {
        grid-template-columns: 1fr;
    }

    .hero {
        min-height: auto;
    }

    .service-grid,
    .step-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .hero-card {
        right: 18px;
    }

    .site-footer {
        grid-template-columns: 1fr;
        justify-items: start;
    }

    .site-footer nav {
        justify-content: flex-start;
    }

    .footer-contacts {
        justify-items: start;
    }
}

@media (max-width: 640px) {
    .section-shell {
        width: min(100% - 28px, 1180px);
    }

    .site-header {
        padding: 14px;
    }

    h1 {
        font-size: clamp(52px, 19vw, 78px);
    }

    .hero-actions,
    .button,
    .hero-stats {
        width: 100%;
    }

    .hero-visual img {
        height: clamp(320px, 86vw, 360px);
    }

    .hero-card {
        position: static;
        max-width: none;
        margin-top: 12px;
    }

    .service-grid,
    .step-grid,
    .request-form {
        grid-template-columns: 1fr;
    }

    .services,
    .process,
    .contacts {
        padding: 64px 0;
    }
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition-duration: 1ms !important;
        animation-duration: 1ms !important;
    }

    .cleanpro-page.is-content-leaving main,
    .cleanpro-page.is-content-leaving footer {
        transform: none;
        opacity: 1;
        filter: none;
    }

    .page-transition-layer {
        display: none;
    }
}
</style>
