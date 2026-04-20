<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminView ?? 'Dashboard') ?> — Admin CMS</title>
    <link rel="preload" href="<?= asset('fonts/Inter-Regular.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= asset('fonts/Inter-Medium.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <script src="<?= asset('js/alpine.min.js') ?>" defer></script>
</head>

<body class="font-sans bg-gray-50 antialiased" x-data="{ sidebarOpen: true, mobileMenu: false }">

    <!-- Sidebar -->
    <aside class="admin-sidebar" :class="{ '-translate-x-full md:translate-x-0': !mobileMenu }" x-cloak>
        <!-- Logo -->
        <div class="px-5 py-5 border-b border-white/10">
            <a href="<?= url('admin') ?>">
                <img src="<?= asset('img/SUI-Innova_Logo.webp') ?>" alt="SUI Innova" class="h-7 brightness-0 invert">
            </a>
            <p class="text-[10px] uppercase tracking-widest text-gray-500 mt-1.5">Content Management</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-4 space-y-0.5">
            <?php
            $navItems = [
                ['dashboard', 'Dashboard', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['pages', 'Seiten', 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                ['media', 'Medien', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['seo', 'SEO', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                ['settings', 'Einstellungen', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                ['contacts', 'Kontaktanfragen', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['applications', 'Bewerbungen', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ];

            $unreadCount = 0;
            $unreadApps = 0;
            try {
                $unreadCount = (int) $db->fetchColumn("SELECT COUNT(*) FROM contacts WHERE is_read = 0");
                $unreadApps  = (int) $db->fetchColumn("SELECT COUNT(*) FROM applications WHERE is_read = 0");
            } catch (Exception $e) {}
            ?>

            <?php foreach ($navItems as [$route, $label, $iconPath]): ?>
                <?php $isActive = ($adminView === $route); ?>
                <a href="<?= url('admin/' . ($route === 'dashboard' ? '' : $route)) ?>"
                   class="admin-sidebar-link <?= $isActive ? 'active' : '' ?>">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $iconPath ?>"/>
                    </svg>
                    <span><?= $label ?></span>

                    <?php if ($route === 'contacts' && $unreadCount > 0): ?>
                        <span class="ml-auto bg-brand-accent text-white text-[10px] font-bold px-1.5 py-0.5 min-w-[1.25rem] text-center">
                            <?= $unreadCount ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($route === 'applications' && $unreadApps > 0): ?>
                        <span class="ml-auto bg-brand-accent text-white text-[10px] font-bold px-1.5 py-0.5 min-w-[1.25rem] text-center">
                            <?= $unreadApps ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Footer -->
        <div class="px-5 py-4 border-t border-white/10">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500"><?= e(adminUsername()) ?></span>
                <a href="<?= url('admin/logout') ?>" class="text-xs text-gray-500 hover:text-white transition-colors duration-200">
                    Abmelden
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <div class="admin-header">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-sm font-medium uppercase tracking-wider text-gray-900">
                    <?php echo match($adminView) {
                        'dashboard'    => 'Dashboard',
                        'pages'        => 'Seiten',
                        'page-editor'  => 'Seite bearbeiten',
                        'media'        => 'Medien',
                        'seo'          => 'SEO & Suchmaschinen',
                        'settings'     => 'Einstellungen',
                        'contacts'     => 'Kontaktanfragen',
                        'applications' => 'Bewerbungen',
                        default        => 'Admin',
                    }; ?>
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?= url() ?>" target="_blank" class="text-xs text-gray-500 hover:text-gray-900 transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Website anzeigen
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-6 md:p-8">
            <?php
            // Flash Messages
            $flash = getFlash();
            if ($flash): ?>
                <div x-data="{ show: true }" x-show="show"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition
                     class="mb-6 px-4 py-3 text-sm font-medium
                            <?= $flash['type'] === 'success' ? 'bg-gray-900 text-white' : 'bg-brand-accent text-white' ?>">
                    <?= e($flash['message']) ?>
                </div>
            <?php endif; ?>

            <?php include $viewFile; ?>
        </div>
    </main>

    <!-- Global CSRF Token -->
    <script>const CSRF_TOKEN = '<?= e(csrfToken()) ?>';</script>

    <!-- Media Picker Modal -->
    <?php include BASE_PATH . '/admin/views/media-picker-modal.php'; ?>

    <!-- SortableJS + Admin JS -->
    <script src="<?= asset('js/sortable.min.js') ?>"></script>
    <script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>
