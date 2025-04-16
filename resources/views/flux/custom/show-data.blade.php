@props([
    'id',
    'data',
    'route'
])
<div class="grid grid-cols-1">
    <div class="border rounded-lg dark:border-white/10">
        <div class="px-5 py-2">
            <h3 class="text-base/7 font-semibold text-gray-900 dark:text-gray-200">ID #{{ $id }}</h3>
        </div>
        <div class="border-t border-gray-100 dark:border-white/10">
            <dl class="divide-y divide-gray-100 dark:divide-white/10">
                @foreach($data as $item)
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200">{{ $item['name'] }}</dt>
                        <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">
                            {{-- {{ $item['value'] }} --}}
                            @if (is_string($item['value']) && (Str::contains($item['value'], ['storage/', '.pdf', '.jpg', '.png'])))
                                <a href="{{ asset($item['value']) }}" target="_blank" class="text-blue-600 hover:underline">
                                    Tampilkan Berkas
                                </a>
                            @else
                                @if($item['value'] == 'Terverifikasi')
                                    <flux:badge color="green" size="sm" icon="check">Terverifikasi</flux:badge>
                                @elseif($item['value'] == 'Belum diverifikasi')
                                    <flux:badge color="red" size="sm" icon="x-mark">Belum diverifikasi</flux:badge>
                                @else
                                    {!! nl2br(e($item['value'])) !!}
                                @endif
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
<div class="mt-4">
    <div class="flex gap-2">
        <flux:button :href="$route" size="sm" variant="danger">Kembali</flux:button>
    </div>
</div>
