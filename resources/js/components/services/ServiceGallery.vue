<script setup lang="ts">
import { ChevronLeft, ChevronRight, Expand } from '@lucide/vue';
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
} from '@/components/ui/dialog';
import type { Service } from '@/types';

const props = defineProps<{
    gallery: Service['gallery'];
}>();

const activeIndex = ref<number | null>(null);
const activeItem = computed(() =>
    activeIndex.value === null ? null : props.gallery.items[activeIndex.value],
);

function move(step: number): void {
    if (activeIndex.value === null) {
        return;
    }

    const total = props.gallery.items.length;
    activeIndex.value = (activeIndex.value + step + total) % total;
}

function onKeydown(event: KeyboardEvent): void {
    if (event.key === 'ArrowRight') {
        move(1);
    } else if (event.key === 'ArrowLeft') {
        move(-1);
    }
}
</script>

<template>
    <section
        aria-labelledby="servicio-galeria"
        class="section-spacing bg-ink-950"
    >
        <div class="container-spp">
            <h2
                id="servicio-galeria"
                v-reveal
                class="text-center text-3xl font-semibold text-white sm:text-4xl"
            >
                {{ gallery.title }}
            </h2>

            <ul
                class="mt-12 grid gap-5 sm:grid-cols-2"
                :class="
                    gallery.items.length === 4
                        ? 'lg:grid-cols-4'
                        : 'lg:grid-cols-3'
                "
            >
                <li
                    v-for="(item, index) in gallery.items"
                    :key="item.src"
                    v-reveal="index * 100"
                    :class="{
                        'sm:col-span-2 lg:col-span-1':
                            gallery.items.length === 3 && index === 2,
                    }"
                >
                    <button
                        type="button"
                        class="group relative block aspect-[4/3] w-full overflow-hidden rounded-2xl bg-ink-800 text-left"
                        :aria-label="`Ampliar imagen: ${item.caption}`"
                        @click="activeIndex = index"
                    >
                        <img
                            :src="item.src"
                            :alt="item.alt"
                            :width="item.width"
                            :height="item.height"
                            loading="lazy"
                            class="size-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                        />
                        <span
                            class="absolute inset-0 bg-gradient-to-t from-ink-950/90 via-ink-950/10 to-transparent"
                            aria-hidden="true"
                        />
                        <span
                            class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-5"
                        >
                            <span
                                class="font-display text-base font-semibold text-white"
                            >
                                {{ item.caption }}
                            </span>
                            <span
                                class="flex size-9 shrink-0 items-center justify-center rounded-full bg-white/15 text-white opacity-0 backdrop-blur-sm transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100"
                                aria-hidden="true"
                            >
                                <Expand class="size-4" />
                            </span>
                        </span>
                    </button>
                </li>
            </ul>
        </div>

        <Dialog
            :open="activeItem !== null"
            @update:open="(open) => !open && (activeIndex = null)"
        >
            <DialogContent
                v-if="activeItem"
                class="max-w-[calc(100%-2rem)] gap-0 overflow-hidden border-white/10 bg-ink-950 p-0 text-white sm:max-w-4xl [&>button]:rounded-full [&>button]:bg-ink-950/70 [&>button]:p-1.5 [&>button]:text-white [&>button]:opacity-100"
                @keydown="onKeydown"
            >
                <img
                    :src="activeItem.src"
                    :alt="activeItem.alt"
                    class="max-h-[75svh] w-full bg-black object-contain"
                />
                <div class="flex items-center justify-between gap-4 p-4 sm:p-5">
                    <div>
                        <DialogTitle class="font-display text-lg">
                            {{ activeItem.caption }}
                        </DialogTitle>
                        <DialogDescription class="text-sm text-white/60">
                            Imagen {{ (activeIndex ?? 0) + 1 }} de
                            {{ gallery.items.length }}
                        </DialogDescription>
                    </div>
                    <div class="flex gap-2">
                        <Button
                            variant="light"
                            size="icon"
                            aria-label="Imagen anterior"
                            @click="move(-1)"
                        >
                            <ChevronLeft />
                        </Button>
                        <Button
                            variant="light"
                            size="icon"
                            aria-label="Imagen siguiente"
                            @click="move(1)"
                        >
                            <ChevronRight />
                        </Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </section>
</template>
