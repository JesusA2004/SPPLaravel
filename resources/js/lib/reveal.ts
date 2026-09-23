import type { Directive } from 'vue';

let observer: IntersectionObserver | null = null;

function getObserver(): IntersectionObserver {
    observer ??= new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer?.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );

    return observer;
}

/**
 * Hace aparecer suavemente un elemento al entrar en pantalla.
 * El valor opcional es un retraso en milisegundos: v-reveal="120".
 */
export const reveal: Directive<HTMLElement, number | undefined> = {
    mounted(el, binding) {
        if (typeof IntersectionObserver === 'undefined') {
            return;
        }

        el.dataset.reveal = '';

        if (binding.value) {
            el.style.setProperty('--reveal-delay', `${binding.value}ms`);
        }

        getObserver().observe(el);
    },
    unmounted(el) {
        observer?.unobserve(el);
    },
};
