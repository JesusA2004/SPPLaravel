import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useActiveSection } from '@/composables/useActiveSection';
import { buildNavigation } from '@/lib/navigation';
import type { NavEntry } from '@/lib/navigation';

const sectionOwners: Record<string, string> = {
    inicio: 'Inicio',
    empresa: 'Filosofía Empresarial',
    clientes: 'Filosofía Empresarial',
    servicios: 'Nuestros servicios',
    contacto: 'Contacto',
};

/**
 * Entradas de navegación y estado activo compartidos por el menú
 * de escritorio y el menú móvil.
 */
export function useNavigation() {
    const page = usePage();

    const entries = computed(() => buildNavigation(page.props.services));
    const currentPath = computed(() => page.url.split(/[?#]/)[0]);
    const isHome = computed(() => currentPath.value === '/');

    const activeSection = useActiveSection(Object.keys(sectionOwners), isHome);

    function isActive(entry: NavEntry): boolean {
        if (currentPath.value.startsWith('/servicios')) {
            return entry.label === 'Nuestros servicios';
        }

        return (
            isHome.value &&
            activeSection.value !== null &&
            sectionOwners[activeSection.value] === entry.label
        );
    }

    function isCurrentLink(href: string): boolean {
        return href === currentPath.value;
    }

    return { entries, isHome, isActive, isCurrentLink };
}
