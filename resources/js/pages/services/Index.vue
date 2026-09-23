<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import PageHeader from '@/components/common/PageHeader.vue';
import SeoHead from '@/components/common/SeoHead.vue';
import TrustBar from '@/components/common/TrustBar.vue';
import QuoteCta from '@/components/contact/QuoteCta.vue';
import ServicesSection from '@/components/services/ServicesSection.vue';
import type { Seo } from '@/types';

defineProps<{
    seo: Seo;
}>();

const company = usePage().props.company;
</script>

<template>
    <SeoHead :seo="seo" />
    <PageHeader
        title="Servicios de seguridad privada en Cuernavaca, Morelos"
        :breadcrumbs="[{ label: 'Servicios', url: '/servicios' }]"
        image="/images/home/hero-poster.webp"
    >
        <div
            class="mt-5 max-w-3xl space-y-4 text-base leading-relaxed text-pretty text-white/80 sm:text-lg"
        >
            <p>
                En {{ company.name }} (SPP) protegemos personas, instalaciones y
                bienes con más de {{ company.yearsOfExperience }} años de
                experiencia. Atendemos a dependencias de gobierno, plazas
                comerciales, residenciales, industrias y empresas de servicios
                en Cuernavaca y el estado de Morelos.
            </p>
            <p>
                Combinamos vigilancia con personal capacitado, protección
                ejecutiva y tecnología de seguridad, con supervisión operativa
                las 24 horas.
            </p>
        </div>
    </PageHeader>
    <TrustBar tone="light" />
    <ServicesSection />
    <QuoteCta />
</template>
