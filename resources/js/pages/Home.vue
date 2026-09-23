<script setup lang="ts">
import SeoHead from '@/components/common/SeoHead.vue';
import QuoteSection from '@/components/contact/QuoteSection.vue';
import ClientsSection from '@/components/home/ClientsSection.vue';
import HeroSection from '@/components/home/HeroSection.vue';
import PhilosophySection from '@/components/home/PhilosophySection.vue';
import ServicesSection from '@/components/services/ServicesSection.vue';
import type { Client, Philosophy, Seo } from '@/types';

defineProps<{
    seo: Seo;
    philosophy: Philosophy;
    clientsIntro: string;
    clients: Client[];
    quotePrefill: string | null;
}>();
</script>

<template>
    <SeoHead :seo="seo" />
    <HeroSection />
    <PhilosophySection :philosophy="philosophy" />
    <ClientsSection :intro="clientsIntro" :clients="clients" />
    <ServicesSection />
    <QuoteSection :prefill="quotePrefill" />
</template>
