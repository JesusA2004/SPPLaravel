<script setup lang="ts">
import { CircleCheck } from '@lucide/vue';
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import type { QuoteFields } from '@/types';

const props = defineProps<{
    submitted: QuoteFields | null;
}>();

const emit = defineEmits<{
    close: [];
}>();

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
</script>

<template>
    <Dialog
        :open="submitted !== null"
        @update:open="(open) => !open && emit('close')"
    >
        <DialogContent class="max-h-[90svh] overflow-y-auto sm:max-w-md">
            <DialogHeader class="items-center text-center sm:text-center">
                <span
                    class="mb-2 flex size-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-8 ring-emerald-50/60"
                >
                    <CircleCheck class="size-7" aria-hidden="true" />
                </span>
                <DialogTitle class="font-display text-xl">
                    ¡Solicitud enviada!
                </DialogTitle>
                <DialogDescription class="text-pretty">
                    Gracias por contactarnos. Nos pondremos en contacto contigo
                    en breve. Estos son los datos que recibimos:
                </DialogDescription>
            </DialogHeader>

            <dl
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

            <DialogFooter class="sm:justify-center">
                <DialogClose as-child>
                    <Button class="min-w-32">Continuar</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
