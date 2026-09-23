<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ChevronDown, FileText, Menu, Phone } from '@lucide/vue';
import { ref } from 'vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import SiteLink from '@/components/common/SiteLink.vue';
import BrandLogo from '@/components/layout/BrandLogo.vue';
import { Button } from '@/components/ui/button';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { isNavGroup } from '@/lib/navigation';
import type { NavEntry } from '@/lib/navigation';
import { cn } from '@/lib/utils';

defineProps<{
    entries: NavEntry[];
    isActive: (entry: NavEntry) => boolean;
    isCurrentLink: (href: string) => boolean;
}>();

const open = ref(false);
const company = usePage().props.company;

function close(): void {
    open.value = false;
}
</script>

<template>
    <Sheet v-model:open="open">
        <SheetTrigger as-child>
            <Button
                variant="ghost"
                size="icon"
                class="text-white hover:bg-white/10 hover:text-white"
                aria-label="Abrir menú de navegación"
            >
                <Menu class="size-6" />
            </Button>
        </SheetTrigger>

        <SheetContent
            side="right"
            class="flex w-[88vw] max-w-sm flex-col gap-0 border-l-white/10 bg-ink-950 p-0 text-white [&>button]:top-7 [&>button]:right-5 [&>button]:text-white [&>button>svg]:size-5"
        >
            <div class="border-b border-white/10 px-5 py-4">
                <SheetTitle class="sr-only">Menú de navegación</SheetTitle>
                <SheetDescription class="sr-only">
                    Secciones y servicios de {{ company.name }}
                </SheetDescription>
                <SiteLink
                    href="/"
                    class="inline-flex rounded-md"
                    @navigate="close"
                >
                    <BrandLogo />
                </SiteLink>
            </div>

            <nav
                aria-label="Navegación móvil"
                class="flex-1 overflow-y-auto px-3 py-4"
            >
                <ul class="space-y-1">
                    <li v-for="entry in entries" :key="entry.label">
                        <Collapsible
                            v-if="isNavGroup(entry)"
                            v-slot="{ open: groupOpen }"
                        >
                            <CollapsibleTrigger
                                :class="
                                    cn(
                                        'flex w-full items-center justify-between rounded-lg px-3 py-3 text-left text-base font-medium text-white/90 transition-colors hover:bg-white/6',
                                        isActive(entry) && 'text-gold-400',
                                    )
                                "
                            >
                                {{ entry.label }}
                                <ChevronDown
                                    class="size-4 text-white/60 transition-transform duration-200"
                                    :class="{ 'rotate-180': groupOpen }"
                                    aria-hidden="true"
                                />
                            </CollapsibleTrigger>
                            <CollapsibleContent>
                                <ul
                                    class="mt-1 mb-2 ml-3 space-y-0.5 border-l border-white/10 pl-3"
                                >
                                    <li
                                        v-for="child in entry.children"
                                        :key="child.href"
                                    >
                                        <SiteLink
                                            :href="child.href"
                                            :aria-current="
                                                isCurrentLink(child.href)
                                                    ? 'page'
                                                    : undefined
                                            "
                                            :class="
                                                cn(
                                                    'flex items-center gap-3 rounded-lg px-2.5 py-2.5 text-[0.95rem] text-white/75 transition-colors hover:bg-white/6 hover:text-white',
                                                    isCurrentLink(child.href) &&
                                                        'bg-white/6 text-gold-400',
                                                )
                                            "
                                            @navigate="close"
                                        >
                                            <span
                                                class="flex size-8 shrink-0 items-center justify-center rounded-md"
                                                :class="
                                                    child.lightIconBackground
                                                        ? 'bg-white'
                                                        : 'bg-white/6'
                                                "
                                            >
                                                <img
                                                    :src="child.icon"
                                                    alt=""
                                                    class="size-5 object-contain"
                                                    loading="lazy"
                                                />
                                            </span>
                                            {{ child.label }}
                                        </SiteLink>
                                    </li>
                                </ul>
                            </CollapsibleContent>
                        </Collapsible>

                        <SiteLink
                            v-else
                            :href="entry.href"
                            :class="
                                cn(
                                    'flex rounded-lg px-3 py-3 text-base font-medium text-white/90 transition-colors hover:bg-white/6',
                                    isActive(entry) && 'text-gold-400',
                                )
                            "
                            @navigate="close"
                        >
                            {{ entry.label }}
                        </SiteLink>
                    </li>
                </ul>
            </nav>

            <div class="space-y-3 border-t border-white/10 p-5">
                <Button as-child size="lg" class="w-full">
                    <SiteLink href="#cotizar" @navigate="close">
                        <FileText />
                        Solicitar cotización
                    </SiteLink>
                </Button>
                <div class="grid grid-cols-2 gap-2">
                    <Button as-child variant="light" class="w-full">
                        <a :href="company.contact.phone.href">
                            <Phone />
                            Llamar
                        </a>
                    </Button>
                    <Button as-child variant="light" class="w-full">
                        <a
                            :href="company.contact.whatsapp.url"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <BrandIcon network="whatsapp" class="size-4" />
                            WhatsApp
                        </a>
                    </Button>
                </div>
            </div>
        </SheetContent>
    </Sheet>
</template>
