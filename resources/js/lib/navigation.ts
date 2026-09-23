import type { ServiceSummary } from '@/types';

export type NavLink = {
    label: string;
    href: string;
    description?: string;
    icon?: string;
    lightIconBackground?: boolean;
};

export type NavGroup = {
    label: string;
    children: NavLink[];
};

export type NavEntry = NavLink | NavGroup;

export function isNavGroup(entry: NavEntry): entry is NavGroup {
    return 'children' in entry;
}

export const philosophyLinks: NavLink[] = [
    {
        label: 'Misión',
        href: '/#mision',
        description: 'Nuestro compromiso con los clientes y la sociedad.',
        icon: '/images/iconos/mision.webp',
        lightIconBackground: true,
    },
    {
        label: 'Visión',
        href: '/#vision',
        description: 'La organización que buscamos ser.',
        icon: '/images/iconos/vision.webp',
        lightIconBackground: true,
    },
    {
        label: 'Valores',
        href: '/#valores',
        description: 'Los principios que guían nuestro trabajo.',
        icon: '/images/iconos/valores.webp',
        lightIconBackground: true,
    },
    {
        label: 'Clientes Distinguidos',
        href: '/#clientes',
        description: 'Organizaciones que confían en nosotros.',
        icon: '/images/iconos/clientes.webp',
    },
];

export function buildNavigation(services: ServiceSummary[]): NavEntry[] {
    return [
        { label: 'Inicio', href: '/#inicio' },
        { label: 'Filosofía Empresarial', children: philosophyLinks },
        {
            label: 'Nuestros servicios',
            children: [
                {
                    label: 'Todos los servicios',
                    href: '/servicios',
                    description:
                        'Conoce todas nuestras soluciones de seguridad.',
                    icon: '/images/iconos/todos-los-servicios.webp',
                },
                ...services.map((service) => ({
                    label: service.navLabel,
                    href: service.url,
                    description: service.summary,
                    icon: service.icon,
                })),
            ],
        },
        { label: 'Contacto', href: '#contacto' },
    ];
}

export const quickLinks: NavLink[] = [
    { label: 'Inicio', href: '/#inicio' },
    { label: 'Filosofía Empresarial', href: '/#empresa' },
    { label: 'Clientes Distinguidos', href: '/#clientes' },
    { label: 'Servicios', href: '/servicios' },
    { label: 'Cotizar', href: '#cotizar' },
    { label: 'Contacto', href: '#contacto' },
];
