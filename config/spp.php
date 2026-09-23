<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Datos de la empresa
    |--------------------------------------------------------------------------
    |
    | Información corporativa que se muestra en el sitio (header, footer,
    | hero, SEO). Proviene del sitio anterior y es la única fuente de verdad
    | para estos datos en la nueva versión.
    |
    */

    'name' => 'Servicios de Protección Profesional',

    'short_name' => 'SPP',

    'legal_name' => 'Servicios de Protección Profesional S.A. de C.V.',

    'years_of_experience' => 20,

    'description' => 'Somos una empresa dedicada a la protección y vigilancia de bienes muebles e inmuebles, con más de 20 años de experiencia. Nuestra ventaja competitiva es generar la confianza en nuestros clientes a través de una excelente calidad en nuestros servicios.',

    'about' => 'Servicios de Protección Profesional S.A. de C.V. es una organización especializada en la prestación de servicios de seguridad privada, legalmente constituida, con Registro Federal de Contribuyentes SPP020301HV1 y Autorización de Funcionamiento No. 082, expedida por la Dirección General de Seguridad Privada, dependiente de la Comisión Estatal de Seguridad Pública del Gobierno del Estado de Morelos.',

    'quality_policy' => 'Hacer eficientes nuestras actividades con base en la identificación oportuna de las deficiencias observadas por nuestros clientes, aplicando una mejora continua en las mismas con la finalidad de alcanzar la calidad total y, en consecuencia, la satisfacción plena de nuestros clientes.',

    'contact' => [
        'address' => 'Av. Lomas del Tzompantle 200',
        'city' => 'Cuernavaca, Morelos',
        'locality' => 'Cuernavaca',
        'region' => 'Morelos',
        'country' => 'MX',
        // Coordenadas tomadas del mapa incrustado del sitio anterior.
        'geo' => ['latitude' => 18.924676, 'longitude' => -99.248801],
        'phone' => [
            'label' => '777 102 26 76',
            'href' => 'tel:+527771022676',
        ],
        'email' => 'spp.segpriv@gmail.com',
        'whatsapp' => [
            'label' => '777 298 00 92',
            'number' => '527772980092',
            'message' => 'Hola, me gustaría recibir información y una cotización de sus servicios de seguridad.',
        ],
        'maps_url' => 'https://maps.app.goo.gl/LnJZDmwcRwxpAj4n7',
        'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.533882676967!2d-99.24880068495027!3d18.924676287411236!2m3!1f0!2f0!3f0!3m2!1i250!2i150!4f13.1!3m3!1m2!1s0x85cdd0d8e2ed46a9%3A0xc9d6f76f9a7c6a34!2sAv.%20Lomas%20del%20Tzompantle%20200%2C%20Cuernavaca%2C%20Mor.!5e0!3m2!1ses-419!2smx!4v1670000000000',
    ],

    'social' => [
        ['network' => 'facebook', 'label' => 'Facebook', 'url' => 'https://www.facebook.com/share/1KF5JpFEp3/'],
        ['network' => 'instagram', 'label' => 'Instagram', 'url' => 'https://www.instagram.com/spp_morelos/'],
    ],

    'rfc' => 'SPP020301HV1',

    'authorization' => 'Autorización de Funcionamiento No. 082 de la Dirección General de Seguridad Privada del Estado de Morelos',

    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    |
    | `updated_at` es la fecha de la última actualización del contenido y se
    | publica como <lastmod> en el sitemap. Actualízala al cambiar textos.
    |
    */

    'seo' => [
        'updated_at' => '2026-09-23',
        'home_title' => 'SPP Seguridad Privada en Cuernavaca, Morelos | Servicios de Protección Profesional',
        'home_description' => 'SPP, empresa de seguridad privada en Cuernavaca, Morelos, con más de 20 años de experiencia. Guardias intramuros, escoltas, CCTV y cercas eléctricas.',
        'services_title' => 'Servicios de Seguridad Privada en Cuernavaca y Morelos | SPP',
        'services_description' => 'Guardias intramuros, escoltas profesionales, instalación de CCTV y cercas eléctricas y de navajas. Servicios de vigilancia de SPP en Cuernavaca, Morelos.',
    ],

    'documents' => [
        ['label' => 'Aviso de Registro', 'url' => '/docs/aviso-de-registro.pdf'],
        ['label' => 'Licencia de Funcionamiento', 'url' => '/docs/licencia-de-funcionamiento.pdf'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filosofía empresarial
    |--------------------------------------------------------------------------
    */

    'philosophy' => [
        'intro' => 'Nuestra filosofía, que marca la personalidad y la actuación de la organización y que nos diferencia de las demás, es la siguiente:',
        'mission' => [
            'Nos concentraremos en la prestación de servicios de seguridad privada para satisfacer las necesidades de nuestros clientes con base en la calidad, precios y variedad de nuestros servicios.',
            'Realizaremos nuestras actividades con responsabilidad y eficiencia a efecto de obtener resultados que mantengan el equilibrio con nuestro crecimiento a largo plazo, que beneficien a las personas integrantes de la organización, logrando con ello cumplir nuestro compromiso con la sociedad.',
        ],
        'vision' => [
            'Servicios de Protección Profesional S.A. de C.V. será una organización reconocida por el personal colaborador, competidores, clientes y público en general. Seremos la organización líder en la prestación de servicios de seguridad privada.',
            'Nuestra premisa será la innovación, creatividad, competitividad y el trabajo en equipo de nuestro personal colaborador, buscando en todo momento la mejora continua en nuestras actividades para alcanzar la calidad total, así como nuestra capacidad para anticipar y responder debidamente a los cambios del entorno y para crear oportunidades.',
        ],
        'values' => [
            'Disciplina',
            'Respeto',
            'Profesionalismo',
            'Responsabilidad',
            'Vocación de servicio',
            'Honestidad',
            'Trabajo en equipo',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Clientes distinguidos
    |--------------------------------------------------------------------------
    */

    'clients_intro' => 'En Servicios de Protección Profesional nos enorgullece contar con la confianza de empresas y organizaciones que han depositado su seguridad en nuestras manos. Nuestro compromiso es brindar protección con los más altos estándares de calidad y profesionalismo.',

    'clients' => [
        ['name' => 'Comisión Federal de Electricidad (CFE)', 'logo' => '/images/clientes/cfe.webp', 'width' => 480, 'height' => 174],
        ['name' => 'Tribunal de Justicia Administrativa del Estado de Morelos (TJA)', 'logo' => '/images/clientes/tja.webp', 'width' => 270, 'height' => 200],
        ['name' => 'PROCIVAC', 'logo' => '/images/clientes/procivac.webp', 'width' => 360, 'height' => 418],
        ['name' => 'Instituto Morelense de Procesos Electorales y Participación Ciudadana (IMPEPAC)', 'logo' => '/images/clientes/impepac.webp', 'width' => 320, 'height' => 240],
        ['name' => 'Floraplant', 'logo' => '/images/clientes/floraplant.webp', 'width' => 360, 'height' => 353],
        ['name' => 'Floramundo', 'logo' => '/images/clientes/floramundo.webp', 'width' => 360, 'height' => 350],
        ['name' => 'Doster, Fundación para la protección del ambiente', 'logo' => '/images/clientes/doster.webp', 'width' => 480, 'height' => 334],
        ['name' => 'Invest Pro', 'logo' => '/images/clientes/invest.webp', 'width' => 480, 'height' => 266],
    ],

    /*
    |--------------------------------------------------------------------------
    | Formulario de cotización
    |--------------------------------------------------------------------------
    |
    | Dirección que recibe las solicitudes enviadas desde el sitio y número
    | máximo de envíos por minuto permitido para cada dirección IP.
    |
    */

    'quote' => [
        'recipient' => env('SPP_QUOTE_RECIPIENT', 'spp.segpriv@gmail.com'),
        'max_per_minute' => (int) env('SPP_QUOTE_MAX_PER_MINUTE', 3),
        'max_per_day' => (int) env('SPP_QUOTE_MAX_PER_DAY', 20),
    ],

];
