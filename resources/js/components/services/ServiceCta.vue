<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { FileText, Phone } from '@lucide/vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import SiteLink from '@/components/common/SiteLink.vue';
import { Button } from '@/components/ui/button';

withDefaults(
    defineProps<{
        title?: string;
        description?: string;
    }>(),
    {
        title: '¿Necesitas proteger tu empresa, evento o patrimonio?',
        description:
            'Cuéntanos qué necesitas y te enviaremos una propuesta a la medida. También puedes llamarnos o escribirnos por WhatsApp.',
    },
);

const company = usePage().props.company;
</script>

<template>
    <section aria-label="Solicitar información" class="bg-gold-500">
        <div
            class="container-spp flex flex-col gap-8 py-12 sm:py-14 lg:flex-row lg:items-center lg:justify-between"
        >
            <div v-reveal class="max-w-2xl">
                <h2
                    class="text-2xl leading-tight font-bold text-ink-950 sm:text-3xl"
                >
                    {{ title }}
                </h2>
                <p class="mt-3 text-ink-900/80">{{ description }}</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row lg:shrink-0">
                <Button
                    as-child
                    size="lg"
                    variant="secondary"
                    class="bg-ink-950 hover:bg-ink-800"
                >
                    <SiteLink href="#cotizar">
                        <FileText />
                        Cotizar ahora
                    </SiteLink>
                </Button>
                <Button
                    as-child
                    size="lg"
                    variant="outline"
                    class="border-ink-950/20 bg-white/40 text-ink-950 hover:border-ink-950/40 hover:bg-white/70"
                >
                    <a
                        :href="company.contact.whatsapp.url"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <BrandIcon network="whatsapp" class="size-4" />
                        WhatsApp
                    </a>
                </Button>
                <Button
                    as-child
                    size="lg"
                    variant="outline"
                    class="border-ink-950/20 bg-white/40 text-ink-950 hover:border-ink-950/40 hover:bg-white/70"
                >
                    <a :href="company.contact.phone.href">
                        <Phone />
                        {{ company.contact.phone.label }}
                    </a>
                </Button>
            </div>
        </div>
    </section>
</template>
