function prefersReducedMotion(): boolean {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

/**
 * Desplaza suavemente hasta una sección de la página actual y le da el foco
 * para que lectores de pantalla y navegación por teclado continúen desde ahí.
 */
export function scrollToSection(id: string): boolean {
    const target = document.getElementById(id);

    if (!target) {
        return false;
    }

    target.scrollIntoView({
        behavior: prefersReducedMotion() ? 'auto' : 'smooth',
        block: 'start',
    });

    if (!target.hasAttribute('tabindex')) {
        target.setAttribute('tabindex', '-1');
    }

    target.focus({ preventScroll: true });
    history.replaceState(history.state, '', `#${id}`);

    return true;
}

/**
 * Obtiene el id de la sección para enlaces del tipo "#cotizar" o "/#cotizar".
 */
export function sectionIdFromHref(href: string): string | null {
    const match = /^\/?#([\w-]+)$/.exec(href);

    return match ? match[1] : null;
}
