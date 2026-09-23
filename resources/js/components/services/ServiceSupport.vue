<script setup lang="ts">
import { Check } from '@lucide/vue';
import type { Service } from '@/types';

defineProps<{
    support: Service['support'];
}>();
</script>

<template>
    <section
        aria-labelledby="servicio-soporte"
        class="section-spacing bg-muted"
    >
        <div class="container-spp">
            <div v-reveal class="flex flex-col items-center text-center">
                <span
                    class="flex size-16 items-center justify-center rounded-2xl bg-navy-900 shadow-lg shadow-navy-900/20"
                >
                    <img
                        src="/images/iconos/supervision.webp"
                        alt=""
                        loading="lazy"
                        class="size-10 object-contain"
                    />
                </span>
                <h2
                    id="servicio-soporte"
                    class="mt-6 text-3xl font-semibold text-ink-950 sm:text-4xl"
                >
                    {{ support.title }}
                </h2>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                <article
                    v-for="(card, index) in support.cards"
                    :key="card.title"
                    v-reveal="index * 100"
                    class="relative overflow-hidden rounded-2xl border border-border bg-white p-7 shadow-sm transition-[transform,box-shadow,border-color] hover:-translate-y-1 hover:border-gold-500/40 hover:shadow-lg hover:shadow-navy-900/5"
                >
                    <span
                        class="absolute inset-y-0 left-0 w-1 bg-gold-500"
                        aria-hidden="true"
                    />
                    <h3 class="text-lg font-semibold text-ink-950">
                        {{ card.title }}
                    </h3>
                    <p
                        v-if="card.text"
                        class="mt-3 leading-relaxed text-muted-foreground"
                    >
                        {{ card.text }}
                    </p>
                    <ul v-if="card.items.length" class="mt-4 space-y-3">
                        <li
                            v-for="item in card.items"
                            :key="item"
                            class="flex gap-3 leading-relaxed text-muted-foreground"
                        >
                            <Check
                                class="mt-1 size-4 shrink-0 text-navy-700"
                                aria-hidden="true"
                            />
                            {{ item }}
                        </li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
</template>
