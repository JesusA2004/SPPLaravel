<script setup lang="ts">
import { ChevronLeft, ChevronRight, Pause, Play } from '@lucide/vue';
import AutoScroll from 'embla-carousel-auto-scroll';
import { onMounted, ref } from 'vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import { Button } from '@/components/ui/button';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
} from '@/components/ui/carousel';
import type { UnwrapRefCarouselApi } from '@/components/ui/carousel/interface';
import type { Client } from '@/types';

defineProps<{
    intro: string;
    clients: Client[];
}>();

const autoScroll = AutoScroll({
    speed: 0.6,
    startDelay: 1200,
    playOnInit: false,
    stopOnInteraction: false,
    stopOnMouseEnter: true,
    stopOnFocusIn: true,
});

const api = ref<UnwrapRefCarouselApi>();
const paused = ref(false);

function step(direction: 1 | -1): void {
    if (direction === 1) {
        api.value?.scrollNext();
    } else {
        api.value?.scrollPrev();
    }

    if (!paused.value) {
        autoScroll.play(1500);
    }
}

function togglePause(): void {
    paused.value = !paused.value;

    if (paused.value) {
        autoScroll.stop();
    } else {
        autoScroll.play();
    }
}

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        paused.value = true;

        return;
    }

    autoScroll.play();
});
</script>

<template>
    <section
        id="clientes"
        aria-labelledby="clientes-title"
        class="section-spacing overflow-hidden bg-white"
    >
        <div class="container-spp">
            <SectionHeading
                id="clientes-title"
                eyebrow="Confianza comprobada"
                title="Clientes Distinguidos"
                :description="intro"
            />
        </div>

        <div v-reveal class="relative mt-14">
            <div
                class="pointer-events-none absolute inset-y-0 left-0 z-10 w-10 bg-gradient-to-r from-white to-transparent sm:w-32"
                aria-hidden="true"
            />
            <div
                class="pointer-events-none absolute inset-y-0 right-0 z-10 w-10 bg-gradient-to-l from-white to-transparent sm:w-32"
                aria-hidden="true"
            />

            <Carousel
                :opts="{ loop: true, align: 'start', dragFree: true }"
                :plugins="[autoScroll]"
                aria-label="Logotipos de clientes distinguidos"
                class="focus-visible:outline-offset-4"
                @init-api="(carouselApi) => (api = carouselApi)"
            >
                <CarouselContent class="ml-0">
                    <CarouselItem
                        v-for="(client, index) in clients"
                        :key="client.name"
                        :aria-label="`${index + 1} de ${clients.length}: ${client.name}`"
                        class="basis-[62%] pr-4 pl-0 sm:basis-[38%] sm:pr-6 md:basis-[30%] lg:basis-[22%] xl:basis-[19%]"
                    >
                        <figure
                            class="group/logo flex h-32 items-center justify-center rounded-2xl border border-border bg-white p-6 transition-[border-color,box-shadow,transform] hover:-translate-y-0.5 hover:border-gold-500/60 hover:shadow-lg hover:shadow-navy-900/5 sm:h-40 sm:p-7"
                        >
                            <img
                                :src="client.logo"
                                :alt="client.name"
                                :width="client.width"
                                :height="client.height"
                                loading="lazy"
                                decoding="async"
                                draggable="false"
                                class="max-h-full w-auto max-w-full object-contain transition-transform duration-500 select-none group-hover/logo:scale-105"
                            />
                        </figure>
                    </CarouselItem>
                </CarouselContent>
            </Carousel>
        </div>

        <div class="container-spp mt-8 flex items-center justify-center gap-3">
            <Button
                variant="outline"
                size="icon"
                class="rounded-full hover:border-navy-900 hover:bg-navy-900 hover:text-white"
                aria-label="Ver clientes anteriores"
                @click="step(-1)"
            >
                <ChevronLeft />
            </Button>
            <Button
                variant="outline"
                size="icon"
                class="rounded-full"
                :aria-label="
                    paused
                        ? 'Reanudar desplazamiento automático'
                        : 'Pausar desplazamiento automático'
                "
                @click="togglePause"
            >
                <Play v-if="paused" />
                <Pause v-else />
            </Button>
            <Button
                variant="outline"
                size="icon"
                class="rounded-full hover:border-navy-900 hover:bg-navy-900 hover:text-white"
                aria-label="Ver más clientes"
                @click="step(1)"
            >
                <ChevronRight />
            </Button>
        </div>
    </section>
</template>
