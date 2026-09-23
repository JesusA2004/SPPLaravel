<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Mail, MapPin, Phone } from '@lucide/vue';
import BrandIcon from '@/components/common/BrandIcon.vue';

const company = usePage().props.company;

const linkClass =
    'group/contact inline-flex items-center gap-3 rounded-md transition-colors duration-150 hover:text-gold-400';
const iconClass =
    'flex size-9 shrink-0 items-center justify-center rounded-full bg-white/10 transition-colors duration-150 group-hover/contact:bg-gold-500 group-hover/contact:text-ink-950';
</script>

<template>
    <ul class="space-y-3 text-sm">
        <li>
            <a :href="company.contact.phone.href" :class="linkClass">
                <span :class="iconClass">
                    <Phone class="size-4" aria-hidden="true" />
                </span>
                <span>
                    <span class="sr-only">Teléfono: </span>
                    {{ company.contact.phone.label }}
                </span>
            </a>
        </li>
        <li>
            <a
                :href="company.contact.whatsapp.url"
                target="_blank"
                rel="noopener noreferrer"
                :class="linkClass"
            >
                <span :class="iconClass">
                    <BrandIcon network="whatsapp" class="size-4" />
                </span>
                WhatsApp {{ company.contact.whatsapp.label }}
            </a>
        </li>
        <li>
            <a
                :href="`mailto:${company.contact.email}`"
                :class="[linkClass, 'break-all']"
            >
                <span :class="iconClass">
                    <Mail class="size-4" aria-hidden="true" />
                </span>
                {{ company.contact.email }}
            </a>
        </li>
        <li>
            <a
                :href="company.contact.mapsUrl"
                target="_blank"
                rel="noopener noreferrer"
                :class="linkClass"
            >
                <span :class="iconClass">
                    <MapPin class="size-4" aria-hidden="true" />
                </span>
                <span>
                    {{ company.contact.address }}, {{ company.contact.city }}
                    <span class="sr-only">(abrir en Google Maps)</span>
                </span>
            </a>
        </li>
    </ul>
</template>
