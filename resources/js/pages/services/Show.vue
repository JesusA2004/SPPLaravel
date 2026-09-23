<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { ref } from 'vue';
import PageHeader from '@/components/common/PageHeader.vue';
import SeoHead from '@/components/common/SeoHead.vue';
import QuoteCta from '@/components/contact/QuoteCta.vue';
import RelatedServices from '@/components/services/RelatedServices.vue';
import ServiceGallery from '@/components/services/ServiceGallery.vue';
import ServiceIntro from '@/components/services/ServiceIntro.vue';
import ServiceOverview from '@/components/services/ServiceOverview.vue';
import ServiceSupport from '@/components/services/ServiceSupport.vue';
import type { Seo, Service } from '@/types';

defineProps<{
    seo: Seo;
    service: Service;
}>();

const quoteOpen = ref(false);
</script>

<template>
    <SeoHead :seo="seo" />
    <PageHeader
        :title="service.title"
        :description="service.summary"
        :breadcrumbs="[
            { label: 'Servicios', url: '/servicios' },
            { label: service.name, url: service.url },
        ]"
        :image="service.heroImage.src"
    >
        <Link
            href="/servicios"
            class="group mt-8 inline-flex items-center gap-2 rounded-md text-sm font-medium text-gold-400 transition-colors duration-150 hover:text-gold-300"
        >
            <ArrowLeft
                class="size-4 transition-transform group-hover:-translate-x-0.5"
                aria-hidden="true"
            />
            Ver todos los servicios
        </Link>
    </PageHeader>

    <ServiceIntro :service="service" @quote="quoteOpen = true" />
    <ServiceOverview :service="service" />
    <ServiceGallery :gallery="service.gallery" />
    <ServiceSupport :support="service.support" />
    <QuoteCta
        v-model:dialog-open="quoteOpen"
        :service-name="service.phrase"
        :prefill="service.quoteDescription"
    />
    <RelatedServices :current-slug="service.slug" />
</template>
