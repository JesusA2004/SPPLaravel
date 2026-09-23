<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { FileText, Mail, MapPin, Navigation, Phone } from '@lucide/vue';
import BrandIcon from '@/components/common/BrandIcon.vue';
import SiteLink from '@/components/common/SiteLink.vue';
import { Button } from '@/components/ui/button';
import { quickLinks } from '@/lib/navigation';

const page = usePage();
const company = page.props.company;
const services = page.props.services;
const year = new Date().getFullYear();
</script>

<template>
    <footer
        id="contacto"
        aria-labelledby="footer-title"
        class="on-dark relative bg-ink-950 text-white/70"
    >
        <div
            class="h-1 bg-gradient-to-r from-transparent via-gold-500 to-transparent opacity-60"
            aria-hidden="true"
        />

        <div class="container-spp py-16 lg:py-20">
            <div
                class="flex flex-col gap-6 border-b border-white/10 pb-10 md:flex-row md:items-center md:justify-between"
            >
                <div class="flex items-center gap-4">
                    <img
                        src="/images/marca/logo.webp"
                        alt=""
                        width="347"
                        height="360"
                        loading="lazy"
                        class="h-16 w-auto"
                    />
                    <div>
                        <h2
                            id="footer-title"
                            class="text-xl font-semibold text-white sm:text-2xl"
                        >
                            {{ company.name }}
                        </h2>
                        <p class="text-sm text-gold-500">
                            Seguridad privada en {{ company.contact.city }} ·
                            más de {{ company.yearsOfExperience }} años de
                            experiencia
                        </p>
                    </div>
                </div>
                <Button as-child size="lg" class="self-start md:self-auto">
                    <SiteLink href="#cotizar">
                        <FileText />
                        Solicitar cotización
                    </SiteLink>
                </Button>
            </div>

            <div
                class="grid gap-12 pt-12 sm:grid-cols-2 lg:grid-cols-12 lg:gap-10"
            >
                <div class="space-y-8 lg:col-span-4">
                    <div>
                        <h3 class="footer-heading">¿Quiénes somos?</h3>
                        <p class="text-sm leading-relaxed">
                            {{ company.about }}
                        </p>
                    </div>
                    <div>
                        <h3 class="footer-heading">Política de calidad</h3>
                        <p class="text-sm leading-relaxed">
                            {{ company.qualityPolicy }}
                        </p>
                    </div>
                </div>

                <nav aria-label="Accesos rápidos" class="lg:col-span-2">
                    <h3 class="footer-heading">Accesos rápidos</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li v-for="link in quickLinks" :key="link.href">
                            <SiteLink :href="link.href" class="footer-link">
                                {{ link.label }}
                            </SiteLink>
                        </li>
                    </ul>
                </nav>

                <div class="space-y-8 lg:col-span-3">
                    <nav aria-label="Servicios">
                        <h3 class="footer-heading">Servicios</h3>
                        <ul class="space-y-2.5 text-sm">
                            <li v-for="service in services" :key="service.slug">
                                <SiteLink
                                    :href="service.url"
                                    class="footer-link"
                                >
                                    {{ service.navLabel }}
                                </SiteLink>
                            </li>
                        </ul>
                    </nav>
                    <div>
                        <h3 class="footer-heading">Documentos oficiales</h3>
                        <ul class="space-y-2">
                            <li
                                v-for="document in company.documents"
                                :key="document.url"
                            >
                                <a
                                    :href="document.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group flex items-center gap-3 rounded-lg border border-white/10 px-3 py-2.5 text-sm transition-colors hover:border-gold-500/50 hover:text-white"
                                >
                                    <FileText
                                        class="size-5 shrink-0 text-gold-500"
                                        aria-hidden="true"
                                    />
                                    <span class="flex-1">{{
                                        document.label
                                    }}</span>
                                    <span
                                        class="text-[0.7rem] font-semibold text-white/40 group-hover:text-gold-400"
                                    >
                                        PDF
                                    </span>
                                    <span class="sr-only">
                                        (se abre en una nueva pestaña)
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-8 sm:col-span-2 lg:col-span-3">
                    <div>
                        <h3 class="footer-heading">Contacto</h3>
                        <address class="space-y-3 text-sm not-italic">
                            <p>
                                <a
                                    :href="company.contact.mapsUrl"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="footer-link flex gap-3"
                                >
                                    <MapPin
                                        class="mt-0.5 size-4 shrink-0 text-gold-500"
                                        aria-hidden="true"
                                    />
                                    <span>
                                        {{ company.contact.address }}<br />
                                        {{ company.contact.city }}
                                        <span class="sr-only">
                                            (abrir en Google Maps)
                                        </span>
                                    </span>
                                </a>
                            </p>
                            <p>
                                <a
                                    :href="company.contact.phone.href"
                                    class="footer-link flex gap-3"
                                >
                                    <Phone
                                        class="mt-0.5 size-4 shrink-0 text-gold-500"
                                        aria-hidden="true"
                                    />
                                    {{ company.contact.phone.label }}
                                </a>
                            </p>
                            <p>
                                <a
                                    :href="`mailto:${company.contact.email}`"
                                    class="footer-link flex gap-3 break-all"
                                >
                                    <Mail
                                        class="mt-0.5 size-4 shrink-0 text-gold-500"
                                        aria-hidden="true"
                                    />
                                    {{ company.contact.email }}
                                </a>
                            </p>
                        </address>
                    </div>

                    <div>
                        <h3 class="footer-heading">Síguenos</h3>
                        <ul class="flex gap-2.5">
                            <li>
                                <a
                                    :href="company.contact.whatsapp.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                    aria-label="WhatsApp"
                                >
                                    <BrandIcon
                                        network="whatsapp"
                                        class="size-5"
                                    />
                                </a>
                            </li>
                            <li
                                v-for="social in company.social"
                                :key="social.network"
                            >
                                <a
                                    :href="social.url"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                    :aria-label="social.label"
                                >
                                    <BrandIcon
                                        :network="social.network"
                                        class="size-5"
                                    />
                                </a>
                            </li>
                            <li>
                                <a
                                    :href="`mailto:${company.contact.email}`"
                                    class="social-link"
                                    aria-label="Correo electrónico"
                                >
                                    <Mail class="size-5" />
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="footer-heading">Mapa</h3>
                        <div
                            class="aspect-[16/9] overflow-hidden rounded-lg border border-white/10 bg-ink-900"
                        >
                            <iframe
                                :src="company.contact.mapsEmbedUrl"
                                title="Ubicación de Servicios de Protección Profesional en Google Maps"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="size-full border-0 grayscale-[35%]"
                            />
                        </div>
                        <Button as-child variant="light" size="sm" class="mt-3">
                            <a
                                :href="company.contact.mapsUrl"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <Navigation />
                                Ver mapa
                            </a>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div
                class="container-spp flex flex-col gap-2 py-6 pb-24 text-xs text-white/50 sm:flex-row sm:items-center sm:justify-between sm:pb-6"
            >
                <p>
                    © {{ year }} {{ company.name }}. Todos los derechos
                    reservados.
                </p>
                <p>{{ company.legalName }}</p>
            </div>
        </div>
    </footer>
</template>

<style scoped>
@reference '../../../css/app.css';

.footer-heading {
    @apply mb-4 font-display text-sm font-semibold tracking-wider text-white uppercase;
}

.footer-link {
    @apply rounded-sm decoration-gold-500/60 underline-offset-4 transition-colors duration-150 hover:text-gold-400 hover:underline;
}

.social-link {
    @apply flex size-11 items-center justify-center rounded-full border border-white/15 text-white/80 transition-all hover:-translate-y-0.5 hover:border-gold-500 hover:bg-gold-500 hover:text-ink-950;
}
</style>
