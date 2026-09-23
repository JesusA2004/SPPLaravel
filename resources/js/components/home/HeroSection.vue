<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ArrowRight, ChevronDown, ShieldCheck } from '@lucide/vue';
import { onMounted, ref } from 'vue';
import SiteLink from '@/components/common/SiteLink.vue';
import { Button } from '@/components/ui/button';

const company = usePage().props.company;
const video = ref<HTMLVideoElement | null>(null);
const showVideo = ref(true);

onMounted(() => {
    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)',
    ).matches;
    const saveData =
        (navigator as Navigator & { connection?: { saveData?: boolean } })
            .connection?.saveData === true;

    if (reducedMotion || saveData) {
        showVideo.value = false;

        return;
    }

    video.value?.play().catch(() => {
        showVideo.value = false;
    });
});
</script>

<template>
    <section
        id="inicio"
        aria-labelledby="hero-title"
        class="relative isolate flex min-h-[100svh] items-center overflow-hidden bg-ink-950 pt-(--header-height)"
    >
        <img
            src="/images/home/hero-poster.webp"
            alt=""
            width="1600"
            height="900"
            fetchpriority="high"
            class="absolute inset-0 -z-20 size-full object-cover"
        />
        <video
            v-if="showVideo"
            ref="video"
            class="absolute inset-0 -z-20 size-full object-cover"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            poster="/images/home/hero-poster.webp"
            aria-hidden="true"
            tabindex="-1"
        >
            <source src="/video/spp-inicio.mp4" type="video/mp4" />
        </video>
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/95 via-ink-950/75 to-ink-950/35"
            aria-hidden="true"
        />
        <div
            class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-ink-950 to-transparent"
            aria-hidden="true"
        />

        <div class="container-spp py-16 sm:py-20">
            <div class="grid items-center gap-12 lg:grid-cols-[1fr_auto]">
                <div class="max-w-3xl">
                    <img
                        src="/images/marca/logo-grande.webp"
                        alt=""
                        width="720"
                        height="643"
                        class="hero-in mb-6 w-24 drop-shadow-[0_12px_24px_rgba(0,0,0,0.5)] sm:w-28 lg:hidden"
                    />
                    <p
                        class="hero-in inline-flex items-center gap-2 rounded-full border border-gold-500/40 bg-gold-500/10 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-gold-400 sm:text-sm"
                    >
                        <ShieldCheck class="size-4" aria-hidden="true" />
                        Más de {{ company.yearsOfExperience }} años de
                        experiencia en seguridad privada
                    </p>

                    <h1
                        id="hero-title"
                        class="hero-in mt-6 text-4xl leading-[1.08] font-bold text-white [animation-delay:80ms] sm:text-5xl lg:text-6xl xl:text-[4.25rem]"
                    >
                        Servicios de
                        <span class="text-gold-500">Protección</span>
                        Profesional
                    </h1>

                    <p
                        class="hero-in mt-6 max-w-2xl text-base leading-relaxed text-pretty text-white/80 [animation-delay:160ms] sm:text-lg"
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
                        class="hero-in mt-9 flex flex-col gap-3 [animation-delay:240ms] sm:flex-row sm:flex-wrap"
                    >
                        <Button as-child size="lg">
                            <SiteLink href="#cotizar">
                                Solicitar cotización
                                <ArrowRight />
                            </SiteLink>
                        </Button>
                        <Button as-child size="lg" variant="light">
                            <SiteLink href="/#empresa">Saber más</SiteLink>
                        </Button>
                        <Button
                            as-child
                            size="lg"
                            variant="link"
                            class="text-white hover:text-gold-400 sm:px-3"
                        >
                            <SiteLink href="/servicios">
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
                    class="hero-in hidden w-72 drop-shadow-[0_20px_40px_rgba(0,0,0,0.55)] [animation-delay:200ms] lg:block xl:w-80"
                />
            </div>
        </div>

        <SiteLink
            href="/#empresa"
            class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-1 rounded-md text-xs tracking-widest text-white/60 uppercase transition-colors hover:text-gold-400 sm:flex"
            aria-label="Ir a Filosofía Empresarial"
        >
            <span aria-hidden="true">Conócenos</span>
            <ChevronDown class="size-5 animate-bounce" aria-hidden="true" />
        </SiteLink>
    </section>
</template>

<style scoped>
.hero-in {
    animation: hero-in 0.8s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes hero-in {
    from {
        opacity: 0;
        transform: translateY(1rem);
    }
}
</style>
