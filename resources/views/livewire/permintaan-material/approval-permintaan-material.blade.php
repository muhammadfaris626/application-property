<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Logistik</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('permintaan-material.index')" divider="slash">Permintaan Material</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Persetujuan</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-4">
        <flux:custom.show-data :id="$id" :data="$show" :route="route('permintaan-material.index')" />
    </div>
    <flux:separator horizontol class="my-2" />
    <div class="grid grid-cols-1 mt-4">
        <form wire:submit.prevent="persetujuan">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <x-table>
                    <x-table-heading>
                        <x-table-heading-row>
                            <x-table-heading-data>NO</x-table-heading-data>
                            <x-table-heading-data>NAMA MATERIAL</x-table-heading-data>
                            <x-table-heading-data>JUMLAH</x-table-heading-data>
                            <x-table-heading-data>YANG DISETUJUI</x-table-heading-data>
                        </x-table-heading-row>
                    </x-table-heading>
                    <x-table-body>
                        @for($i = 0; $i < count($fetch); $i++)
                            <x-table-body-row :class="$i === count($fetch) - 1 ? 'border-none' : 'border-b'">
                                <x-table-body-data :class="'py-2 w-4'">{{ $i + 1 }}</x-table-body-data>
                                <x-table-body-data>{{ $fetch[$i]['material']['name'] }}</x-table-body-data>
                                <x-table-body-data>{{ $fetch[$i]['quantity'] }}</x-table-body-data>
                                <x-table-body-data>
                                    @if(empty($fetch[$i]['approved_quantity']))
                                        <div class="flex items-center gap-2">
                                            <flux:input size="xs" class="max-w-[95px]" wire:model="fetch.{{ $i }}.approved_quantity" />
                                            <div class="flex items-center h-8">
                                                <flux:error name="fetch.{{ $i }}.approved_quantity" class="text-xs text-red-500 whitespace-nowrap mb-3" />
                                            </div>
                                        </div>
                                    @else
                                        {{ $fetch[$i]['approved_quantity'] }}
                                    @endif
                                </x-table-body-data>
                            </x-table-body-row>
                        @endfor
                    </x-table-body-row>
                </x-table>
                <div class="text-right mt-4">
                    <flux:button type="submit" size="sm" variant="primary">Setujui</flux:button>
                </div>
            </div>
        </form>
    </div>
</app>
