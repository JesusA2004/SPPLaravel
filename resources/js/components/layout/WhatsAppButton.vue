<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { useWindowScroll } from '@vueuse/core';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import { serviceWhatsappMessage, whatsappUrl } from '@/lib/whatsapp';
import type { Service } from '@/types';

const page = usePage();
const company = page.props.company;
const { y } = useWindowScroll();

/** Secciones que ya muestran opciones de contacto; ahí el botón estorbaría. */
const contactSections = ['cotizar', 'contacto'];
const visibleContactSections = ref(new Set<string>());
let observer: IntersectionObserver | null = null;

const href = computed(() => {
    const service = page.props.service as Service | undefined;

    return service
        ? whatsappUrl(
              company.contact.whatsapp.number,
              serviceWhatsappMessage(service.phrase),
          )
        : company.contact.whatsapp.url;
});

const visible = computed(
    () => y.value > 320 && visibleContactSections.value.size === 0,
);

function observeContactSections(): void {
    observer?.disconnect();
    visibleContactSections.value = new Set();

    if (typeof IntersectionObserver === 'undefined') {
        return;
    }

    observer = new IntersectionObserver((entries) => {
        const next = new Set(visibleContactSections.value);

        for (const entry of entries) {
            if (entry.isIntersecting) {
                next.add(entry.target.id);
            } else {
                next.delete(entry.target.id);
            }
        }

        visibleContactSections.value = next;
    });

    for (const id of contactSections) {
        const element = document.getElementById(id);

        if (element) {
            observer.observe(element);
        }
    }
}

onMounted(observeContactSections);
watch(
    () => page.url,
    () => requestAnimationFrame(observeContactSections),
);
onBeforeUnmount(() => observer?.disconnect());
</script>

<template>
    <a
        :href="href"
        target="_blank"
        rel="noopener noreferrer"
        class="group fixed right-4 bottom-[calc(1rem+env(safe-area-inset-bottom))] z-30 flex items-center rounded-full bg-[#25D366] p-3.5 text-white shadow-lg ring-4 shadow-black/20 ring-white/80 transition-[transform,opacity,box-shadow,background-color] duration-300 hover:-translate-y-0.5 hover:bg-[#1ebe5b] hover:shadow-xl hover:shadow-[#25D366]/30 focus-visible:ring-navy-700 active:translate-y-0 sm:right-6 sm:bottom-[calc(1.5rem+env(safe-area-inset-bottom))]"
        :class="
            visible
                ? 'translate-y-0 opacity-100'
                : 'pointer-events-none translate-y-4 opacity-0'
        "
        :tabindex="visible ? undefined : -1"
        :aria-hidden="visible ? undefined : 'true'"
        aria-label="Escríbenos por WhatsApp (se abre en una nueva pestaña)"
    >
        <BrandIcon network="whatsapp" class="size-7" />
        <span
            class="pointer-events-none absolute top-1/2 right-full mr-3 hidden translate-x-1 -translate-y-1/2 rounded-md bg-ink-950 px-3 py-1.5 text-sm font-medium whitespace-nowrap text-white opacity-0 shadow-lg transition-[opacity,transform] duration-200 group-hover:translate-x-0 group-hover:opacity-100 group-focus-visible:translate-x-0 group-focus-visible:opacity-100 md:block"
            aria-hidden="true"
        >
            ¿Te ayudamos? Escríbenos
        </span>
    </a>
</template>
