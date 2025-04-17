<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Laporan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">User</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:select size="sm" wire:model="area_id" placeholder="Pilih Area">
                <flux:select.option value="all">Semua Area</flux:select.option>
                @foreach($areas as $key => $value)
                    <flux:select.option value="{{ $value->id }}">{{ $value->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input type="date" size="sm" x-data x-ref="datepicker1" @click="$refs.datepicker1.showPicker()" wire:model="startDate" />
            <flux:input type="date" size="sm" x-data x-ref="datepicker2" @click="$refs.datepicker2.showPicker()" wire:model="endDate" />
            <flux:button variant="primary" size="sm" wire:click="filterData">Filter</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-1 flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total User</flux:subheading>
                    <flux:heading size="lg">{{ $totalUser }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Kredit</flux:subheading>
                    <flux:heading size="lg">{{ $totalKredit }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Cash</flux:subheading>
                    <flux:heading size="lg">{{ $totalCash }}</flux:heading>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.column-chart-basic :data="$columnChartPenjualanUser" :title="'Penjualan User (' . \Carbon\Carbon::now()->year . ')'" :label="'penjualan-user'" :useRupiah="false" />
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.bar-chart :label="'bar-kas-kecil'" :data="$barChartPenjualanUser" :category="$categoryYears" :title="'Penjualan User (' . \Carbon\Carbon::now()->year - 2 . ' - ' . \Carbon\Carbon::now()->year . ')'" :useRupiah="false" />
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>NOMOR BERKAS</x-table-heading-data>
                    <x-table-heading-data>NIK</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data>ALAMAT</x-table-heading-data>
                    <x-table-heading-data>WHATSAPP</x-table-heading-data>
                    <x-table-heading-data>JENIS RUMAH</x-table-heading-data>
                    <x-table-heading-data>KETERANGAN</x-table-heading-data>
                    <x-table-heading-data>STATUS PENJUALAN</x-table-heading-data>
                    <x-table-heading-data>STATUS PENGAJUAN</x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetchData as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->tanggal }}</x-table-body-data>
                        <x-table-body-data>{{ $value->nomor_berkas }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->identification_number }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->address }}</x-table-body-data>
                        <x-table-body-data>{{ $value->prospectiveCustomer->whatsapp_number }}</x-table-body-data>
                        <x-table-body-data>{{ $value->typeOfHouse->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->keterangan_rumah }}</x-table-body-data>
                        <x-table-body-data>{{ $value->status_penjualan }}</x-table-body-data>
                        <x-table-body-data>{{ $value->status_pengajuan_user }}</x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetchData" />
    </div>
</app>
