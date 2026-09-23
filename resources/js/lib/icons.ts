import {
    BellRing,
    Car,
    CloudLightning,
    Cpu,
    Eye,
    Lock,
    Monitor,
    ScanSearch,
    ShieldCheck,
    Zap,
} from '@lucide/vue';
import type { Component } from 'vue';

const icons: Record<string, Component> = {
    'bell-ring': BellRing,
    car: Car,
    'cloud-lightning': CloudLightning,
    cpu: Cpu,
    eye: Eye,
    lock: Lock,
    monitor: Monitor,
    'scan-search': ScanSearch,
    'shield-check': ShieldCheck,
    zap: Zap,
};

/**
 * Icono de Lucide a partir del nombre definido en el catálogo de servicios.
 */
export function resolveIcon(name: string): Component {
    return icons[name] ?? ShieldCheck;
}
