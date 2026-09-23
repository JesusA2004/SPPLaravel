<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import SectionHeading from '@/components/common/SectionHeading.vue';
import ServiceCard from '@/components/services/ServiceCard.vue';

const services = usePage().props.services;
</script>

<template>
    <section
        id="servicios"
        aria-labelledby="servicios-title"
        class="section-spacing relative overflow-hidden bg-ink-950"
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
        </div>
    </section>
</template>
