<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import ServiceCard from '@/components/services/ServiceCard.vue';

defineProps<{
    linkToAll?: boolean;
}>();

const services = usePage().props.services;
</script>

<template>
    <section
        id="servicios"
        aria-labelledby="servicios-title"
        class="section-spacing on-dark relative overflow-hidden bg-ink-950"
    >
        <div
            class="pointer-events-none absolute top-0 left-1/2 h-px w-3/4 -translate-x-1/2 bg-gradient-to-r from-transparent via-gold-500/40 to-transparent"
            aria-hidden="true"
        />
        <div class="container-spp">
            <SectionHeading
                id="servicios-title"
                tone="dark"
                eyebrow="Seguridad privada"
                title="Nuestros Servicios"
                description="Nuestra organización proporciona servicios de seguridad privada a dependencias de gobierno, plazas comerciales, residenciales y organizaciones privadas, tanto industrias como prestadoras de servicios, en los siguientes rubros:"
            />

            <ul class="mt-14 grid gap-6 md:grid-cols-2 lg:gap-8">
                <li
                    v-for="(service, index) in services"
                    :key="service.slug"
                    v-reveal="(index % 2) * 120"
                >
                    <ServiceCard :service="service" />
                </li>
            </ul>

            <div v-if="linkToAll" class="mt-12 text-center">
                <Link
                    href="/servicios"
                    class="group inline-flex items-center gap-2 rounded-md text-sm font-semibold text-gold-400 transition-colors duration-150 hover:text-gold-300"
                >
                    Conoce todos nuestros servicios de seguridad privada
                    <ArrowRight
                        class="size-4 transition-transform group-hover:translate-x-1"
                        aria-hidden="true"
                    />
                </Link>
            </div>
        </div>
    </section>
</template>
