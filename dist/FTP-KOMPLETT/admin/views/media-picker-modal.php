<!-- Media Picker Modal (global, wird von Alpine gesteuert) -->
<div x-data="mediaPicker()" x-cloak
     x-show="isOpen"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 p-4"
     @keydown.escape.window="close()"
     id="media-picker-modal">

    <!-- Modal Box -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[85vh] flex flex-col"
         @click.outside="close()">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-medium uppercase tracking-wider text-gray-900">Bild auswählen</h3>
            <button @click="close()" class="text-gray-400 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Upload Bar -->
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
            <label class="admin-btn-primary text-xs h-8 px-4 cursor-pointer">
                Neues Bild hochladen
                <input type="file" class="hidden" accept="image/*" @change="uploadNew($event)">
            </label>
            <span x-show="uploading" x-cloak class="text-xs text-gray-500">Wird hochgeladen...</span>
        </div>

        <!-- Grid -->
        <div class="flex-1 overflow-y-auto p-4">
            <div x-show="loading" class="text-center py-8 text-sm text-gray-400">Lade Medien...</div>

            <div x-show="!loading" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-2">
                <template x-for="item in items" :key="item.id">
                    <div @click="select(item)"
                         class="aspect-square bg-gray-100 rounded overflow-hidden cursor-pointer border-2 transition-all duration-150"
                         :class="selectedId === item.id ? 'border-brand-accent ring-2 ring-brand-accent/20' : 'border-transparent hover:border-gray-300'">
                        <img :src="item.thumb_url" :alt="item.alt_text" class="w-full h-full object-cover">
                    </div>
                </template>
            </div>

            <div x-show="!loading && items.length === 0" class="text-center py-8 text-sm text-gray-400">
                Noch keine Medien vorhanden. Laden Sie ein Bild hoch.
            </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between px-5 py-3 border-t border-gray-200 bg-gray-50">
            <span class="text-xs text-gray-400" x-text="selectedId ? selectedItem?.original : 'Kein Bild ausgewählt'"></span>
            <div class="flex gap-2">
                <button @click="close()" class="admin-btn-secondary text-xs h-8 px-4">Abbrechen</button>
                <button @click="confirm()" :disabled="!selectedId" class="admin-btn-primary text-xs h-8 px-4" :class="{ 'opacity-40': !selectedId }">Auswählen</button>
            </div>
        </div>
    </div>
</div>
