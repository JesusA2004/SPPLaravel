<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import type { ServiceSummary } from '@/types';

defineProps<{
    service: ServiceSummary;
}>();
</script>

<template>
    <article
        class="group on-dark relative flex h-full flex-col overflow-hidden rounded-2xl border border-white/10 bg-ink-900 text-white transition-[transform,border-color,box-shadow] hover:-translate-y-1 hover:border-gold-500/50 hover:shadow-xl hover:shadow-black/40 has-[a:focus-visible]:border-gold-500"
    >
        <div class="sheen relative aspect-[16/10] overflow-hidden bg-ink-800">
            <img
                :src="service.cardImage.src"
                :alt="service.cardImage.alt"
                :width="service.cardImage.width"
                :height="service.cardImage.height"
                loading="lazy"
                decoding="async"
                class="size-full object-cover transition-transform duration-700 ease-(--ease-out-soft) group-hover:scale-[1.04]"
            />
            <div
                class="absolute inset-0 bg-gradient-to-t from-ink-900 via-ink-900/15 to-transparent"
                aria-hidden="true"
            />
            <span
                class="absolute bottom-4 left-5 flex size-14 items-center justify-center rounded-xl border border-white/15 bg-ink-950/80 backdrop-blur-sm transition-colors group-hover:border-gold-500/50"
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
            <h3
                class="text-xl font-semibold transition-colors group-hover:text-gold-400 sm:text-[1.35rem]"
            >
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
                <ArrowRight
                    class="size-4 transition-transform group-hover:translate-x-1"
                />
            </span>
        </div>
    </article>
</template>
