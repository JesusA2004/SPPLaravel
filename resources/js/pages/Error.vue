<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { House, LayoutGrid, Phone } from '@lucide/vue';
import { computed } from 'vue';
import SeoHead from '@/components/common/SeoHead.vue';
import SiteLink from '@/components/common/SiteLink.vue';
import { Button } from '@/components/ui/button';
import type { Seo } from '@/types';

const props = defineProps<{
    status: number;
    seo: Seo;
}>();

const messages: Record<number, { title: string; description: string }> = {
    403: {
        title: 'Acceso no permitido',
        description: 'No tienes permiso para ver esta página.',
    },
    404: {
        title: 'Página no encontrada',
        description:
            'La página que buscas no existe o cambió de dirección. Te ayudamos a encontrar lo que necesitas.',
    },
    500: {
        title: 'Algo salió mal',
        description:
            'Ocurrió un problema inesperado. Inténtalo de nuevo en unos momentos.',
    },
    503: {
        title: 'Sitio en mantenimiento',
        description:
            'Estamos realizando mejoras. Vuelve a intentarlo en unos minutos.',
    },
};

const message = computed(() => messages[props.status] ?? messages[500]);
</script>

<template>
    <SeoHead :seo="seo" />
    <section
        class="relative isolate flex min-h-[85svh] items-center overflow-hidden bg-ink-950 pt-(--header-height) text-white"
    >
        <img
            src="/images/marca/logo-grande.webp"
            alt=""
            class="pointer-events-none absolute top-1/2 -right-24 -z-10 w-[36rem] -translate-y-1/2 opacity-[0.06]"
        />
        <div class="container-spp py-20">
            <p
                class="font-display text-7xl font-bold text-gold-500 sm:text-8xl"
            >
                {{ status }}
            </p>
            <h1 class="mt-4 text-3xl font-semibold sm:text-4xl">
                {{ message.title }}
            </h1>
            <p class="mt-4 max-w-xl text-lg text-white/70">
                {{ message.description }}
            </p>
            <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                <Button as-child size="lg">
                    <Link href="/">
                        <House />
                        Volver al inicio
                    </Link>
                </Button>
                <Button as-child size="lg" variant="light">
                    <Link href="/servicios">
                        <LayoutGrid />
                        Consultar servicios
                    </Link>
                </Button>
                <Button as-child size="lg" variant="light">
                    <SiteLink href="#contacto">
                        <Phone />
                        Contactar
                    </SiteLink>
                </Button>
            </div>
        </div>
    </section>
</template>
