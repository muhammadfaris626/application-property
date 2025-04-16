<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pemasukan-kas-besar.index')" divider="slash">Kas Besar</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-4">
        <flux:custom.show-data :id="$id" :data="$show" :route="route('pemasukan-kas-besar.index')" />
    </div>
    <flux:separator horizontol class="my-2" />
    <div class="grid grid-cols-1 mt-4">
        <div class="border rounded-lg p-4 dark:border-white/10">
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>JENIS PEMASUKAN</x-table-heading-data>
                        <x-table-heading-data>KETERANGAN</x-table-heading-data>
                        <x-table-heading-data>TOTAL</x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    @foreach($fetch as $key => $value)
                        <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                            <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                            <x-table-body-data>{{ $value->typeOfIncome->name }}</x-table-body-data>
                            <x-table-body-data>{{ $value->desc }}</x-table-body-data>
                            <x-table-body-data>
                                {{ 'Rp. ' . number_format($value->total, 0, ',', '.') }}
                            </x-table-body-data>
                        </x-table-body-row>
                    @endforeach
                    <x-table-body-row :class="'border-t'">
                        <x-table-heading-data></x-table-heading-data>
                        <x-table-heading-data></x-table-heading-data>
                        <x-table-heading-data>TOTAL</x-table-heading-data>
                        <x-table-heading-data>
                            {{ 'Rp. ' . number_format($fetch->sum('total'), 0, ',', '.') }}
                        </x-table-heading-data>
                    </x-table-body-row>
                </x-table-body>
            </x-table>
        </div>
    </div>
</app>
