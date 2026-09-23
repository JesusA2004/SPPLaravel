import type { Directive } from 'vue';
import type { Company, QuoteStatus, ServiceSummary } from '@/types/site';

declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            company: Company;
            services: ServiceSummary[];
            [key: string]: unknown;
        };
        flashDataType: {
            quote?: { status: QuoteStatus };
        };
    }
}

declare module 'vue' {
    interface GlobalDirectives {
        vReveal: Directive<HTMLElement, number | undefined>;
    }
}
