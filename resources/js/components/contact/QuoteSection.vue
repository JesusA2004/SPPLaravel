<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Mail, Phone } from '@lucide/vue';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import QuoteForm from '@/components/contact/QuoteForm.vue';

defineProps<{
    prefill?: string | null;
}>();

const company = usePage().props.company;

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

const current = ref(0);
let timer: ReturnType<typeof setInterval> | undefined;

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    timer = setInterval(() => {
        current.value = (current.value + 1) % images.length;
    }, 5000);
});

onBeforeUnmount(() => clearInterval(timer));
</script>

<template>
    <section
        id="cotizar"
        aria-labelledby="cotizar-title"
        class="section-spacing scroll-mt-16 bg-muted"
    >
        <div class="container-spp">
            <div
                class="grid overflow-hidden rounded-3xl border border-border bg-white shadow-xl shadow-navy-900/5 lg:grid-cols-[0.9fr_1.1fr]"
            >
                <div
                    class="relative isolate flex min-h-80 flex-col justify-end overflow-hidden bg-ink-950 p-7 text-white sm:p-10"
                >
                    <img
                        v-for="(image, index) in images"
                        :key="image.src"
                        :src="image.src"
                        :alt="index === current ? image.alt : ''"
                        loading="lazy"
                        class="absolute inset-0 -z-20 size-full object-cover transition-opacity duration-1000"
                        :class="index === current ? 'opacity-100' : 'opacity-0'"
                        :aria-hidden="index !== current"
                    />
                    <div
                        class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950 via-ink-950/70 to-ink-950/20"
                        aria-hidden="true"
                    />

                    <p
                        class="max-w-md font-display text-lg leading-snug font-medium text-pretty sm:text-xl"
                    >
                        Descubre por qué nuestros clientes confían en
                        <span class="text-gold-500">{{ company.name }}</span
                        >.
                    </p>

                    <ul class="mt-8 space-y-3 text-sm">
                        <li>
                            <a
                                :href="company.contact.phone.href"
                                class="inline-flex items-center gap-3 rounded-md transition-colors hover:text-gold-400"
                            >
                                <span
                                    class="flex size-9 items-center justify-center rounded-full bg-white/10"
                                >
                                    <Phone class="size-4" aria-hidden="true" />
                                </span>
                                {{ company.contact.phone.label }}
                            </a>
                        </li>
                        <li>
                            <a
                                :href="company.contact.whatsapp.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-3 rounded-md transition-colors hover:text-gold-400"
                            >
                                <span
                                    class="flex size-9 items-center justify-center rounded-full bg-white/10"
                                >
                                    <BrandIcon
                                        network="whatsapp"
                                        class="size-4"
                                    />
                                </span>
                                WhatsApp {{ company.contact.whatsapp.label }}
                            </a>
                        </li>
                        <li>
                            <a
                                :href="`mailto:${company.contact.email}`"
                                class="inline-flex items-center gap-3 rounded-md break-all transition-colors hover:text-gold-400"
                            >
                                <span
                                    class="flex size-9 shrink-0 items-center justify-center rounded-full bg-white/10"
                                >
                                    <Mail class="size-4" aria-hidden="true" />
                                </span>
                                {{ company.contact.email }}
                            </a>
                        </li>
                    </ul>
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
                    <QuoteForm :key="prefill ?? ''" :prefill="prefill" />
                </div>
            </div>
        </div>
    </section>
</template>
