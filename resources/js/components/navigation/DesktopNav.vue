<script setup lang="ts">
import SiteLink from '@/components/common/SiteLink.vue';
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from '@/components/ui/navigation-menu';
import { isNavGroup } from '@/lib/navigation';
import type { NavEntry } from '@/lib/navigation';
import { cn } from '@/lib/utils';

defineProps<{
    entries: NavEntry[];
    isActive: (entry: NavEntry) => boolean;
    isCurrentLink: (href: string) => boolean;
}>();

const itemClass =
    'relative inline-flex h-10 flex-row items-center rounded-md bg-transparent px-3.5 text-sm font-medium text-white/85 transition-colors hover:bg-white/8 hover:text-white focus:bg-white/8 focus:text-white focus-visible:ring-2 focus-visible:ring-gold-500 focus-visible:outline-none data-[state=open]:bg-white/8 data-[state=open]:text-white data-[state=open]:hover:bg-white/8 data-[state=open]:focus:bg-white/8 xl:px-4';

const activeClass =
    'text-white after:absolute after:inset-x-3.5 after:-bottom-0.5 after:h-0.5 after:rounded-full after:bg-gold-500';
</script>

<template>
    <NavigationMenu :viewport="false" aria-label="Navegación principal">
        <NavigationMenuList class="gap-0.5">
            <NavigationMenuItem v-for="entry in entries" :key="entry.label">
                <template v-if="isNavGroup(entry)">
                    <NavigationMenuTrigger
                        :class="cn(itemClass, isActive(entry) && activeClass)"
                    >
                        {{ entry.label }}
                    </NavigationMenuTrigger>
                    <NavigationMenuContent
                        class="mt-3! rounded-xl! border-white/10! bg-ink-900! p-2 text-white shadow-2xl! shadow-black/40!"
                    >
                        <ul
                            class="grid gap-1"
                            :class="
                                entry.children.length > 4
                                    ? 'w-[40rem] grid-cols-2'
                                    : 'w-[24rem]'
                            "
                        >
                            <li
                                v-for="child in entry.children"
                                :key="child.href"
                                :class="{
                                    'col-span-2':
                                        entry.children.length > 4 &&
                                        child.href === '/servicios',
                                }"
                            >
                                <NavigationMenuLink
                                    as-child
                                    :active="isCurrentLink(child.href)"
                                    class="group/link flex-row items-start gap-3.5 rounded-lg p-3 text-white hover:bg-white/6 hover:text-white focus:bg-white/6 focus:text-white data-active:bg-white/8 data-active:text-white data-active:hover:bg-white/8 data-active:focus:bg-white/8"
                                >
                                    <SiteLink :href="child.href">
                                        <span
                                            class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-white/6 ring-1 ring-white/10 transition-colors group-hover/link:ring-gold-500/40"
                                        >
                                            <img
                                                :src="child.icon"
                                                alt=""
                                                class="size-7 object-contain"
                                                loading="lazy"
                                            />
                                        </span>
                                        <span class="min-w-0">
                                            <span
                                                class="block text-sm font-semibold text-white group-hover/link:text-gold-400"
                                            >
                                                {{ child.label }}
                                            </span>
                                            <span
                                                class="mt-0.5 line-clamp-2 block text-[0.8rem] leading-snug text-white/60"
                                            >
                                                {{ child.description }}
                                            </span>
                                        </span>
                                    </SiteLink>
                                </NavigationMenuLink>
                            </li>
                        </ul>
                    </NavigationMenuContent>
                </template>

                <NavigationMenuLink
                    v-else
                    as-child
                    :class="cn(itemClass, isActive(entry) && activeClass)"
                >
                    <SiteLink :href="entry.href">
                        {{ entry.label }}
                    </SiteLink>
                </NavigationMenuLink>
            </NavigationMenuItem>
        </NavigationMenuList>
    </NavigationMenu>
</template>
