@props([
    'position' => 'text-left'
])
<th scope="col" class="px-4 py-2 {{ $position }}">
    {{ $slot }}
</th>
