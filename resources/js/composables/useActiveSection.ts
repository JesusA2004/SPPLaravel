import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import type { Ref } from 'vue';

/**
 * Indica qué sección de la página está actualmente a la vista.
 */
export function useActiveSection(ids: string[], enabled: Ref<boolean>) {
    const activeId = ref<string | null>(null);
    let observer: IntersectionObserver | null = null;

    function disconnect(): void {
        observer?.disconnect();
        observer = null;
        activeId.value = null;
    }

    function connect(): void {
        disconnect();

        if (!enabled.value || typeof IntersectionObserver === 'undefined') {
            return;
        }

        observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) {
                        activeId.value = entry.target.id;
                    }
                }
            },
            { rootMargin: '-45% 0px -50% 0px' },
        );

        for (const id of ids) {
            const element = document.getElementById(id);

            if (element) {
                observer.observe(element);
            }
        }
    }

    onMounted(connect);
    watch(enabled, () => requestAnimationFrame(connect));
    onBeforeUnmount(disconnect);

    return activeId;
}
