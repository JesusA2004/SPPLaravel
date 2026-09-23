<script setup lang="ts">
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        eyebrow?: string;
        title: string;
        description?: string;
        align?: 'left' | 'center';
        tone?: 'light' | 'dark';
        as?: 'h1' | 'h2';
        id?: string;
        class?: string;
    }>(),
    { align: 'center', tone: 'light', as: 'h2' },
);
</script>

<template>
    <div
        v-reveal
        :class="
            cn(
                'max-w-3xl',
                align === 'center' ? 'mx-auto text-center' : 'text-left',
                props.class,
            )
        "
    >
        <p
            v-if="eyebrow"
            class="mb-3 inline-flex items-center gap-2 text-xs font-semibold tracking-[0.2em] uppercase"
            :class="tone === 'dark' ? 'text-gold-500' : 'text-navy-700'"
        >
            <span class="h-px w-6 bg-gold-500" aria-hidden="true" />
            {{ eyebrow }}
        </p>
        <component
            :is="as"
            :id="id"
            class="text-3xl leading-tight font-semibold sm:text-4xl lg:text-[2.75rem]"
            :class="tone === 'dark' ? 'text-white' : 'text-ink-950'"
        >
            {{ title }}
        </component>
        <p
            v-if="description"
            class="mt-5 text-base leading-relaxed text-pretty sm:text-lg"
            :class="tone === 'dark' ? 'text-white/70' : 'text-muted-foreground'"
        >
            {{ description }}
        </p>
        <slot />
    </div>
</template>
