<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import BrandIcon from '@/components/common/BrandIcon.vue';

const company = usePage().props.company;
</script>

<template>
    <a
        :href="company.contact.whatsapp.url"
        target="_blank"
        rel="noopener noreferrer"
        class="group fixed right-4 bottom-4 z-30 flex items-center gap-2 rounded-full bg-[#25D366] p-3.5 text-white shadow-lg ring-4 shadow-black/25 ring-white/70 transition-all duration-300 hover:bg-[#1ebe5b] hover:shadow-xl focus-visible:ring-gold-500 sm:right-6 sm:bottom-6"
        aria-label="Escríbenos por WhatsApp (se abre en una nueva pestaña)"
    >
        <BrandIcon network="whatsapp" class="size-7" />
        <span
            class="hidden max-w-0 overflow-hidden text-sm font-semibold whitespace-nowrap transition-[max-width] duration-300 group-hover:max-w-40 group-focus-visible:max-w-40 sm:inline"
            aria-hidden="true"
        >
            Escríbenos
        </span>
    </a>
</template>
