@props([
    'class' => ''
])

<tr class="bg-white {{ $class }} dark:bg-white/10 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5 dark:border-b-white/10 dark:text-white/80 whitespace-nowrap">
    {{ $slot }}
</tr>
