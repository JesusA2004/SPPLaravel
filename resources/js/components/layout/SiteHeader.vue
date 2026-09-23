<script setup lang="ts">
import { FileText } from '@lucide/vue';
import { useWindowScroll } from '@vueuse/core';
import { computed } from 'vue';
import SiteLink from '@/components/common/SiteLink.vue';
import BrandLogo from '@/components/layout/BrandLogo.vue';
import DesktopNav from '@/components/navigation/DesktopNav.vue';
import MobileNav from '@/components/navigation/MobileNav.vue';
import { useNavigation } from '@/components/navigation/useNavigation';
import { Button } from '@/components/ui/button';

const { entries, isHome, isActive, isCurrentLink } = useNavigation();
const { y } = useWindowScroll();

const isTransparent = computed(() => isHome.value && y.value < 40);
</script>

<template>
    <header class="fixed inset-x-0 top-0 z-40">
        <div
            class="absolute inset-0 -z-10 transition-[background-color,box-shadow,border-color] duration-300"
            :class="
                isTransparent
                    ? 'border-b border-transparent bg-gradient-to-b from-black/60 to-transparent'
                    : 'border-b border-white/8 bg-ink-950/92 shadow-lg shadow-black/20 backdrop-blur-md'
            "
            aria-hidden="true"
        />
        <div
            class="container-spp flex h-(--header-height) items-center justify-between gap-4"
        >
            <SiteLink
                href="/"
                class="shrink-0 rounded-md"
                aria-label="Servicios de Protección Profesional, ir al inicio"
            >
                <BrandLogo />
            </SiteLink>

            <div class="hidden lg:flex lg:items-center lg:gap-3">
                <DesktopNav
                    :entries="entries"
                    :is-active="isActive"
                    :is-current-link="isCurrentLink"
                />
                <Button as-child class="ml-2">
                    <SiteLink href="#cotizar">
                        <FileText />
                        Cotizar
                    </SiteLink>
                </Button>
            </div>

            <div class="lg:hidden">
                <MobileNav
                    :entries="entries"
                    :is-active="isActive"
                    :is-current-link="isCurrentLink"
                />
            </div>
        </div>
    </header>
</template>
