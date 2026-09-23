<script setup lang="ts">
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: string;
}>();
</script>

<template>
    <span :class="cn('flex items-center gap-3', props.class)">
        <img
            src="/images/marca/logo.webp"
            alt=""
            width="347"
            height="360"
            class="h-11 w-auto shrink-0 drop-shadow-[0_2px_6px_rgba(0,0,0,0.35)] transition-transform duration-300 group-hover:scale-105 group-hover:-rotate-2 sm:h-12"
        />
        <span
            class="flex flex-col font-display text-[0.8rem] leading-tight font-semibold tracking-wide sm:text-sm"
        >
            <span class="text-white">Servicios de Protección</span>
            <span class="text-gold-500">Profesional</span>
        </span>
    </span>
</template>
