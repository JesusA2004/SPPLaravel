<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core';
import { onBeforeUnmount, ref, useTemplateRef } from 'vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import ContactLinks from '@/components/contact/ContactLinks.vue';
import QuoteForm from '@/components/contact/QuoteForm.vue';
import QuoteResultDialog from '@/components/contact/QuoteResultDialog.vue';
import type { QuoteFields } from '@/types';

const images = [
    {
        src: '/images/home/cotizar-1.webp',
        alt: 'Guardia de seguridad de SPP comunicándose por radio',
    },
    {
        src: '/images/home/cotizar-2.webp',
        alt: 'Oficinas de Servicios de Protección Profesional',
    },
    {
        src: '/images/home/cotizar-3.webp',
        alt: 'Instalaciones y vehículos de Servicios de Protección Profesional',
    },
];

const submitted = ref<QuoteFields | null>(null);

const current = ref(0);
const loaded = ref<number[]>([0]);
const gallery = useTemplateRef<HTMLElement>('gallery');
let timer: ReturnType<typeof setInterval> | undefined;

/**
 * Descarga y decodifica la siguiente imagen antes de mostrarla para que el
 * fundido no produzca destellos; solo se carga la imagen que se va a usar.
 */
async function showNext(): Promise<void> {
    const next = (current.value + 1) % images.length;

    if (!loaded.value.includes(next)) {
        const image = new Image();
        image.src = images[next].src;

        try {
            await image.decode();
        } catch {
            return;
        }

        loaded.value.push(next);
    }

    current.value = next;
}

function stop(): void {
    clearInterval(timer);
    timer = undefined;
}

const reducedMotion =
    typeof window !== 'undefined' &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

useIntersectionObserver(gallery, ([entry]) => {
    if (reducedMotion) {
        return;
    }

    if (entry?.isIntersecting && timer === undefined) {
        timer = setInterval(() => void showNext(), 5000);
    } else if (!entry?.isIntersecting) {
        stop();
    }
});

onBeforeUnmount(stop);
</script>

<template>
    <section
        id="cotizar"
        aria-labelledby="cotizar-title"
        class="section-spacing bg-muted"
    >
        <div class="container-spp">
            <div
                class="grid overflow-hidden rounded-3xl border border-border bg-white shadow-xl shadow-navy-900/5 lg:grid-cols-[0.9fr_1.1fr]"
            >
                <div
                    ref="gallery"
                    class="on-dark relative isolate flex min-h-96 flex-col justify-end overflow-hidden bg-ink-950 p-7 text-white sm:p-10"
                >
                    <template v-for="(image, index) in images" :key="image.src">
                        <img
                            v-if="loaded.includes(index)"
                            :src="image.src"
                            :alt="index === current ? image.alt : ''"
                            :aria-hidden="index !== current"
                            loading="lazy"
                            decoding="async"
                            class="absolute inset-0 -z-20 size-full object-cover transition-opacity duration-1000"
                            :class="
                                index === current ? 'opacity-100' : 'opacity-0'
                            "
                        />
                    </template>
                    <div
                        class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/65 to-ink-950/10"
                        aria-hidden="true"
                    />

                    <p
                        class="max-w-md font-display text-lg leading-snug font-medium text-pretty sm:text-xl"
                    >
                        ¿Prefieres hablar con nosotros? Te atendemos por
                        teléfono, WhatsApp o correo.
                    </p>

                    <ContactLinks class="mt-7" />
                </div>

                <div class="p-6 sm:p-10 lg:p-12">
                    <SectionHeading
                        id="cotizar-title"
                        align="left"
                        eyebrow="Cotiza sin compromiso"
                        title="Solicita tu cotización"
                        description="Contáctanos completando nuestro formulario y descubre por qué nuestros clientes confían en Servicios de Protección Profesional."
                        class="mb-8 [&_h2]:text-3xl [&_h2]:sm:text-4xl"
                    />
                    <QuoteForm
                        labelled-by="cotizar-title"
                        @success="(data) => (submitted = data)"
                    />
                </div>
            </div>
        </div>

        <QuoteResultDialog :submitted="submitted" @close="submitted = null" />
    </section>
</template>
