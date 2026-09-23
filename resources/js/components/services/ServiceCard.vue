<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from '@lucide/vue';
import type { ServiceSummary } from '@/types';

defineProps<{
    service: ServiceSummary;
}>();
</script>

<template>
    <article
        class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-white/10 bg-ink-900 text-white transition-all duration-300 hover:-translate-y-1 hover:border-gold-500/40 hover:shadow-2xl hover:shadow-black/40"
    >
        <div class="relative aspect-[16/10] overflow-hidden bg-ink-800">
            <img
                :src="service.cardImage.src"
                :alt="service.cardImage.alt"
                :width="service.cardImage.width"
                :height="service.cardImage.height"
                loading="lazy"
                class="size-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
            />
            <div
                class="absolute inset-0 bg-gradient-to-t from-ink-900 via-ink-900/10 to-transparent"
                aria-hidden="true"
            />
            <span
                class="absolute bottom-4 left-5 flex size-14 items-center justify-center rounded-xl border border-white/15 bg-ink-950/80 backdrop-blur-sm"
            >
                <img
                    :src="service.icon"
                    alt=""
                    loading="lazy"
                    class="size-9 object-contain"
                />
            </span>
        </div>

        <div class="flex flex-1 flex-col p-6 pt-5 sm:p-7 sm:pt-5">
            <h3 class="text-xl font-semibold sm:text-[1.35rem]">
                <Link
                    :href="service.url"
                    class="after:absolute after:inset-0 after:content-[''] focus-visible:outline-none"
                >
                    {{ service.name }}
                </Link>
            </h3>
            <p class="mt-3 flex-1 leading-relaxed text-white/70">
                {{ service.summary }}
            </p>
            <span
                class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-gold-500"
                aria-hidden="true"
            >
                Ver más
                <ArrowUpRight
                    class="size-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                />
            </span>
        </div>

        <span
            class="pointer-events-none absolute inset-0 rounded-2xl ring-gold-500 group-has-[a:focus-visible]:ring-2"
            aria-hidden="true"
        />
    </article>
</template>
