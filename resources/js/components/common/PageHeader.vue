<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronRight, House } from '@lucide/vue';
import type { LinkItem } from '@/types';

defineProps<{
    title: string;
    description?: string;
    breadcrumbs: LinkItem[];
    image?: string;
}>();
</script>

<template>
    <section
        class="on-dark relative isolate overflow-hidden bg-ink-950 pt-(--header-height) text-white"
    >
        <img
            v-if="image"
            :src="image"
            alt=""
            class="absolute inset-0 -z-20 size-full object-cover opacity-30"
        />
        <div
            class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950 via-ink-950/90 to-navy-900/70"
            aria-hidden="true"
        />
        <div class="container-spp py-14 sm:py-20">
            <nav aria-label="Ruta de navegación">
                <ol
                    class="flex flex-wrap items-center gap-1.5 text-sm text-white/60"
                >
                    <li>
                        <Link
                            href="/"
                            class="flex items-center gap-1.5 rounded-sm transition-colors hover:text-gold-400"
                        >
                            <House class="size-4" aria-hidden="true" />
                            Inicio
                        </Link>
                    </li>
                    <li
                        v-for="(crumb, index) in breadcrumbs"
                        :key="crumb.url"
                        class="flex items-center gap-1.5"
                    >
                        <ChevronRight
                            class="size-3.5 text-white/40"
                            aria-hidden="true"
                        />
                        <span
                            v-if="index === breadcrumbs.length - 1"
                            aria-current="page"
                            class="text-white"
                        >
                            {{ crumb.label }}
                        </span>
                        <Link
                            v-else
                            :href="crumb.url"
                            class="rounded-sm transition-colors hover:text-gold-400"
                        >
                            {{ crumb.label }}
                        </Link>
                    </li>
                </ol>
            </nav>

            <h1
                class="mt-6 max-w-4xl text-3xl leading-tight font-bold text-balance sm:text-4xl lg:text-5xl"
            >
                {{ title }}
            </h1>
            <p
                v-if="description"
                class="mt-5 max-w-2xl text-base leading-relaxed text-pretty text-white/75 sm:text-lg"
            >
                {{ description }}
            </p>
            <slot />
        </div>
    </section>
</template>
