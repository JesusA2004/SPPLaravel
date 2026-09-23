<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { FileText } from '@lucide/vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import { Button } from '@/components/ui/button';
import { resolveIcon } from '@/lib/icons';
import { serviceWhatsappMessage, whatsappUrl } from '@/lib/whatsapp';
import type { Service } from '@/types';

const props = defineProps<{
    service: Service;
}>();

const emit = defineEmits<{
    quote: [];
}>();

const company = usePage().props.company;
const whatsappLink = whatsappUrl(
    company.contact.whatsapp.number,
    serviceWhatsappMessage(props.service.phrase),
);
</script>

<template>
    <section aria-labelledby="servicio-intro" class="section-spacing bg-white">
        <div class="container-spp">
            <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                <div v-reveal class="order-2 lg:order-1">
                    <div class="flex items-center gap-4">
                        <span
                            class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-ink-950"
                        >
                            <img
                                :src="service.icon"
                                alt=""
                                class="size-9 object-contain"
                            />
                        </span>
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-navy-700 uppercase"
                        >
                            {{ service.name }}
                        </p>
                    </div>
                    <h2
                        id="servicio-intro"
                        class="mt-6 text-3xl leading-tight font-semibold text-ink-950 sm:text-4xl"
                    >
                        {{ service.introTitle }}
                    </h2>
                    <p
                        class="mt-5 text-lg leading-relaxed text-pretty text-muted-foreground"
                    >
                        {{ service.intro }}
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <Button size="lg" @click="emit('quote')">
                            <FileText />
                            Cotizar este servicio
                        </Button>
                        <Button as-child size="lg" variant="outline">
                            <a
                                :href="whatsappLink"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <BrandIcon
                                    network="whatsapp"
                                    class="size-4 text-[#1ebe5b]"
                                />
                                Consultar por WhatsApp
                            </a>
                        </Button>
                    </div>
                </div>

                <div v-reveal="120" class="group relative order-1 lg:order-2">
                    <div
                        class="absolute -inset-3 -z-10 rounded-3xl bg-gradient-to-br from-gold-500/30 via-transparent to-navy-700/20 blur-2xl"
                        aria-hidden="true"
                    />
                    <div class="sheen overflow-hidden rounded-2xl shadow-xl">
                        <img
                            :src="service.heroImage.src"
                            :alt="service.heroImage.alt"
                            :width="service.heroImage.width"
                            :height="service.heroImage.height"
                            fetchpriority="high"
                            decoding="async"
                            class="aspect-[4/3] w-full object-cover transition-transform duration-700 ease-(--ease-out-soft) group-hover:scale-[1.03]"
                        />
                    </div>
                </div>
            </div>

            <ul class="mt-16 grid gap-5 md:grid-cols-3">
                <li
                    v-for="(highlight, index) in service.highlights"
                    :key="highlight.title"
                    v-reveal="index * 100"
                    class="group sheen rounded-2xl border border-border bg-muted/50 p-6 transition-[transform,background-color,border-color,box-shadow] hover:-translate-y-1 hover:border-gold-500/50 hover:bg-white hover:shadow-lg hover:shadow-navy-900/5"
                >
                    <span
                        class="flex size-11 items-center justify-center rounded-lg bg-navy-900 text-gold-500 transition-colors group-hover:bg-gold-500 group-hover:text-ink-950"
                    >
                        <component
                            :is="resolveIcon(highlight.icon)"
                            class="size-5"
                            aria-hidden="true"
                        />
                    </span>
                    <h3 class="mt-5 text-lg font-semibold text-ink-950">
                        {{ highlight.title }}
                    </h3>
                    <p class="mt-2 leading-relaxed text-muted-foreground">
                        {{ highlight.text }}
                    </p>
                </li>
            </ul>
        </div>
    </section>
</template>
