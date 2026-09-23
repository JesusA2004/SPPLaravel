<?php

namespace App\Support;

use Illuminate\Support\Arr;

/**
 * Catálogo de servicios del sitio. Concentra el contenido de las páginas
 * individuales y los resúmenes utilizados en la navegación y en Home.
 */
class ServiceCatalog
{
    private const OPERATIONAL_SUPERVISION = [
        [
            'title' => 'Supervisión presencial',
            'text' => 'La supervisión operativa para verificar que la prestación del servicio se proporcione de manera eficiente se realiza mediante supervisión física por parte de un supervisor.',
            'items' => [],
        ],
        [
            'title' => 'Supervisión a distancia',
            'text' => null,
            'items' => [
                'Monitoreo continuo vía radio y/o teléfono celular.',
                'Realizada las 24 horas del día.',
                'Involucra tanto al supervisor como a la central operativa de la organización.',
            ],
        ],
        [
            'title' => 'Colaboración con las autoridades',
            'text' => null,
            'items' => [
                'Coordinación permanente para apoyo en contingencias.',
                'Colaboración con autoridades de seguridad municipales y estatales.',
            ],
        ],
    ];

    /**
     * @return array<string, array<string, mixed>>
     */
    private static function definitions(): array
    {
        return [
            'guardias-de-seguridad' => [
                'name' => 'Guardias de Seguridad Intramuros',
                'navLabel' => 'Guardias de seguridad intramuros',
                'summary' => 'Proporcionamos servicios de guardias de seguridad intramuros para proteger su propiedad las 24 horas.',
                'icon' => '/images/iconos/guardias.webp',
                'cardImage' => ['src' => '/images/servicios/guardias/principal.webp', 'alt' => 'Equipo de guardias de seguridad intramuros de SPP uniformados', 'width' => 1047, 'height' => 848],
                'title' => 'Servicio de Guardias de Seguridad Intramuros',
                'introTitle' => 'Guardias de seguridad intramuros',
                'intro' => 'Nuestro personal cuenta con la capacidad y experiencia para el resguardo y vigilancia de las personas y bienes materiales dentro de la unidad donde se labora.',
                'heroImage' => ['src' => '/images/servicios/guardias/principal.webp', 'alt' => 'Equipo de guardias de seguridad intramuros de SPP uniformados', 'width' => 1047, 'height' => 848],
                'highlights' => [
                    ['title' => 'Vigilancia constante', 'text' => 'Personal capacitado en monitoreo continuo.', 'icon' => 'eye'],
                    ['title' => 'Respuesta inmediata', 'text' => 'Acciones rápidas ante cualquier situación.', 'icon' => 'zap'],
                    ['title' => 'Integridad y confianza', 'text' => 'Compromiso con la seguridad y profesionalismo.', 'icon' => 'shield-check'],
                ],
                'gallery' => [
                    'title' => 'Guardias en acción',
                    'items' => [
                        ['caption' => 'Guardias en sector comercial', 'src' => '/images/servicios/guardias/comercial.webp', 'alt' => 'Guardia de seguridad en una plaza comercial', 'width' => 1000, 'height' => 666],
                        ['caption' => 'Guardias en sector gubernamental', 'src' => '/images/servicios/guardias/gubernamental.webp', 'alt' => 'Guardias de seguridad en instalaciones gubernamentales', 'width' => 900, 'height' => 1200],
                        ['caption' => 'Guardias en eventos', 'src' => '/images/servicios/guardias/eventos.webp', 'alt' => 'Guardias de seguridad durante un evento', 'width' => 925, 'height' => 704],
                        ['caption' => 'Guardias en residencias', 'src' => '/images/servicios/guardias/residencial.webp', 'alt' => 'Guardia de seguridad en un acceso residencial', 'width' => 900, 'height' => 1200],
                    ],
                ],
                'support' => [
                    'title' => 'Supervisión operativa',
                    'cards' => self::OPERATIONAL_SUPERVISION,
                ],
                'quoteDescription' => 'Guardias de seguridad intramuros',
            ],

            'escolta' => [
                'name' => 'Escolta',
                'navLabel' => 'Escolta',
                'summary' => 'Brindamos servicios de escolta para personas o bienes de alto valor.',
                'icon' => '/images/iconos/escolta.webp',
                'cardImage' => ['src' => '/images/servicios/escolta/tarjeta.webp', 'alt' => 'Escolta profesional de SPP con uniforme táctico', 'width' => 1000, 'height' => 603],
                'title' => 'Servicio de Escoltas Profesionales',
                'introTitle' => 'Protección ejecutiva personalizada',
                'intro' => 'Contamos con un equipo de profesionales perfectamente capacitados para prestar el servicio de escolta y acompañamiento a cualquier parte de la República.',
                'heroImage' => ['src' => '/images/servicios/escolta/principal.webp', 'alt' => 'Escoltas profesionales junto a vehículos de protección', 'width' => 960, 'height' => 640],
                'highlights' => [
                    ['title' => 'Evaluación precisa', 'text' => 'Análisis detallado de riesgos para cada operación.', 'icon' => 'scan-search'],
                    ['title' => 'Protección móvil', 'text' => 'Escoltas altamente capacitados para protección en movimiento.', 'icon' => 'car'],
                    ['title' => 'Respuesta efectiva', 'text' => 'Acciones rápidas y coordinadas ante cualquier eventualidad.', 'icon' => 'zap'],
                ],
                'gallery' => [
                    'title' => 'Operaciones de protección',
                    'items' => [
                        ['caption' => 'Protección vehicular', 'src' => '/images/servicios/escolta/vehicular.webp', 'alt' => 'Escoltas brindando protección vehicular', 'width' => 1000, 'height' => 630],
                        ['caption' => 'Seguridad en eventos', 'src' => '/images/servicios/escolta/eventos.webp', 'alt' => 'Escoltas brindando seguridad en un evento', 'width' => 800, 'height' => 534],
                        ['caption' => 'Protección ejecutiva', 'src' => '/images/servicios/escolta/proteccion-ejecutiva.webp', 'alt' => 'Escoltas acompañando a un ejecutivo', 'width' => 1000, 'height' => 667],
                    ],
                ],
                'support' => [
                    'title' => 'Supervisión operativa',
                    'cards' => self::OPERATIONAL_SUPERVISION,
                ],
                'quoteDescription' => 'Protección personalizada y segura en todo momento',
            ],

            'cctv' => [
                'name' => 'Instalación de CCTV',
                'navLabel' => 'Instalación de Circuitos Cerrados de Televisión',
                'summary' => 'Instalación de sistemas de cámaras de vigilancia para mayor seguridad en su propiedad.',
                'icon' => '/images/iconos/cctv.webp',
                'cardImage' => ['src' => '/images/servicios/cctv/tarjeta.webp', 'alt' => 'Técnico instalando una cámara de videovigilancia', 'width' => 692, 'height' => 672],
                'title' => 'Instalación de Circuitos Cerrados de Televisión (CCTV)',
                'introTitle' => 'Servicio integral de videovigilancia CCTV',
                'intro' => 'Nuestro objetivo es mantener vigiladas las 24 horas del día diferentes áreas a resguardar. Este sistema permite la grabación de los acontecimientos ocurridos y sirve como evidencia de las anomalías que llegasen a ocurrir.',
                'heroImage' => ['src' => '/images/servicios/cctv/principal.webp', 'alt' => 'Cámara de circuito cerrado de televisión instalada', 'width' => 1129, 'height' => 755],
                'highlights' => [
                    ['title' => 'Monitoreo en tiempo real', 'text' => 'Supervisión continua las 24 horas del día con acceso remoto y almacenamiento seguro.', 'icon' => 'monitor'],
                    ['title' => 'Detección de movimiento', 'text' => 'Alertas automáticas ante cualquier actividad sospechosa, brindando una respuesta rápida.', 'icon' => 'bell-ring'],
                    ['title' => 'Integración inteligente', 'text' => 'Compatible con sistemas de alarma y control de acceso para mayor seguridad.', 'icon' => 'cpu'],
                ],
                'gallery' => [
                    'title' => 'Nuestras instalaciones CCTV',
                    'items' => [
                        ['caption' => 'Instalación comercial', 'src' => '/images/servicios/cctv/comercial.webp', 'alt' => 'Cámaras de videovigilancia en un centro comercial', 'width' => 1024, 'height' => 681],
                        ['caption' => 'Instalación residencial', 'src' => '/images/servicios/cctv/residencial.webp', 'alt' => 'Sistema de videovigilancia residencial', 'width' => 695, 'height' => 333],
                        ['caption' => 'Tecnología night vision', 'src' => '/images/servicios/cctv/night-vision.webp', 'alt' => 'Cámara con tecnología de visión nocturna', 'width' => 873, 'height' => 427],
                    ],
                ],
                'support' => [
                    'title' => 'Soporte y beneficios',
                    'cards' => [
                        [
                            'title' => 'Instalación y soporte',
                            'text' => 'Nuestro equipo especializado diseña la mejor estrategia de instalación y ofrece mantenimiento preventivo y correctivo para asegurar el funcionamiento ininterrumpido de tus sistemas.',
                            'items' => [],
                        ],
                        [
                            'title' => 'Beneficios',
                            'text' => 'Obtén asesoramiento personalizado, soluciones escalables y la integración de tecnologías emergentes, asegurando una inversión de alta calidad.',
                            'items' => [],
                        ],
                        [
                            'title' => 'Centro de monitoreo 24/7',
                            'text' => 'Contamos con un centro de monitoreo activo las 24 horas, gestionado por profesionales que responden de inmediato a cualquier incidente.',
                            'items' => [],
                        ],
                    ],
                ],
                'quoteDescription' => 'Servicio integral de videovigilancia CCTV',
            ],

            'cercas-electricas' => [
                'name' => 'Instalación de Cercas Eléctricas',
                'navLabel' => 'Instalación de Cercas Eléctricas y navajas',
                'summary' => 'Ofrecemos la instalación de cercas eléctricas y de navajas para máxima protección.',
                'icon' => '/images/iconos/cercas.webp',
                'cardImage' => ['src' => '/images/servicios/cercas/principal.webp', 'alt' => 'Técnico instalando una cerca eléctrica sobre un muro', 'width' => 822, 'height' => 906],
                'title' => 'Instalación Profesional de Cercas Electrificadas',
                'introTitle' => 'Protección perimetral inteligente',
                'intro' => 'Resguardar y proteger tu casa, edificio, empresa o local de posibles intrusos y/o delincuentes mediante la delimitación del perímetro por medio del tendido de alambres electrificados o alambres resistentes con navajas de lámina de acero galvanizada.',
                'heroImage' => ['src' => '/images/servicios/cercas/principal.webp', 'alt' => 'Técnico instalando una cerca eléctrica sobre un muro', 'width' => 822, 'height' => 906],
                'highlights' => [
                    ['title' => 'Energía óptima', 'text' => 'Suministro regulable para máxima eficiencia.', 'icon' => 'zap'],
                    ['title' => 'Sistema antimanipulación', 'text' => 'Protección avanzada contra intervenciones no autorizadas.', 'icon' => 'lock'],
                    ['title' => 'Resistencia total', 'text' => 'Diseñadas para soportar condiciones climáticas extremas.', 'icon' => 'cloud-lightning'],
                ],
                'gallery' => [
                    'title' => 'Proyectos realizados',
                    'items' => [
                        ['caption' => 'Instalación residencial', 'src' => '/images/servicios/cercas/residencial.webp', 'alt' => 'Cerca eléctrica instalada en una residencia', 'width' => 694, 'height' => 554],
                        ['caption' => 'Protección industrial', 'src' => '/images/servicios/cercas/industrial.webp', 'alt' => 'Cerca eléctrica en instalaciones industriales', 'width' => 1000, 'height' => 666],
                        ['caption' => 'Sistema con navajas', 'src' => '/images/servicios/cercas/navajas.webp', 'alt' => 'Sistema perimetral con alambre de navajas', 'width' => 373, 'height' => 207],
                    ],
                ],
                'support' => [
                    'title' => 'Supervisión operativa',
                    'cards' => self::OPERATIONAL_SUPERVISION,
                ],
                'quoteDescription' => 'Instalación profesional de cercas electrificadas',
            ],
        ];
    }

    /**
     * @return list<string>
     */
    public static function slugs(): array
    {
        return array_keys(self::definitions());
    }

    public static function exists(string $slug): bool
    {
        return array_key_exists($slug, self::definitions());
    }

    /**
     * Contenido completo de un servicio para su página individual.
     *
     * @return array<string, mixed>|null
     */
    public static function find(string $slug): ?array
    {
        $service = self::definitions()[$slug] ?? null;

        return $service === null ? null : self::withRoutingData($slug, $service);
    }

    /**
     * Resúmenes de todos los servicios (navegación, tarjetas de Home, etc.).
     *
     * @return list<array<string, mixed>>
     */
    public static function summaries(): array
    {
        return array_map(
            fn (string $slug, array $service) => self::withRoutingData($slug, Arr::only($service, [
                'name', 'navLabel', 'summary', 'icon', 'cardImage',
            ])),
            self::slugs(),
            self::definitions(),
        );
    }

    /**
     * @param  array<string, mixed>  $service
     * @return array<string, mixed>
     */
    private static function withRoutingData(string $slug, array $service): array
    {
        return [
            'slug' => $slug,
            'url' => route('services.show', $slug, false),
            ...$service,
        ];
    }
}
