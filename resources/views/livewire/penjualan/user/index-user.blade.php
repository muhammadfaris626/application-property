<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Penjualan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">User</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'customer'" />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>NOMOR BERKAS</x-table-heading-data>
                    <x-table-heading-data>NIK</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data>JENIS RUMAH</x-table-heading-data>
                    <x-table-heading-data>STATUS PENJUALAN</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->tanggal }}</x-table-body-data>
                        <x-table-body-data>{{ $value->nomor_berkas }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->identification_number }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->typeOfHouse->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->status_penjualan }}</x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            <flux:custom.button-list-permission :id="$value->id" :routeName="'customer'" />
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
