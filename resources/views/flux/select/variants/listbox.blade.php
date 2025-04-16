@props([
    'name' => $attributes->whereStartsWith('wire:model')->first(),
    'options' => [],
    'placeholder' => 'Pilih...',
    'invalid' => null,
    'selectedData' => null,
    'disabled' => null
])

@php
    $invalid ??= ($name && $errors->has($name));
    $selectedLabel = collect($options)->firstWhere('id', $selectedData)?->name ?? null;
@endphp
<div {{ $attributes->class('relative w-full') }}
    x-data="{
        open: false,
        search: '',
        selected: @js($selectedData ? ['value' => $selectedData, 'label' => $selectedLabel] : null),
        disabled: @js($disabled)
    }"
    class="relative"
    x-init="@this.on('resetDropdown', () => { selected = null; search = ''; })"
>
    <button :disabled="disabled" type="button" @click="open = !open"
        class="w-full py-2 border px-4 text-sm text-left bg-white rounded-lg dark:bg-white/10 dark:border-white/10"
        :class="selected ? 'text-black dark:text-white' : 'text-gray-400'">
        <span x-text="selected ? selected.label : '{{ $placeholder }}'"></span>
    </button>
    <div x-show="open" x-cloak @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-white border rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-600">
        <div class="p-2 border-b dark:border-gray-700">
            <flux:input icon="magnifying-glass" x-model="search" placeholder="Pencarian..." wire:model.live="search" size="sm" />
        </div>
        <ul class="max-h-48 overflow-y-auto">
            @foreach($options as $value => $label)
                <li @click="selected = { value: '{{ $label->id }}', label: '{{ $label->name }}' }; open = false; @this.set('{{ $name }}', '{{ $label->id }}')"
                    class="cursor-pointer py-1 text-xs text-gray-500 px-3 border-b hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-white/10"
                    :data-name="'{{ strtolower($label->name) }}'"
                    x-show="search === '' || $el.dataset.name.includes(search.toLowerCase())">
                    {{ $label->name }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

