<script setup lang="ts">
import { CircleCheck, MapPin } from '@lucide/vue';
import type { Service } from '@/types';

defineProps<{
    service: Service;
}>();
</script>

<template>
    <section
        aria-labelledby="servicio-detalle"
        class="bg-white pb-20 sm:pb-24 lg:pb-28"
    >
        <div class="container-spp">
            <div
                class="grid gap-10 border-t border-border pt-16 lg:grid-cols-[1.25fr_1fr] lg:gap-16 lg:pt-20"
            >
                <div v-reveal>
                    <h2
                        id="servicio-detalle"
                        class="text-2xl font-semibold text-ink-950 sm:text-3xl"
                    >
                        Cómo trabajamos
                    </h2>
                    <div
                        class="mt-5 space-y-4 text-lg leading-relaxed text-muted-foreground"
                    >
                        <p
                            v-for="paragraph in service.overview"
                            :key="paragraph"
                        >
                            {{ paragraph }}
                        </p>
                    </div>
                    <p
                        class="mt-6 inline-flex items-start gap-2.5 rounded-lg bg-navy-50 px-4 py-3 text-sm font-medium text-navy-800"
                    >
                        <MapPin
                            class="mt-0.5 size-4 shrink-0 text-navy-700"
                            aria-hidden="true"
                        />
                        Cobertura: {{ service.coverage }}.
                    </p>
                </div>

                <div
                    v-reveal="120"
                    class="self-start rounded-2xl border border-border bg-muted/60 p-7 sm:p-8"
                >
                    <h3 class="text-lg font-semibold text-ink-950">
                        ¿Para quién es este servicio?
                    </h3>
                    <ul class="mt-5 space-y-3">
                        <li
                            v-for="item in service.audience"
                            :key="item"
                            class="flex items-start gap-3 text-ink-900"
                        >
                            <CircleCheck
                                class="mt-0.5 size-5 shrink-0 text-gold-600"
                                aria-hidden="true"
                            />
                            {{ item }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
