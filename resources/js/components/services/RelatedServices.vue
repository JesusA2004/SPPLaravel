<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ServiceCard from '@/components/services/ServiceCard.vue';

const props = defineProps<{
    currentSlug: string;
}>();

const services = usePage().props.services;
const related = computed(() =>
    services.filter((service) => service.slug !== props.currentSlug),
);
</script>

<template>
    <section
        aria-labelledby="otros-servicios"
        class="section-spacing bg-ink-950"
    >
        <div class="container-spp">
            <h2
                id="otros-servicios"
                v-reveal
                class="text-center text-3xl font-semibold text-white sm:text-4xl"
            >
                Otros servicios
            </h2>
            <ul class="mt-12 grid gap-6 md:grid-cols-3">
                <li
                    v-for="(service, index) in related"
                    :key="service.slug"
                    v-reveal="index * 100"
                >
                    <ServiceCard :service="service" />
                </li>
            </ul>
        </div>
    </section>
</template>
