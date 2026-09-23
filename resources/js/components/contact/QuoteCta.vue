<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { FileText, Phone } from '@lucide/vue';
import { computed } from 'vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import QuoteDialog from '@/components/contact/QuoteDialog.vue';
import { Button } from '@/components/ui/button';
import { serviceWhatsappMessage, whatsappUrl } from '@/lib/whatsapp';

const props = defineProps<{
    serviceName?: string;
    prefill?: string | null;
}>();

const company = usePage().props.company;
const dialogOpen = defineModel<boolean>('dialogOpen', { default: false });

const whatsappLink = computed(() =>
    props.serviceName
        ? whatsappUrl(
              company.contact.whatsapp.number,
              serviceWhatsappMessage(props.serviceName),
          )
        : company.contact.whatsapp.url,
);
</script>

<template>
    <section
        id="cotizar"
        aria-labelledby="cotizar-cta-titulo"
        class="bg-muted py-16 sm:py-20"
    >
        <div class="container-spp">
            <div
                v-reveal
                class="on-dark relative isolate overflow-hidden rounded-3xl bg-ink-950 px-6 py-10 text-white sm:px-10 sm:py-12 lg:px-14"
            >
                <div
                    class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,rgb(42_42_114/0.55),transparent_60%)]"
                    aria-hidden="true"
                />
                <img
                    src="/images/marca/logo-grande.webp"
                    alt=""
                    width="720"
                    height="643"
                    loading="lazy"
                    class="pointer-events-none absolute -right-16 -bottom-20 -z-10 w-72 opacity-[0.07] sm:w-96"
                />

                <div
                    class="flex flex-col gap-8 xl:flex-row xl:items-center xl:justify-between"
                >
                    <div class="max-w-xl">
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-gold-500 uppercase"
                        >
                            Cotiza sin compromiso
                        </p>
                        <h2
                            id="cotizar-cta-titulo"
                            class="mt-3 text-2xl leading-tight font-semibold sm:text-3xl"
                        >
                            <template v-if="serviceName">
                                ¿Necesitas {{ serviceName }}?
                            </template>
                            <template v-else>
                                ¿Qué necesitas proteger?
                            </template>
                        </h2>
                        <p class="mt-3 leading-relaxed text-white/75">
                            Cuéntanos tu caso y te enviaremos una propuesta a la
                            medida. Atendemos en {{ company.contact.city }}.
                        </p>
                    </div>

                    <div
                        class="flex flex-col gap-3 sm:flex-row sm:flex-wrap xl:shrink-0 xl:justify-end"
                    >
                        <Button
                            size="lg"
                            class="w-full sm:w-auto"
                            @click="dialogOpen = true"
                        >
                            <FileText />
                            Solicitar cotización
                        </Button>
                        <Button
                            as-child
                            size="lg"
                            variant="light"
                            class="w-full sm:w-auto"
                        >
                            <a
                                :href="whatsappLink"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <BrandIcon
                                    network="whatsapp"
                                    class="size-4 text-[#25D366]"
                                />
                                Hablar por WhatsApp
                            </a>
                        </Button>
                        <Button
                            as-child
                            size="lg"
                            variant="light"
                            class="w-full sm:w-auto"
                        >
                            <a :href="company.contact.phone.href">
                                <Phone />
                                Llamar al {{ company.contact.phone.label }}
                            </a>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <QuoteDialog
            v-model:open="dialogOpen"
            :prefill="prefill"
            :service-name="serviceName"
        />
    </section>
</template>
