<?php
/**
 * Section-Type-Definitionen
 *
 * Jeder Typ definiert seine Felder. Der Admin-Editor rendert daraus
 * automatisch das richtige Formular. Das Frontend-Template liest
 * die gespeicherten JSON-Daten.
 */

return [
    'info-banner' => [
        'label' => 'Info-Streifen',
        'icon'  => 'alert',
        'fields' => [
            'text'       => ['type' => 'text',     'label' => 'Text'],
            'link_text'  => ['type' => 'text',     'label' => 'Link-Text (optional)'],
            'link_url'   => ['type' => 'text',     'label' => 'Link (optional)'],
            'is_visible' => ['type' => 'checkbox', 'label' => 'Sichtbar'],
        ],
    ],

    'hero' => [
        'label' => 'Hero Banner',
        'icon'  => 'image',
        'fields' => [
            'heading'       => ['type' => 'text',     'label' => 'Überschrift'],
            'tagline'       => ['type' => 'text',     'label' => 'Tagline (unter Überschrift, kleiner)'],
            'subheading'    => ['type' => 'text',     'label' => 'Beschreibungstext'],
            'image_id'      => ['type' => 'media',    'label' => 'Hintergrundbild'],
            'button_text'   => ['type' => 'text',     'label' => 'Button 1 Text (rot)'],
            'button_url'    => ['type' => 'text',     'label' => 'Button 1 Link'],
            'button2_text'  => ['type' => 'text',     'label' => 'Button 2 Text (outline)'],
            'button2_url'   => ['type' => 'text',     'label' => 'Button 2 Link'],
            'overlay_opacity' => ['type' => 'select', 'label' => 'Overlay Stärke', 'options' => [
                '0.5' => 'Leicht',
                '0.6' => 'Mittel',
                '0.7' => 'Standard',
                '0.8' => 'Dunkel',
            ]],
        ],
    ],

    'services' => [
        'label' => 'Leistungen',
        'icon'  => 'wrench',
        'fields' => [
            'heading'  => ['type' => 'text',     'label' => 'Überschrift'],
            'subtitle' => ['type' => 'text',     'label' => 'Untertitel'],
            'items'    => ['type' => 'repeater', 'label' => 'Leistungen', 'fields' => [
                'image_id' => ['type' => 'media',    'label' => 'Hintergrundbild'],
                'icon'     => ['type' => 'text',     'label' => 'Icon (Lucide Name)'],
                'title'    => ['type' => 'text',     'label' => 'Titel'],
                'desc'     => ['type' => 'textarea', 'label' => 'Beschreibung'],
                'link'      => ['type' => 'text',     'label' => 'Link (optional)'],
                'link_text' => ['type' => 'text',     'label' => 'Link-Text (z.B. Jetzt entdecken)'],
            ]],
        ],
    ],

    'about-teaser' => [
        'label' => 'Über uns Teaser',
        'icon'  => 'users',
        'fields' => [
            'heading'     => ['type' => 'text',     'label' => 'Überschrift'],
            'body'        => ['type' => 'richtext', 'label' => 'Text'],
            'image_id'    => ['type' => 'media',    'label' => 'Bild'],
            'layout'      => ['type' => 'select',   'label' => 'Layout', 'options' => [
                'image-left'  => 'Bild links',
                'image-right' => 'Bild rechts',
            ]],
            'button_text' => ['type' => 'text',     'label' => 'Button Text'],
            'button_url'  => ['type' => 'text',     'label' => 'Button Link'],
        ],
    ],

    'references-grid' => [
        'label' => 'Referenzen',
        'icon'  => 'grid',
        'fields' => [
            'heading'  => ['type' => 'text',     'label' => 'Überschrift'],
            'subtitle' => ['type' => 'text',     'label' => 'Untertitel'],
            'items'    => ['type' => 'repeater', 'label' => 'Referenzen', 'fields' => [
                'image_id' => ['type' => 'media',    'label' => 'Bild'],
                'title'    => ['type' => 'text',     'label' => 'Projekt'],
                'desc'     => ['type' => 'textarea', 'label' => 'Beschreibung'],
                'location' => ['type' => 'text',     'label' => 'Art'],
                'year'     => ['type' => 'text',     'label' => 'Ort'],
            ]],
            'button_text' => ['type' => 'text', 'label' => 'Alle Referenzen Button'],
            'button_url'  => ['type' => 'text', 'label' => 'Button Link'],
        ],
    ],

    'cta-banner' => [
        'label' => 'Call to Action',
        'icon'  => 'megaphone',
        'fields' => [
            'heading'     => ['type' => 'text', 'label' => 'Überschrift'],
            'body'        => ['type' => 'text', 'label' => 'Text'],
            'button_text' => ['type' => 'text', 'label' => 'Button Text'],
            'button_url'  => ['type' => 'text', 'label' => 'Button Link'],
        ],
    ],

    'contact-form' => [
        'label' => 'Kontaktformular',
        'icon'  => 'mail',
        'fields' => [
            'heading'      => ['type' => 'text',     'label' => 'Überschrift'],
            'subtitle'     => ['type' => 'text',     'label' => 'Untertitel'],
            'email_target' => ['type' => 'text',     'label' => 'Empfänger E-Mail'],
            'show_address' => ['type' => 'checkbox', 'label' => 'Adresse anzeigen'],
            'show_phone'   => ['type' => 'checkbox', 'label' => 'Telefon anzeigen'],
            'show_map'     => ['type' => 'checkbox', 'label' => 'Karte anzeigen'],
        ],
    ],

    'parallax-image' => [
        'label' => 'Parallax Bildstreifen',
        'icon'  => 'image',
        'fields' => [
            'image_id' => ['type' => 'media', 'label' => 'Bild'],
            'height'   => ['type' => 'select', 'label' => 'Höhe', 'options' => [
                'small'  => 'Klein (400px)',
                'medium' => 'Mittel (600px)',
                'large'  => 'Gross (750px)',
            ]],
            'overlay_text' => ['type' => 'text', 'label' => 'Text auf Bild (optional)'],
        ],
    ],

    'text-block' => [
        'label' => 'Textblock',
        'icon'  => 'type',
        'fields' => [
            'heading'   => ['type' => 'text',     'label' => 'Überschrift'],
            'body'      => ['type' => 'richtext', 'label' => 'Inhalt'],
            'alignment' => ['type' => 'select',   'label' => 'Ausrichtung', 'options' => [
                'left'   => 'Links',
                'center' => 'Zentriert',
            ]],
        ],
    ],

    'image-text' => [
        'label' => 'Bild + Text',
        'icon'  => 'layout',
        'fields' => [
            'heading'  => ['type' => 'text',     'label' => 'Überschrift'],
            'body'     => ['type' => 'richtext', 'label' => 'Text'],
            'image_id' => ['type' => 'media',    'label' => 'Bild'],
            'layout'   => ['type' => 'select',   'label' => 'Layout', 'options' => [
                'image-left'  => 'Bild links',
                'image-right' => 'Bild rechts',
            ]],
        ],
    ],

    'team-grid' => [
        'label' => 'Team',
        'icon'  => 'users',
        'fields' => [
            'heading' => ['type' => 'text',     'label' => 'Überschrift'],
            'items'   => ['type' => 'repeater', 'label' => 'Teammitglieder', 'fields' => [
                'image_id' => ['type' => 'media', 'label' => 'Foto'],
                'name'     => ['type' => 'text',  'label' => 'Name'],
                'role'     => ['type' => 'text',  'label' => 'Position'],
            ]],
        ],
    ],

    'values' => [
        'label' => 'Werte / USPs',
        'icon'  => 'star',
        'fields' => [
            'heading' => ['type' => 'text',     'label' => 'Überschrift'],
            'items'   => ['type' => 'repeater', 'label' => 'Werte', 'fields' => [
                'icon'  => ['type' => 'text',     'label' => 'Icon (Lucide Name)'],
                'title' => ['type' => 'text',     'label' => 'Titel'],
                'desc'  => ['type' => 'textarea', 'label' => 'Beschreibung'],
            ]],
        ],
    ],

    'target-audience' => [
        'label' => 'Zielgruppen',
        'icon'  => 'users',
        'fields' => [
            'heading' => ['type' => 'text', 'label' => 'Überschrift'],
            'items'   => ['type' => 'repeater', 'label' => 'Zielgruppen', 'fields' => [
                'title' => ['type' => 'text',     'label' => 'Zielgruppe'],
                'desc'  => ['type' => 'textarea', 'label' => 'Beschreibung'],
            ]],
        ],
    ],

    'stats-bar' => [
        'label' => 'Zahlen & Fakten',
        'icon'  => 'hash',
        'fields' => [
            'style' => ['type' => 'select', 'label' => 'Stil', 'options' => [
                'light' => 'Hell',
                'dark'  => 'Dunkel',
            ]],
            'items' => ['type' => 'repeater', 'label' => 'Zahlen', 'fields' => [
                'number' => ['type' => 'text', 'label' => 'Zahl (z.B. 25+)'],
                'label'  => ['type' => 'text', 'label' => 'Bezeichnung'],
            ]],
        ],
    ],

    'gallery' => [
        'label' => 'Bildergalerie',
        'icon'  => 'images',
        'fields' => [
            'heading' => ['type' => 'text',     'label' => 'Überschrift'],
            'columns' => ['type' => 'select',   'label' => 'Spalten', 'options' => [
                '2' => '2 Spalten',
                '3' => '3 Spalten',
                '4' => '4 Spalten',
            ]],
            'images' => ['type' => 'repeater', 'label' => 'Bilder', 'fields' => [
                'image_id' => ['type' => 'media', 'label' => 'Bild'],
                'caption'  => ['type' => 'text',  'label' => 'Bildunterschrift'],
            ]],
        ],
    ],
];
