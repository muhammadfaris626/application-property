@props([
    'konfigurasi'
])
@php
$firstKey = array_key_first($konfigurasi);
$groupMenus = $konfigurasi[$firstKey];
$hasAccess = function ($item) {
    if (!is_array($item) || !array_key_exists('permission', $item)) return false;
    $permissions = is_array($item['permission']) ? $item['permission'] : [$item['permission']];
    return collect($permissions)->contains(function ($perm) {
        return auth()->user()->can($perm);
    });
};

$filteredMenus = collect($groupMenus)->filter(function ($menu) use ($hasAccess) {

    if (is_array($menu) && array_is_list($menu)) {
        // Nested submenu
        return collect($menu)->filter(fn($item) => $hasAccess($item))->isNotEmpty();
    }
    return $hasAccess($menu);
});
@endphp

@if($filteredMenus->isNotEmpty())
    <flux:navlist.group :heading="__($firstKey)" class="grid">
        @foreach($filteredMenus as $key => $menu)
            @php
                $isMultiple = is_array($menu) && array_is_list($menu);
            @endphp
            @if($isMultiple)
                @php
                    $visibleMenus = collect($menu)->filter(fn($item) => $hasAccess($item));
                    $allRoutes = $visibleMenus->pluck('routes')->flatten()->unique()->toArray();
                @endphp
                <flux:navlist.group :heading="$key" expandable :expanded="in_array(request()->route()->getName(), $allRoutes)">
                    @foreach($visibleMenus as $list)
                        <flux:navlist.item
                            :href="route($list['route'])"
                            :current="in_array(request()->route()->getName(), $list['routes'] ?? [])"
                            wire:navigate>
                            {{ __($list['label']) }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            @else
                <flux:navlist.item
                    :icon="isset($menu['icon']) ? $menu['icon'] : 'rectangle-group'"
                    :href="route($menu['route'])"
                    :current="in_array(request()->route()->getName(), $menu['routes'] ?? [])"
                    wire:navigate>
                    {{ __($menu['label']) }}
                </flux:navlist.item>
            @endif
        @endforeach
    </flux:navlist.group>
@endif
