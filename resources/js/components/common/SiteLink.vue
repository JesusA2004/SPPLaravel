<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { scrollToSection, sectionIdFromHref } from '@/lib/scroll';

const props = defineProps<{
    href: string;
    external?: boolean;
}>();

const emit = defineEmits<{
    navigate: [];
}>();

const sectionId = computed(() => sectionIdFromHref(props.href));

const resolvedHref = computed(() =>
    props.href.startsWith('#') ? `/${props.href}` : props.href,
);

function onSectionClick(event: MouseEvent): void {
    if (
        event.metaKey ||
        event.ctrlKey ||
        event.shiftKey ||
        event.button !== 0
    ) {
        return;
    }

    event.preventDefault();
    emit('navigate');

    if (!scrollToSection(sectionId.value as string)) {
        router.visit(resolvedHref.value);
    }
}
</script>

<template>
    <a
        v-if="external"
        :href="href"
        target="_blank"
        rel="noopener noreferrer"
        @click="emit('navigate')"
    >
        <slot />
    </a>
    <a v-else-if="sectionId" :href="resolvedHref" @click="onSectionClick">
        <slot />
    </a>
    <Link v-else :href="href" @click="emit('navigate')">
        <slot />
    </Link>
</template>
