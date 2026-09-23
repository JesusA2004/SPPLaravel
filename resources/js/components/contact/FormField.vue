<script setup lang="ts">
import { CircleAlert } from '@lucide/vue';
import { Label } from '@/components/ui/label';

defineProps<{
    id: string;
    label: string;
    error?: string;
    hint?: string;
    optional?: boolean;
}>();
</script>

<template>
    <div class="space-y-2">
        <Label :for="id" class="text-sm font-medium text-ink-900">
            {{ label }}
            <span v-if="optional" class="font-normal text-muted-foreground">
                (opcional)
            </span>
        </Label>
        <slot
            :aria-invalid="error ? true : undefined"
            :aria-describedby="
                [error ? `${id}-error` : null, hint ? `${id}-hint` : null]
                    .filter(Boolean)
                    .join(' ') || undefined
            "
        />
        <p
            v-if="error"
            :id="`${id}-error`"
            class="flex items-start gap-1.5 text-sm text-destructive"
            role="alert"
        >
            <CircleAlert class="mt-0.5 size-4 shrink-0" aria-hidden="true" />
            {{ error }}
        </p>
        <p
            v-else-if="hint"
            :id="`${id}-hint`"
            class="text-xs text-muted-foreground"
        >
            {{ hint }}
        </p>
    </div>
</template>
