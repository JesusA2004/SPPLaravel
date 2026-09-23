<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { CircleCheck, Clock, TriangleAlert } from '@lucide/vue';
import { computed } from 'vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import type { QuoteStatus } from '@/types';

const props = defineProps<{
    status: QuoteStatus | null;
    submitted: {
        nombre: string;
        correo: string;
        telefono: string;
        empresa: string;
        descripcion: string;
    } | null;
}>();

const emit = defineEmits<{
    close: [];
}>();

const company = usePage().props.company;

const content = computed(() => {
    switch (props.status) {
        case 'success':
            return {
                icon: CircleCheck,
                tone: 'bg-emerald-50 text-emerald-600 ring-emerald-100',
                title: '¡Solicitud enviada!',
                description:
                    'Gracias por contactarnos. Nos pondremos en contacto contigo en breve. Estos son los datos que recibimos:',
            };
        case 'throttled':
            return {
                icon: Clock,
                tone: 'bg-amber-50 text-amber-600 ring-amber-100',
                title: 'Demasiados intentos',
                description:
                    'Recibimos varias solicitudes desde tu conexión en poco tiempo. Espera unos minutos e inténtalo de nuevo, o contáctanos directamente.',
            };
        case 'expired':
            return {
                icon: Clock,
                tone: 'bg-amber-50 text-amber-600 ring-amber-100',
                title: 'La sesión expiró',
                description:
                    'Por seguridad, la página estuvo inactiva demasiado tiempo. Tus datos siguen en el formulario: vuelve a enviarlo.',
            };
        default:
            return {
                icon: TriangleAlert,
                tone: 'bg-red-50 text-destructive ring-red-100',
                title: 'No pudimos enviar tu solicitud',
                description:
                    'Ocurrió un problema al enviar tu solicitud en este momento. Tus datos siguen en el formulario; inténtalo de nuevo o contáctanos directamente.',
            };
    }
});

const summary = computed(() =>
    props.submitted
        ? [
              { label: 'Nombre', value: props.submitted.nombre },
              { label: 'Correo', value: props.submitted.correo },
              { label: 'Teléfono', value: props.submitted.telefono },
              {
                  label: 'Empresa, evento o actividad',
                  value: props.submitted.empresa,
              },
              {
                  label: 'Descripción',
                  value: props.submitted.descripcion || 'Sin descripción',
              },
          ]
        : [],
);

function onOpenChange(open: boolean): void {
    if (!open) {
        emit('close');
    }
}
</script>

<template>
    <Dialog :open="status !== null" @update:open="onOpenChange">
        <DialogContent class="max-h-[90svh] overflow-y-auto sm:max-w-md">
            <DialogHeader class="items-center text-center sm:text-center">
                <span
                    class="mb-2 flex size-14 items-center justify-center rounded-full ring-8"
                    :class="content.tone"
                >
                    <component
                        :is="content.icon"
                        class="size-7"
                        aria-hidden="true"
                    />
                </span>
                <DialogTitle class="font-display text-xl">
                    {{ content.title }}
                </DialogTitle>
                <DialogDescription class="text-pretty">
                    {{ content.description }}
                </DialogDescription>
            </DialogHeader>

            <dl
                v-if="status === 'success' && summary.length"
                class="divide-y divide-border rounded-lg border bg-muted/60 text-sm"
            >
                <div
                    v-for="item in summary"
                    :key="item.label"
                    class="grid gap-0.5 px-4 py-2.5 sm:grid-cols-[9rem_1fr] sm:gap-3"
                >
                    <dt class="font-medium text-muted-foreground">
                        {{ item.label }}
                    </dt>
                    <dd class="break-words whitespace-pre-line text-ink-900">
                        {{ item.value }}
                    </dd>
                </div>
            </dl>

            <DialogFooter class="gap-2 sm:justify-center">
                <Button
                    v-if="status !== 'success' && status !== 'expired'"
                    as-child
                    variant="outline"
                >
                    <a
                        :href="company.contact.whatsapp.url"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <BrandIcon
                            network="whatsapp"
                            class="size-4 text-[#1ebe5b]"
                        />
                        Escribir por WhatsApp
                    </a>
                </Button>
                <Button @click="emit('close')">
                    {{ status === 'success' ? 'Continuar' : 'Entendido' }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
