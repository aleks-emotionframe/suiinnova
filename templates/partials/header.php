<?php
/**
 * Header / Navigation
 *
 * Transparent auf der Startseite (über dem Hero).
 * Wird weiss beim Scrollen. Auf Unterseiten immer weiss.
 */

$logoUrl = setting('logo_url', asset('img/SUI-Innova_Logo.webp'));
$logoWhiteUrl = asset('img/SUI-Innova_Logo_white.webp');
$isHomepage = !empty($isHomepage);
?>

<!-- Header -->
<header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    x-data="headerScroll(<?= $isHomepage ? 'true' : 'false' ?>)"
    :class="scrolled ? 'bg-white border-b border-gray-200/60 shadow-sm' : '<?= $isHomepage ? 'bg-transparent' : 'bg-white border-b border-gray-200/60' ?>'"
>
    <div class="max-w-container-wide mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between h-16 md:h-[4.25rem]">

            <!-- Logo -->
            <a href="<?= url() ?>" class="flex-shrink-0">
                <?php if ($isHomepage): ?>
                    <!-- Weisses Logo (transparent) -->
                    <img
                        x-show="!scrolled"
                        src="<?= e($logoWhiteUrl) ?>"
                        alt="<?= e(setting('site_name', SITE_NAME)) ?>"
                        class="h-8 md:h-10 w-auto"
                    >
                    <!-- Normales Logo (scrolled) -->
                    <img
                        x-show="scrolled"
                        x-cloak
                        src="<?= e($logoUrl) ?>"
                        alt="<?= e(setting('site_name', SITE_NAME)) ?>"
                        class="h-8 md:h-10 w-auto"
                    >
                <?php else: ?>
                    <img
                        src="<?= e($logoUrl) ?>"
                        alt="<?= e(setting('site_name', SITE_NAME)) ?>"
                        class="h-8 md:h-10 w-auto"
                    >
                <?php endif; ?>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                <?php foreach ($navigation as $item): ?>
                    <?php
                    $href = $item['url'] ?: url($item['page_slug'] ?? '');
                    $isActive = isset($currentSlug) && ($item['page_slug'] ?? '') === $currentSlug;
                    ?>
                    <a
                        href="<?= e($href) ?>"
                        class="relative text-sm font-medium uppercase tracking-wider py-2 transition-colors duration-300"
                        :class="scrolled
                            ? '<?= $isActive ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900' ?>'
                            : '<?= $isHomepage ? ($isActive ? 'text-white' : 'text-white/80 hover:text-white') : ($isActive ? 'text-gray-900' : 'text-gray-600 hover:text-gray-900') ?>'"
                    >
                        <?= e($item['label']) ?>
                        <?php if ($isActive): ?>
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-accent"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- CTA Button (Desktop) -->
            <div class="hidden md:flex items-center">
                <a href="<?= url('kontakt') ?>"
                   class="inline-flex items-center h-10 px-6 rounded-md text-sm font-medium uppercase tracking-wider transition-all duration-300"
                   :class="scrolled
                       ? 'bg-gray-900 text-white hover:bg-gray-700'
                       : '<?= $isHomepage ? 'bg-white text-gray-900 hover:bg-white/90' : 'bg-gray-900 text-white hover:bg-gray-700' ?>'"
                >
                    Kontakt
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden flex items-center justify-center w-10 h-10 transition-colors duration-200"
                :class="scrolled ? 'text-gray-900 hover:bg-gray-100' : '<?= $isHomepage ? 'text-white hover:bg-white/10' : 'text-gray-900 hover:bg-gray-100' ?>'"
                :aria-expanded="mobileMenuOpen"
                aria-label="Menu"
            >
                <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (Off-Canvas) -->
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="mobileMenuOpen = false"
        class="md:hidden fixed inset-0 top-16 bg-black/30 z-40"
        x-cloak
    >
        <nav
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute top-0 right-0 w-72 h-full bg-white shadow-lg"
        >
            <div class="flex flex-col py-6">
                <?php foreach ($navigation as $item): ?>
                    <?php
                    $href = $item['url'] ?: url($item['page_slug'] ?? '');
                    $isActive = isset($currentSlug) && ($item['page_slug'] ?? '') === $currentSlug;
                    ?>
                    <a
                        href="<?= e($href) ?>"
                        @click="mobileMenuOpen = false"
                        class="px-6 py-3 text-sm font-medium uppercase tracking-wider transition-colors duration-200
                               <?= $isActive
                                   ? 'text-gray-900 border-l-2 border-brand-accent bg-gray-50'
                                   : 'text-gray-600 border-l-2 border-transparent hover:text-gray-900 hover:bg-gray-50' ?>"
                    >
                        <?= e($item['label']) ?>
                    </a>
                <?php endforeach; ?>

                <div class="px-6 pt-6 mt-4 border-t border-gray-200">
                    <a href="<?= url('kontakt') ?>" @click="mobileMenuOpen = false" class="flex items-center justify-center h-10 bg-gray-900 text-white text-sm font-medium uppercase tracking-wider hover:bg-gray-700 transition-colors duration-200">
                        Kontakt
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Spacer: nur auf Unterseiten (auf Homepage liegt Hero hinter transparentem Header) -->
<?php if (!$isHomepage): ?>
    <div class="h-16 md:h-[4.25rem]"></div>
<?php endif; ?>
