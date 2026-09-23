<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { CircleAlert, Send } from '@lucide/vue';
import { computed, ref } from 'vue';
import { store } from '@/actions/App/Http/Controllers/QuoteRequestController';
import FormField from '@/components/contact/FormField.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import { Textarea } from '@/components/ui/textarea';
import type { QuoteFields, QuoteStatus } from '@/types';

const props = defineProps<{
    prefill?: string | null;
    labelledBy: string;
}>();

const emit = defineEmits<{
    success: [submitted: QuoteFields];
}>();

const form = useForm({
    nombre: '',
    correo: '',
    telefono: '',
    empresa: '',
    descripcion: props.prefill ?? '',
    sitio_web: '',
});

const failure = ref<Exclude<QuoteStatus, 'success'> | null>(null);

const failureMessages: Record<Exclude<QuoteStatus, 'success'>, string> = {
    error: 'No pudimos enviar tu solicitud en este momento. Tus datos siguen aquí: inténtalo de nuevo o contáctanos por teléfono o WhatsApp.',
    throttled:
        'Recibimos varias solicitudes desde tu conexión en poco tiempo. Espera unos minutos e inténtalo de nuevo.',
    expired:
        'La página estuvo inactiva demasiado tiempo. Tus datos siguen aquí: vuelve a enviar el formulario.',
};

const failureMessage = computed(() =>
    failure.value ? failureMessages[failure.value] : null,
);

const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

function validate(): boolean {
    form.clearErrors();

    const phoneDigits = form.telefono
        .replace(/\D/g, '')
        .replace(/^52(?=\d{10}$)/, '');
    const errors: Partial<Record<keyof QuoteFields, string>> = {};

    if (form.nombre.trim().length < 3) {
        errors.nombre = 'Ingresa tu nombre completo.';
    }

    if (!emailPattern.test(form.correo.trim())) {
        errors.correo = 'Ingresa un correo electrónico válido.';
    }

    if (phoneDigits.length !== 10) {
        errors.telefono =
            'El teléfono debe tener 10 dígitos (por ejemplo, 777 123 45 67).';
    }

    if (form.empresa.trim().length < 2) {
        errors.empresa = 'Indica el nombre de la empresa, evento o actividad.';
    }

    if (form.descripcion.length > 2000) {
        errors.descripcion =
            'La descripción no debe tener más de 2000 caracteres.';
    }

    form.setError(errors);

    return Object.keys(errors).length === 0;
}

function focusFirstError(): void {
    const firstField = Object.keys(form.errors)[0];

    if (firstField) {
        document.getElementById(`cotizar-${firstField}`)?.focus();
    }
}

function submit(): void {
    if (form.processing) {
        return;
    }

    failure.value = null;

    if (!validate()) {
        focusFirstError();

        return;
    }

    const payload: QuoteFields = {
        nombre: form.nombre.trim(),
        correo: form.correo.trim(),
        telefono: form.telefono.trim(),
        empresa: form.empresa.trim(),
        descripcion: form.descripcion.trim(),
    };

    form.post(store.url(), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            const status = page.flash.quote?.status ?? 'error';

            if (status === 'success') {
                form.reset();
                emit('success', payload);
            } else {
                failure.value = status;
            }
        },
        onError: () => focusFirstError(),
        onHttpException: () => {
            failure.value = 'error';

            return false;
        },
        onNetworkError: () => {
            failure.value = 'error';

            return false;
        },
    });
}
</script>

<template>
    <form
        novalidate
        :aria-labelledby="labelledBy"
        class="space-y-5"
        @submit.prevent="submit"
    >
        <div class="grid gap-5 sm:grid-cols-2">
            <FormField
                id="cotizar-nombre"
                v-slot="field"
                label="Nombre completo"
                :error="form.errors.nombre"
                class="sm:col-span-2"
            >
                <Input
                    id="cotizar-nombre"
                    v-model="form.nombre"
                    v-bind="field"
                    name="nombre"
                    autocomplete="name"
                    maxlength="120"
                    required
                    placeholder="Ingresa tu nombre completo"
                    class="h-11 bg-white"
                />
            </FormField>

            <FormField
                id="cotizar-correo"
                v-slot="field"
                label="Correo electrónico"
                :error="form.errors.correo"
            >
                <Input
                    id="cotizar-correo"
                    v-model="form.correo"
                    v-bind="field"
                    type="email"
                    name="correo"
                    autocomplete="email"
                    inputmode="email"
                    maxlength="150"
                    required
                    placeholder="nombre@correo.com"
                    class="h-11 bg-white"
                />
            </FormField>

            <FormField
                id="cotizar-telefono"
                v-slot="field"
                label="Teléfono"
                hint="10 dígitos, sin lada internacional."
                :error="form.errors.telefono"
            >
                <Input
                    id="cotizar-telefono"
                    v-model="form.telefono"
                    v-bind="field"
                    type="tel"
                    name="telefono"
                    autocomplete="tel-national"
                    inputmode="tel"
                    maxlength="20"
                    required
                    placeholder="777 123 45 67"
                    class="h-11 bg-white"
                />
            </FormField>
        </div>

        <FormField
            id="cotizar-empresa"
            v-slot="field"
            label="Nombre de la empresa, evento o actividad"
            :error="form.errors.empresa"
        >
            <Input
                id="cotizar-empresa"
                v-model="form.empresa"
                v-bind="field"
                name="empresa"
                autocomplete="organization"
                maxlength="150"
                required
                placeholder="Ej. Mi Empresa, evento de boda, reunión corporativa"
                class="h-11 bg-white"
            />
        </FormField>

        <FormField
            id="cotizar-descripcion"
            v-slot="field"
            label="Descripción de servicios"
            optional
            :error="form.errors.descripcion"
        >
            <Textarea
                id="cotizar-descripcion"
                v-model="form.descripcion"
                v-bind="field"
                name="descripcion"
                rows="4"
                maxlength="2000"
                placeholder="Cuéntanos sobre tus necesidades o el tipo de servicio que requieres"
                class="min-h-28 resize-y bg-white"
            />
        </FormField>

        <div
            class="absolute -left-[9999px] size-px overflow-hidden"
            aria-hidden="true"
        >
            <label for="cotizar-sitio-web">No llenar este campo</label>
            <input
                id="cotizar-sitio-web"
                v-model="form.sitio_web"
                type="text"
                name="sitio_web"
                tabindex="-1"
                autocomplete="off"
            />
        </div>

        <div aria-live="polite">
            <p
                v-if="failureMessage"
                class="flex gap-3 rounded-lg border border-destructive/25 bg-red-50 p-4 text-sm leading-relaxed text-destructive"
                role="alert"
            >
                <CircleAlert
                    class="mt-0.5 size-5 shrink-0"
                    aria-hidden="true"
                />
                {{ failureMessage }}
            </p>
        </div>

        <div
            class="flex flex-col gap-4 pt-1 sm:flex-row sm:items-center sm:justify-between"
        >
            <p
                class="text-xs leading-relaxed text-muted-foreground sm:max-w-xs"
            >
                Usaremos tus datos únicamente para dar seguimiento a tu
                solicitud.
            </p>
            <Button
                type="submit"
                size="lg"
                class="w-full sm:w-auto sm:min-w-52"
                :disabled="form.processing"
                :aria-busy="form.processing"
            >
                <Spinner v-if="form.processing" />
                <Send v-else />
                {{ form.processing ? 'Enviando…' : 'Enviar cotización' }}
            </Button>
        </div>
    </form>
</template>
