<script setup lang="ts">
import SiteFooter from '@/components/layout/SiteFooter.vue';
import SiteHeader from '@/components/layout/SiteHeader.vue';
import WhatsAppButton from '@/components/layout/WhatsAppButton.vue';
</script>

<template>
    <a
        href="#contenido"
        class="sr-only z-[60] rounded-md bg-gold-500 px-4 py-2 font-semibold text-ink-950 focus:not-sr-only focus:fixed focus:top-3 focus:left-3"
    >
        Saltar al contenido
    </a>

    <SiteHeader />

    <main id="contenido" tabindex="-1" class="outline-none">
        <slot />
    </main>

    <SiteFooter />
    <WhatsAppButton />
</template>
