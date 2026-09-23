<script setup lang="ts">
import PageHeader from '@/components/common/PageHeader.vue';
import SeoHead from '@/components/common/SeoHead.vue';
import QuoteSection from '@/components/contact/QuoteSection.vue';
import ServiceCta from '@/components/services/ServiceCta.vue';
import ServicesSection from '@/components/services/ServicesSection.vue';
import type { Seo } from '@/types';

defineProps<{
    seo: Seo;
}>();
</script>

<template>
    <SeoHead :seo="seo" />
    <PageHeader
        title="Servicios de seguridad privada"
        description="Protección profesional para dependencias de gobierno, plazas comerciales, residenciales, industrias y empresas de servicios en Cuernavaca, Morelos."
        :breadcrumbs="[{ label: 'Servicios', url: '/servicios' }]"
        image="/images/home/hero-poster.webp"
    />
    <ServicesSection />
    <ServiceCta />
    <QuoteSection />
</template>
