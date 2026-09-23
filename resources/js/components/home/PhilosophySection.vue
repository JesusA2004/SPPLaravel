<script setup lang="ts">
import {
    BadgeCheck,
    ClipboardCheck,
    Handshake,
    HeartHandshake,
    Scale,
    ShieldCheck,
    Target,
    Users,
} from '@lucide/vue';
import type { Component } from 'vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import type { Philosophy } from '@/types';

defineProps<{
    philosophy: Philosophy;
}>();

const valueIcons: Record<string, Component> = {
    Disciplina: Target,
    Respeto: Handshake,
    Profesionalismo: BadgeCheck,
    Responsabilidad: ClipboardCheck,
    'Vocación de servicio': HeartHandshake,
    Honestidad: Scale,
    'Trabajo en equipo': Users,
};
</script>

<template>
    <section
        id="empresa"
        aria-labelledby="empresa-title"
        class="section-spacing relative overflow-hidden bg-muted"
    >
        <div
            class="pointer-events-none absolute -top-40 -right-40 size-[28rem] rounded-full bg-navy-100/60 blur-3xl"
            aria-hidden="true"
        />

        <div class="container-spp relative">
            <SectionHeading
                id="empresa-title"
                eyebrow="Quiénes somos"
                title="Filosofía Empresarial"
                :description="philosophy.intro"
            />

            <div class="mt-14 grid gap-6 lg:grid-cols-2 lg:gap-8">
                <article
                    v-for="(block, index) in [
                        {
                            id: 'mision',
                            title: 'Misión',
                            icon: '/images/iconos/mision.webp',
                            paragraphs: philosophy.mission,
                        },
                        {
                            id: 'vision',
                            title: 'Visión',
                            icon: '/images/iconos/vision.webp',
                            paragraphs: philosophy.vision,
                        },
                    ]"
                    :id="block.id"
                    :key="block.id"
                    v-reveal="index * 120"
                    class="group relative scroll-mt-28 rounded-2xl border border-border bg-white p-7 shadow-sm transition-shadow duration-300 hover:shadow-md sm:p-9"
                >
                    <div
                        class="absolute inset-x-0 top-0 h-1 rounded-t-2xl bg-gradient-to-r from-navy-700 to-gold-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        aria-hidden="true"
                    />
                    <div class="flex items-center gap-4">
                        <span
                            class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-navy-50 ring-1 ring-navy-100"
                        >
                            <img
                                :src="block.icon"
                                alt=""
                                width="100"
                                height="100"
                                loading="lazy"
                                class="size-8"
                            />
                        </span>
                        <h3 class="text-2xl font-semibold text-ink-950">
                            {{ block.title }}
                        </h3>
                    </div>
                    <div
                        class="mt-6 space-y-4 text-[0.97rem] leading-relaxed text-muted-foreground"
                    >
                        <p
                            v-for="paragraph in block.paragraphs"
                            :key="paragraph"
                        >
                            {{ paragraph }}
                        </p>
                    </div>
                </article>
            </div>

            <div
                id="valores"
                v-reveal
                class="relative mt-6 scroll-mt-28 overflow-hidden rounded-2xl bg-navy-900 p-7 text-white sm:p-9 lg:mt-8"
            >
                <div
                    class="pointer-events-none absolute -bottom-24 -left-16 size-72 rounded-full bg-gold-500/10 blur-3xl"
                    aria-hidden="true"
                />
                <div
                    class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:gap-12"
                >
                    <div class="flex items-center gap-4 lg:w-56 lg:shrink-0">
                        <span
                            class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-white ring-1 ring-white/10"
                        >
                            <img
                                src="/images/iconos/valores.webp"
                                alt=""
                                width="100"
                                height="100"
                                loading="lazy"
                                class="size-8"
                            />
                        </span>
                        <div>
                            <h3 class="text-2xl font-semibold">Valores</h3>
                            <p class="text-sm text-white/60">
                                Lo que nos define
                            </p>
                        </div>
                    </div>

                    <ul
                        class="grid flex-1 grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7"
                    >
                        <li
                            v-for="value in philosophy.values"
                            :key="value"
                            class="flex flex-col items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-3 py-4 text-center transition-colors duration-300 hover:border-gold-500/50 hover:bg-white/8"
                        >
                            <component
                                :is="valueIcons[value] ?? ShieldCheck"
                                class="size-6 text-gold-500"
                                aria-hidden="true"
                            />
                            <span class="text-sm leading-tight font-medium">
                                {{ value }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
