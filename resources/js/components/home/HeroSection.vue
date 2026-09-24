<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ArrowRight, ChevronDown, MapPin, Pause, Play } from '@lucide/vue';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import SiteLink from '@/components/common/SiteLink.vue';
import { Button } from '@/components/ui/button';

type VideoSource = { src: string; type: string };

const desktopVideo: VideoSource[] = [
    { src: '/video/spp-inicio.webm', type: 'video/webm' },
    { src: '/video/spp-inicio.mp4', type: 'video/mp4' },
];

const mobileVideo: VideoSource[] = [
    { src: '/video/spp-inicio-720.webm', type: 'video/webm' },
    { src: '/video/spp-inicio-720.mp4', type: 'video/mp4' },
];

const company = usePage().props.company;

const videoEl = ref<HTMLVideoElement | null>(null);
const videoSources = ref<VideoSource[]>([]);
const videoReady = ref(false);
const videoFailed = ref(false);
const isPaused = ref(false);
let idleHandle: number | undefined;

/**
 * El poster es la imagen LCP; el video se solicita hasta que la página
 * terminó de cargar y se muestra con un fundido cuando empieza a reproducirse.
 * prefers-reduced-motion NO bloquea el video: solo quita transiciones y
 * animaciones decorativas (ver app.css). Únicamente Save-Data lo evita,
 * porque ahí el usuario pidió explícitamente ahorrar datos.
 */
function loadVideo(): void {
    const saveData =
        (navigator as Navigator & { connection?: { saveData?: boolean } })
            .connection?.saveData === true;

    if (saveData) {
        return;
    }

    videoSources.value = window.matchMedia('(min-width: 1024px)').matches
        ? desktopVideo
        : mobileVideo;
}

const supportsIdle =
    typeof window !== 'undefined' && 'requestIdleCallback' in window;

function scheduleVideo(): void {
    idleHandle = supportsIdle
        ? window.requestIdleCallback(loadVideo, { timeout: 2000 })
        : globalThis.setTimeout(loadVideo, 600);
}

/**
 * Refuerza el autoplay del atributo HTML: algunos navegadores/webviews no
 * lo disparan de forma fiable, así que se intenta explícitamente en cuanto
 * el video puede reproducirse. Si el navegador lo bloquea, el usuario
 * siempre puede darle al botón de reproducir.
 */
function handleCanPlay(): void {
    const el = videoEl.value;

    if (!el) {
        return;
    }

    el.muted = true;
    el.play().catch(() => undefined);
}

function handlePlaying(): void {
    videoReady.value = true;
    videoFailed.value = false;
    isPaused.value = false;
}

function handlePause(): void {
    isPaused.value = true;
}

function handleError(): void {
    videoFailed.value = true;
    videoReady.value = false;
}

async function toggleVideo(): Promise<void> {
    const el = videoEl.value;

    if (!el) {
        return;
    }

    if (el.paused) {
        try {
            el.muted = true;
            await el.play();
            isPaused.value = false;
        } catch {
            videoFailed.value = true;
        }
    } else {
        el.pause();
        isPaused.value = true;
    }
}

onMounted(() => {
    if (document.readyState === 'complete') {
        scheduleVideo();
    } else {
        window.addEventListener('load', scheduleVideo, { once: true });
    }
});

onBeforeUnmount(() => {
    window.removeEventListener('load', scheduleVideo);

    if (idleHandle === undefined) {
        return;
    }

    if (supportsIdle) {
        window.cancelIdleCallback(idleHandle);
    } else {
        globalThis.clearTimeout(idleHandle);
    }
});
</script>

