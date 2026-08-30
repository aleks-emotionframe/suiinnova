<?php
/**
 * Schema.org JSON-LD — Baseline für alle Seiten.
 *
 * Ausgabeschema:
 * - Organization (immer, mit @id für Verweise)
 * - ProfessionalService/LocalBusiness (immer, verweist auf Organization)
 * - WebSite (immer)
 * - BreadcrumbList (nur wenn nicht Homepage)
 *
 * Alle Firmendaten kommen aus CMS-Settings damit sie zentral änderbar sind.
 */

$siteName    = setting('site_name', SITE_NAME);
$companyName = setting('company_name', $siteName);
$street      = setting('address_street', 'Talstrasse 31');
$cityLine    = setting('address_city', '8808 Pfäffikon');
$phone       = setting('phone', '+41 55 420 19 90');
$phoneClean  = preg_replace('/\s+/', '', $phone);
$email       = setting('contact_email', 'info@sui-innova.ch');
$logoUrl     = SITE_URL . '/assets/img/SUI-Innova_Logo.webp';
$founder     = setting('company_founder', 'Riad Ljatifi');
$vatId       = setting('company_vat_id', 'CHE-145.418.862');
$geoLat      = setting('geo_lat', '47.2011');
$geoLng      = setting('geo_lng', '8.7740');
$ogImage     = setting('og_image_url');

// Adresse in PLZ + Ort aufsplitten
$plz = ''; $ort = $cityLine;
if (preg_match('/^(\d{4,5})\s+(.+)$/', trim($cityLine), $m)) {
    $plz = $m[1];
    $ort = $m[2];
}

$isHomepage_local = !empty($isHomepage) || ($currentSlug ?? '') === 'startseite' || ($currentSlug ?? '') === '';
$orgId = rtrim(SITE_URL, '/') . '/#organization';
$siteId = rtrim(SITE_URL, '/') . '/#website';

// Graph aufbauen
$graph = [];

// 1) Organization — grundsätzliche Firmen-Identität
$organization = [
    '@type'    => 'Organization',
    '@id'      => $orgId,
    'name'     => $companyName,
    'url'      => rtrim(SITE_URL, '/') . '/',
    'logo'     => [
        '@type' => 'ImageObject',
        'url'   => $logoUrl,
    ],
    'email'    => $email,
    'telephone'=> $phoneClean,
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $street,
        'postalCode'      => $plz,
        'addressLocality' => $ort,
        'addressRegion'   => 'SZ',
        'addressCountry'  => 'CH',
    ],
];
if ($vatId) {
    $organization['vatID'] = $vatId;
}
if ($founder) {
    $organization['founder'] = [
        '@type' => 'Person',
        'name'  => $founder,
    ];
}
$graph[] = $organization;

// 2) LocalBusiness / ProfessionalService — für Google Maps & Local Pack
$localBusiness = [
    '@type'       => 'ProfessionalService',
    '@id'         => rtrim(SITE_URL, '/') . '/#localbusiness',
    'name'        => $companyName,
    'image'       => $ogImage ?: $logoUrl,
    'url'         => rtrim(SITE_URL, '/') . '/',
    'telephone'   => $phoneClean,
    'email'       => $email,
    'priceRange'  => '$$',
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $street,
        'postalCode'      => $plz,
        'addressLocality' => $ort,
        'addressRegion'   => 'SZ',
        'addressCountry'  => 'CH',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => (float) $geoLat,
        'longitude' => (float) $geoLng,
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name'  => 'Schweiz',
    ],
    'parentOrganization' => ['@id' => $orgId],
];
$graph[] = $localBusiness;

// 3) WebSite — grundlegende Site-Info
$graph[] = [
    '@type'     => 'WebSite',
    '@id'       => $siteId,
    'url'       => rtrim(SITE_URL, '/') . '/',
    'name'      => $siteName,
    'inLanguage'=> 'de-CH',
    'publisher' => ['@id' => $orgId],
];

// 4) BreadcrumbList — nur auf Unterseiten
if (!$isHomepage_local && !empty($currentSlug)) {
    $slug = $currentSlug;
    $title = $pageTitle ?? ucfirst($slug);
    $graph[] = [
        '@type'           => 'BreadcrumbList',
        '@id'             => $canonicalUrl . '#breadcrumb',
        'itemListElement' => [
            [
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Startseite',
                'item'     => rtrim(SITE_URL, '/') . '/',
            ],
            [
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => $title,
                'item'     => $canonicalUrl,
            ],
        ],
    ];
}

$jsonLd = [
    '@context' => 'https://schema.org',
    '@graph'   => $graph,
];

echo '<script type="application/ld+json">' . "\n";
echo json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo "\n" . '</script>' . "\n";
