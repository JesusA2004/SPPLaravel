<script setup lang="ts">
import {
    BadgeCheck,
    Eye,
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
                            lead: 'Nuestro compromiso',
                            watermark: Target,
                            icon: '/images/iconos/mision.webp',
                            paragraphs: philosophy.mission,
                        },
                        {
                            id: 'vision',
                            title: 'Visión',
                            lead: 'Hacia dónde vamos',
                            watermark: Eye,
                            icon: '/images/iconos/vision.webp',
                            paragraphs: philosophy.vision,
                        },
                    ]"
                    :id="block.id"
                    :key="block.id"
                    v-reveal="index * 120"
                    class="group relative scroll-mt-6 overflow-hidden rounded-2xl border border-border bg-white p-7 shadow-sm transition-[transform,box-shadow,border-color] hover:-translate-y-1 hover:border-gold-500/60 hover:shadow-lg hover:shadow-navy-900/5 sm:p-9"
                >
                    <div
                        class="absolute inset-y-0 left-0 w-1 origin-top scale-y-0 bg-gradient-to-b from-gold-500 to-navy-700 transition-transform duration-500 group-hover:scale-y-100"
                        aria-hidden="true"
                    />
                    <component
                        :is="block.watermark"
                        class="pointer-events-none absolute -top-10 -right-10 size-44 text-navy-700/[0.035] transition-transform duration-500 group-hover:scale-105 group-hover:-rotate-6"
                        aria-hidden="true"
                    />
                    <div class="relative flex items-center gap-4">
                        <span
                            class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-navy-50 ring-1 ring-navy-100 transition-[background-color,box-shadow] group-hover:bg-gold-500/15 group-hover:ring-gold-500/40"
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
                        <div>
                            <h3 class="text-2xl font-semibold text-ink-950">
                                {{ block.title }}
                            </h3>
                            <p
                                class="text-xs font-semibold tracking-[0.18em] text-navy-700/70 uppercase"
                            >
                                {{ block.lead }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="relative mt-6 space-y-4 text-[0.97rem] leading-relaxed text-muted-foreground"
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
                class="on-dark relative mt-6 scroll-mt-6 overflow-hidden rounded-2xl bg-navy-900 p-7 text-white sm:p-9 lg:mt-8"
            >
                <div
                    class="pointer-events-none absolute -bottom-24 -left-16 size-72 rounded-full bg-gold-500/10 blur-3xl"
                    aria-hidden="true"
                />
                <div
                    class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:gap-12"
                >
                    <div class="flex items-center gap-4 lg:w-44 lg:shrink-0">
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
                            v-for="(value, index) in philosophy.values"
                            :key="value"
                            v-reveal="index * 60"
                            class="group/value flex flex-col items-center gap-2.5 rounded-xl border border-white/10 bg-white/5 px-2 py-4 text-center transition-[transform,background-color,border-color] hover:-translate-y-0.5 hover:border-gold-500/50 hover:bg-white/8"
                        >
                            <component
                                :is="valueIcons[value] ?? ShieldCheck"
                                class="size-6 text-gold-500 transition-transform group-hover/value:scale-110"
                                aria-hidden="true"
                            />
                            <span
                                class="text-[0.8rem] leading-tight font-medium sm:text-sm xl:text-[0.8rem]"
                            >
                                {{ value }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
