import type { Directive } from 'vue';

const pending = new Set<HTMLElement>();
let observer: IntersectionObserver | null = null;

function show(element: Element): void {
    element.classList.add('is-revealed');
    observer?.unobserve(element);
    pending.delete(element as HTMLElement);
}

/**
 * Tras un salto rápido (ancla o scroll veloz) un elemento puede pasar de
 * abajo hacia arriba del viewport sin llegar a intersectar; al terminar el
 * scroll se muestran los que ya quedaron por encima del borde inferior.
 */
function sweep(): void {
    for (const element of pending) {
        if (element.getBoundingClientRect().top < window.innerHeight) {
            show(element);
        }
    }
}

function getObserver(): IntersectionObserver {
    if (!observer) {
        observer = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) {
                    if (entry.isIntersecting) {
                        show(entry.target);
                    }
                }
            },
            { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
        );

        window.addEventListener('scrollend', sweep, { passive: true });
    }

    return observer;
}

/**
 * Hace aparecer suavemente un elemento al entrar en pantalla.
 * El valor opcional es un retraso en milisegundos para escalonar: v-reveal="120".
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

        pending.add(el);
        getObserver().observe(el);
    },
    unmounted(el) {
        observer?.unobserve(el);
        pending.delete(el);
    },
};
