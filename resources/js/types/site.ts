export type ImageAsset = {
    src: string;
    alt: string;
    width: number;
    height: number;
};

export type Seo = {
    title: string;
    description: string;
    canonical: string;
    image: string;
    imageWidth: number;
    imageHeight: number;
    imageAlt: string;
    type: string;
    robots: string;
};

export type LinkItem = {
    label: string;
    url: string;
};

export type Company = {
    name: string;
    shortName: string;
    legalName: string;
    yearsOfExperience: number;
    description: string;
    about: string;
    qualityPolicy: string;
    authorization: string;
    contact: {
        address: string;
        city: string;
        phone: { label: string; href: string };
        email: string;
        whatsapp: {
            label: string;
            number: string;
            message: string;
            url: string;
        };
        mapsUrl: string;
        mapsEmbedUrl: string;
    };
    social: Array<LinkItem & { network: 'facebook' | 'instagram' }>;
    documents: LinkItem[];
};

export type ServiceSummary = {
    slug: string;
    url: string;
    name: string;
    navLabel: string;
    phrase: string;
    summary: string;
    icon: string;
    cardImage: ImageAsset;
};

export type ServiceHighlight = {
    title: string;
    text: string;
    icon: string;
};

export type ServiceSupportCard = {
    title: string;
    text: string | null;
    items: string[];
};

export type GalleryItem = ImageAsset & {
    caption: string;
};

export type Service = ServiceSummary & {
    title: string;
    overview: string[];
    audience: string[];
    coverage: string;
    introTitle: string;
    intro: string;
    heroImage: ImageAsset;
    highlights: ServiceHighlight[];
    gallery: { title: string; items: GalleryItem[] };
    support: { title: string; cards: ServiceSupportCard[] };
    quoteDescription: string;
};

export type Philosophy = {
    intro: string;
    mission: string[];
    vision: string[];
    values: string[];
};

export type Client = {
    name: string;
    logo: string;
    width: number;
    height: number;
};

export type QuoteStatus = 'success' | 'error' | 'throttled' | 'expired';

export type QuoteFields = {
    nombre: string;
    correo: string;
    telefono: string;
    empresa: string;
    descripcion: string;
};
