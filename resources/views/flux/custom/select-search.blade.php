@props([
    'options' => [],
    'label' => 'Pilih Opsi',
    'placeholder' => 'Cari...',
    'badge' => false // Tambahkan badge untuk Required
])

<div x-data="{ open: false, search: '', selected: '' }">
    <!-- Label -->
    <ui-label class="inline-flex items-center text-sm font-medium text-zinc-800 dark:text-white mb-2">
        {{ $label }}
        <span class="ms-1.5 text-zinc-800/70 text-xs bg-zinc-800/5 px-1.5 py-1 rounded-[4px] dark:bg-white/10 dark:text-zinc-300" aria-hidden="true">
            Required
        </span>
    </ui-label>

    <!-- Input Search -->
    <flux:input
        placeholder="{{ $placeholder }}"
        x-model="search"
        @click="open = !open"
    />
    <!-- Dropdown Options -->
    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border rounded-lg shadow-lg">
        <template x-if="search.length > 0">
            <div class="p-2 text-gray-500 italic">Menampilkan hasil untuk "<span x-text="search"></span>"</div>
        </template>

        @foreach($options as $key => $option)
            <div
                class="p-2 cursor-pointer hover:bg-gray-200"
                @click="selected = '{{ $key }}'; search = '{{ $option }}'; open = false;"
            >
                {{ $option }}
            </div>
        @endforeach

        @if(empty($options))
            <div class="p-2 text-gray-500 italic">Tidak ada hasil</div>
        @endif
    </div>
</div>
