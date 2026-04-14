# Deployment auf Hostpoint (Standard Hosting)

## Voraussetzungen

- Hostpoint Standard Webhosting (kein Managed Flex nötig)
- PHP 8.1 oder höher
- MySQL 5.7+ oder MariaDB 10.3+
- Eigene Domain (z.B. suiinnova.ch)

## Schritt-für-Schritt Anleitung

### 1. Datenbank erstellen

1. Im Hostpoint Control Panel einloggen
2. **Datenbanken** → **MySQL** → **Neue Datenbank erstellen**
3. Datenbank-Name, Benutzer und Passwort notieren

### 2. Dateien hochladen

1. Per FTP (z.B. FileZilla) oder Hostpoint File Manager verbinden
2. **Alle Dateien** in das Hauptverzeichnis (`/www/` oder `/public_html/`) hochladen:

```
/www/
├── public/          ← Inhalt von public/ hierhin ODER als Unterordner
│   ├── .htaccess
│   ├── index.php
│   ├── install.php
│   └── assets/
├── app/
├── database/
└── CLAUDE.md (optional, kann gelöscht werden)
```

### 3. Document Root konfigurieren

**Option A** (empfohlen): Im Hostpoint Control Panel den Document Root auf den `/public/` Ordner setzen.

**Option B**: Falls das nicht geht, eine `.htaccess` im Root-Verzeichnis erstellen:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 4. Installation durchführen

1. Browser öffnen: `https://ihredomain.ch/install.php`
2. Datenbank-Zugangsdaten eingeben (von Schritt 1)
3. Admin-Benutzername, E-Mail und Passwort festlegen
4. **Installation starten** klicken

### 5. Sicherheit

Nach erfolgreicher Installation:

1. **install.php LÖSCHEN!** (Sehr wichtig!)
2. In `app/config.php` prüfen:
   - `APP_DEBUG` auf `false` setzen
   - Datenbank-Zugangsdaten sind korrekt eingetragen
3. HTTPS aktivieren:
   - In `public/.htaccess` die HTTPS-Redirect-Zeilen einkommentieren
4. Uploads-Ordner erstellen (falls nötig):
   - `public/uploads/` mit Schreibrechten (755)

### 6. Admin-Login

- URL: `https://ihredomain.ch/admin`
- Mit den in Schritt 4 gewählten Zugangsdaten einloggen
- **Passwort nach dem ersten Login ändern!**

## Konfiguration

### E-Mail (Kontaktformular)

Das Kontaktformular nutzt PHP `mail()`. Bei Hostpoint funktioniert das standardmässig.
Empfänger-Adresse unter **Admin → Einstellungen → Kontaktformular E-Mail** ändern.

### HTTPS erzwingen

In `public/.htaccess` die auskommentierten Zeilen aktivieren:

```apache
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## Struktur

```
app/                    PHP-Anwendung (Controller, Views, Models)
├── config.php          Konfiguration (DB-Zugangsdaten)
├── bootstrap.php       Anwendungsstart
├── Database.php        Datenbankverbindung
├── Auth.php            Authentifizierung
├── Router.php          URL-Routing
├── helpers.php         Hilfsfunktionen
├── controllers/        Controller-Klassen
├── models/             (reserviert für Erweiterungen)
└── views/              Templates
    ├── layout/         Header, Footer
    ├── pages/          Seitenvorlagen
    └── admin/          CMS-Verwaltung

public/                 Webroot (Document Root)
├── .htaccess           URL-Rewriting & Sicherheit
├── index.php           Front Controller
└── assets/             Statische Dateien
    ├── css/
    ├── js/
    └── img/

database/
└── schema.sql          Datenbankschema
```

## CMS-Funktionen

- **Seiten verwalten**: Titel, Meta-Beschreibung, Sichtbarkeit, Navigation
- **Inhaltsblöcke**: Text, Bilder, Links pro Seite
- **Referenzen**: Projekte mit Bild, Beschreibung, Kategorie
- **Kontaktnachrichten**: Alle Anfragen einsehen und beantworten
- **Einstellungen**: Firmenname, Kontaktdaten, Footer
- **Passwort ändern**: Admin-Passwort sicher aktualisieren

## Troubleshooting

| Problem | Lösung |
|---------|--------|
| Weisse Seite | In `app/config.php`: `APP_DEBUG` auf `true` setzen |
| 500 Error | `.htaccess` prüfen, `mod_rewrite` muss aktiv sein |
| CSS/JS laden nicht | Document Root prüfen, muss auf `/public/` zeigen |
| Bilder-Upload fehlt | `public/uploads/` erstellen, Rechte 755 setzen |
| Mail kommt nicht an | Hostpoint SPF/DKIM prüfen, Spam-Ordner checken |
