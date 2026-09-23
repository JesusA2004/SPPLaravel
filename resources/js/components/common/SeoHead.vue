<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Seo } from '@/types';

defineProps<{
    seo: Seo;
}>();
</script>

<template>
    <Head :title="seo.fullTitle">
        <meta
            head-key="description"
            name="description"
            :content="seo.description"
        />
        <link head-key="canonical" rel="canonical" :href="seo.canonical" />
        <meta head-key="og:type" property="og:type" :content="seo.type" />
        <meta
            head-key="og:title"
            property="og:title"
            :content="seo.fullTitle"
        />
        <meta
            head-key="og:description"
            property="og:description"
            :content="seo.description"
        />
        <meta head-key="og:url" property="og:url" :content="seo.canonical" />
        <meta head-key="og:image" property="og:image" :content="seo.image" />
        <meta
            head-key="twitter:card"
            name="twitter:card"
            content="summary_large_image"
        />
    </Head>
</template>
