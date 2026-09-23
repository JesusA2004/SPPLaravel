<script setup lang="ts">
import { ref } from 'vue';
import QuoteForm from '@/components/contact/QuoteForm.vue';
import QuoteResultDialog from '@/components/contact/QuoteResultDialog.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import type { QuoteFields } from '@/types';

defineProps<{
    prefill?: string | null;
    serviceName?: string;
}>();

const open = defineModel<boolean>('open', { required: true });
const submitted = ref<QuoteFields | null>(null);

function onSuccess(data: QuoteFields): void {
    open.value = false;
    submitted.value = data;
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent
            class="max-h-[92svh] overflow-y-auto p-5 sm:max-w-2xl sm:p-8"
            @interact-outside.prevent
        >
            <DialogHeader class="pr-6 text-left">
                <DialogTitle
                    id="cotizar-dialogo-titulo"
                    class="font-display text-2xl"
                >
                    Solicitar cotización
                </DialogTitle>
                <DialogDescription>
                    <template v-if="serviceName">
                        Cuéntanos qué necesitas sobre
                        {{ serviceName }} y te contactaremos a la brevedad.
                    </template>
                    <template v-else>
                        Cuéntanos qué necesitas y te contactaremos a la
                        brevedad.
                    </template>
                </DialogDescription>
            </DialogHeader>

            <QuoteForm
                :prefill="prefill"
                labelled-by="cotizar-dialogo-titulo"
                class="mt-2"
                @success="onSuccess"
            />
        </DialogContent>
    </Dialog>

    <QuoteResultDialog :submitted="submitted" @close="submitted = null" />
</template>
