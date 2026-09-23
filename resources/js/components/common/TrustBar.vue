<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { BadgeCheck, Clock, Handshake, ShieldCheck } from '@lucide/vue';

withDefaults(
    defineProps<{
        tone?: 'dark' | 'light';
    }>(),
    { tone: 'dark' },
);

const company = usePage().props.company;

const items = [
    {
        icon: ShieldCheck,
        title: `Más de ${company.yearsOfExperience} años`,
        text: 'de experiencia en seguridad privada',
    },
    {
        icon: BadgeCheck,
        title: 'Autorización No. 082',
        text: 'Dirección General de Seguridad Privada de Morelos',
    },
    {
        icon: Clock,
        title: 'Supervisión 24 horas',
        text: 'presencial y a distancia desde la central operativa',
    },
    {
        icon: Handshake,
        title: 'Coordinación con autoridades',
        text: 'de seguridad municipales y estatales',
    },
];
</script>

<template>
    <section
        aria-label="Por qué confiar en SPP"
        :class="
            tone === 'dark'
                ? 'on-dark border-y border-white/8 bg-ink-950 text-white'
                : 'border-y border-border bg-white'
        "
    >
        <ul
            class="container-spp grid grid-cols-1 gap-x-8 gap-y-6 py-8 sm:grid-cols-2 lg:grid-cols-4 lg:py-10"
        >
            <li
                v-for="(item, index) in items"
                :key="item.title"
                v-reveal="index * 80"
                class="flex items-start gap-4"
            >
                <span
                    class="flex size-11 shrink-0 items-center justify-center rounded-lg"
                    :class="
                        tone === 'dark'
                            ? 'bg-gold-500/10 text-gold-500 ring-1 ring-gold-500/25'
                            : 'bg-navy-50 text-navy-700 ring-1 ring-navy-100'
                    "
                >
                    <component
                        :is="item.icon"
                        class="size-5"
                        aria-hidden="true"
                    />
                </span>
                <p class="leading-snug">
                    <span class="block font-display font-semibold">
                        {{ item.title }}
                    </span>
                    <span
                        class="text-sm"
                        :class="
                            tone === 'dark'
                                ? 'text-white/65'
                                : 'text-muted-foreground'
                        "
                    >
                        {{ item.text }}
                    </span>
                </p>
            </li>
        </ul>
    </section>
</template>
