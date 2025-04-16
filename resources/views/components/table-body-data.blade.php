@props([
    'class' => ''
])

<td class="{{'px-4 ' . $class }} text-xs">
    {{ $slot }}
</td>