<template>
    <section
        id="inicio"
        aria-labelledby="hero-title"
        class="on-dark relative isolate flex min-h-[max(34rem,88svh)] items-center overflow-hidden bg-ink-950 pt-(--header-height) lg:min-h-[min(100svh,58rem)]"
    >
        <img
            src="/images/home/hero-video-poster.webp"
            srcset="
                /images/home/hero-video-poster-960.webp  960w,
                /images/home/hero-video-poster.webp     1920w
            "
            sizes="100vw"
            alt=""
            width="1920"
            height="1080"
            fetchpriority="high"
            decoding="async"
            class="absolute inset-0 -z-20 size-full object-cover"
        />
        <video
            v-if="videoSources.length && !videoFailed"
            ref="videoEl"
            class="absolute inset-0 -z-20 size-full object-cover transition-opacity duration-700"
            :class="videoReady ? 'opacity-100' : 'opacity-0'"
            autoplay
            muted
            loop
            playsinline
            disablepictureinpicture
            preload="metadata"
            aria-hidden="true"
            tabindex="-1"
            @canplay="handleCanPlay"
            @playing="handlePlaying"
            @pause="handlePause"
            @error="handleError"
        >
            <source
                v-for="source in videoSources"
                :key="source.src"
                :src="source.src"
                :type="source.type"
            />
        </video>

        <button
            v-if="videoReady"
            type="button"
            class="absolute right-4 bottom-4 z-10 inline-flex size-10 items-center justify-center rounded-full border border-white/25 bg-ink-950/55 text-white backdrop-blur-sm transition-colors duration-150 hover:bg-ink-950/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold-500 sm:right-6 sm:bottom-6"
            :aria-label="
                isPaused ? 'Reproducir video de fondo' : 'Pausar video de fondo'
            "
            @click="toggleVideo"
        >
            <Play v-if="isPaused" class="size-4" aria-hidden="true" />
            <Pause v-else class="size-4" aria-hidden="true" />
        </button>

        <div
            class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950/80 via-ink-950/40 to-ink-950/20 lg:bg-gradient-to-r lg:from-ink-950/75 lg:via-ink-950/25 lg:to-transparent"
            aria-hidden="true"
        />
        <div
            class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-ink-950/65 to-transparent"
            aria-hidden="true"
        />

        <div class="container-spp py-14 sm:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-[1fr_auto]">
                <div class="max-w-2xl [text-shadow:0_1px_18px_rgb(0_0_0/0.45)]">
                    <p
                        class="hero-in inline-flex items-center gap-2 rounded-full border border-white/20 bg-ink-950/45 px-3.5 py-1.5 text-xs font-medium tracking-wide text-white/90 backdrop-blur-sm sm:text-sm"
                    >
                        <MapPin
                            class="size-4 text-gold-500"
                            aria-hidden="true"
                        />
                        Seguridad privada en Cuernavaca, Morelos
                    </p>

                    <h1
                        id="hero-title"
                        class="hero-in mt-5 text-[2.35rem] leading-[1.05] font-bold text-white [animation-delay:80ms] sm:text-5xl lg:text-6xl xl:text-[4.25rem]"
                    >
                        Servicios de
                        <span class="text-gold-500">Protección</span>
                        Profesional
                    </h1>

                    <p
                        class="hero-in mt-5 max-w-xl text-base leading-relaxed text-pretty text-white/90 [animation-delay:160ms] sm:text-lg"
                    >
                        Somos una empresa dedicada a la protección y vigilancia
                        de bienes muebles e inmuebles, con
                        <strong class="font-semibold text-gold-400"
                            >más de {{ company.yearsOfExperience }} años de
                            experiencia</strong
                        >. Nuestra ventaja competitiva es generar la confianza
                        en nuestros clientes a través de una excelente calidad
                        en nuestros servicios.
                    </p>

                    <div
                        class="hero-in mt-8 flex flex-col gap-3 [animation-delay:240ms] [text-shadow:none] sm:flex-row sm:flex-wrap sm:items-center"
                    >
                        <Button as-child size="lg" class="group/cta">
                            <SiteLink href="#cotizar">
                                Solicitar cotización
                                <ArrowRight
                                    class="transition-transform group-hover/cta:translate-x-0.5"
                                />
                            </SiteLink>
                        </Button>
                        <Button as-child size="lg" variant="light">
                            <SiteLink href="/#servicios">
                                Ver nuestros servicios
                            </SiteLink>
                        </Button>
                    </div>
                </div>

                <img
                    src="/images/marca/logo-grande.webp"
                    alt="Escudo de Servicios de Protección Profesional S.A. de C.V."
                    width="720"
                    height="643"
                    class="hero-in hidden w-64 drop-shadow-[0_20px_40px_rgba(0,0,0,0.55)] [animation-delay:200ms] lg:block xl:w-72"
                />
            </div>
        </div>

        <SiteLink
            href="/#empresa"
            class="group/hint absolute bottom-5 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-1 rounded-md px-2 py-1 text-xs tracking-[0.2em] text-white/75 uppercase transition-colors duration-150 hover:text-gold-400 sm:flex"
        >
            Saber más
            <ChevronDown
                class="size-5 motion-safe:animate-scroll-hint"
                aria-hidden="true"
            />
        </SiteLink>
    </section>
</template>

<style scoped>
.hero-in {
    animation: hero-in 0.8s var(--ease-out-soft) both;
}

@keyframes hero-in {
    from {
        opacity: 0;
        transform: translateY(0.75rem);
    }
}
</style>
