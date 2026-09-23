<script setup lang="ts">
import { Pause, Play } from '@lucide/vue';
import Autoplay from 'embla-carousel-autoplay';
import { onMounted, ref } from 'vue';
import SectionHeading from '@/components/common/SectionHeading.vue';
import { Button } from '@/components/ui/button';
import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselNext,
    CarouselPrevious,
} from '@/components/ui/carousel';
import type { UnwrapRefCarouselApi } from '@/components/ui/carousel/interface';
import type { Client } from '@/types';

defineProps<{
    intro: string;
    clients: Client[];
}>();

const autoplay = Autoplay({
    delay: 3200,
    playOnInit: false,
    stopOnInteraction: false,
    stopOnMouseEnter: true,
    stopOnFocusIn: true,
});

const api = ref<UnwrapRefCarouselApi>();
const snaps = ref<number[]>([]);
const selected = ref(0);
const playing = ref(false);

function onInit(carouselApi: UnwrapRefCarouselApi): void {
    api.value = carouselApi;

    if (!carouselApi) {
        return;
    }

    const sync = () => {
        snaps.value = carouselApi.scrollSnapList();
        selected.value = carouselApi.selectedScrollSnap();
    };

    sync();
    carouselApi.on('select', sync);
    carouselApi.on('reInit', sync);
    carouselApi.on('autoplay:play', () => (playing.value = true));
    carouselApi.on('autoplay:stop', () => (playing.value = false));
}

function toggleAutoplay(): void {
    if (autoplay.isPlaying()) {
        autoplay.stop();
    } else {
        autoplay.play();
    }
}

onMounted(() => {
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        autoplay.play();
    }
});
</script>

<template>
    <section
        id="clientes"
        aria-labelledby="clientes-title"
        class="section-spacing scroll-mt-16 bg-white"
    >
        <div class="container-spp">
            <SectionHeading
                id="clientes-title"
                eyebrow="Confianza comprobada"
                title="Clientes Distinguidos"
                :description="intro"
            />

            <div v-reveal class="relative mt-14 sm:px-14">
                <Carousel
                    :opts="{ loop: true, align: 'start' }"
                    :plugins="[autoplay]"
                    aria-label="Logotipos de clientes distinguidos"
                    class="-mr-4 focus-visible:outline-offset-8 sm:-mr-5"
                    @init-api="onInit"
                >
                    <CarouselContent class="ml-0">
                        <CarouselItem
                            v-for="(client, index) in clients"
                            :key="client.name"
                            :aria-label="`${index + 1} de ${clients.length}`"
                            class="basis-1/2 pr-5 pl-0 md:basis-1/3 lg:basis-1/4"
                        >
                            <figure
                                class="flex h-36 items-center justify-center rounded-xl border border-border bg-white p-6 transition-all duration-300 hover:-translate-y-0.5 hover:border-navy-700/25 hover:shadow-md sm:h-44"
                            >
                                <img
                                    :src="client.logo"
                                    :alt="client.name"
                                    :width="client.width"
                                    :height="client.height"
                                    loading="lazy"
                                    class="max-h-full w-auto max-w-full object-contain"
                                />
                                <figcaption class="sr-only">
                                    {{ client.name }}
                                </figcaption>
                            </figure>
                        </CarouselItem>
                    </CarouselContent>
                    <CarouselPrevious
                        class="-left-2 hidden size-11 border-border bg-white shadow-sm hover:bg-navy-900 hover:text-white sm:inline-flex"
                    />
                    <CarouselNext
                        class="right-3 hidden size-11 border-border bg-white shadow-sm hover:bg-navy-900 hover:text-white sm:inline-flex"
                    />
                </Carousel>

                <div class="mt-8 flex items-center justify-center gap-4">
                    <div
                        class="flex items-center gap-1"
                        role="group"
                        aria-label="Seleccionar cliente"
                    >
                        <button
                            v-for="(_, index) in snaps"
                            :key="index"
                            type="button"
                            class="flex size-6 items-center justify-center rounded-full"
                            :aria-label="`Ir al cliente ${index + 1}`"
                            :aria-current="
                                selected === index ? 'true' : undefined
                            "
                            @click="api?.scrollTo(index)"
                        >
                            <span
                                class="block h-1.5 rounded-full transition-all duration-300"
                                :class="
                                    selected === index
                                        ? 'w-6 bg-navy-700'
                                        : 'w-1.5 bg-navy-700/25'
                                "
                            />
                        </button>
                    </div>
                    <Button
                        variant="outline"
                        size="icon-sm"
                        class="rounded-full"
                        :aria-label="
                            playing
                                ? 'Pausar desplazamiento automático'
                                : 'Reanudar desplazamiento automático'
                        "
                        @click="toggleAutoplay"
                    >
                        <Pause v-if="playing" />
                        <Play v-else />
                    </Button>
                </div>
            </div>
        </div>
    </section>
</template>
