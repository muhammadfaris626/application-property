<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Logistik</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('permintaan-material.index')" divider="slash">Permintaan Material</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-4">
        <flux:custom.show-data :id="$id" :data="$show" :route="route('permintaan-material.index')" />
    </div>
    <flux:separator horizontol class="my-2" />
    <div class="grid grid-cols-1 mt-4">
        <div class="border rounded-lg p-4 dark:border-white/10">
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>NAMA MATERIAL</x-table-heading-data>
                        <x-table-heading-data>JUMLAH</x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    @foreach($fetch as $key => $value)
                        <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                            <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                            <x-table-body-data>{{ $value->material->name }}</x-table-body-data>
                            <x-table-body-data>{{ $value->quantity }}</x-table-body-data>
                        </x-table-body-row>
                    @endforeach
                </x-table-body>
            </x-table>
        </div>
    </div>
</app>
