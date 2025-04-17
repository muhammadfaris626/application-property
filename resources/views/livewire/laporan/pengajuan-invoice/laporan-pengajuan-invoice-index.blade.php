<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Laporan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Pengajuan Invoice</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:input type="date" size="sm" x-data x-ref="datepicker1" @click="$refs.datepicker1.showPicker()" wire:model="startDate" />
            <flux:input type="date" size="sm" x-data x-ref="datepicker2" @click="$refs.datepicker2.showPicker()" wire:model="endDate" />
            <flux:button variant="primary" size="sm" wire:click="filterData">Filter</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1 flex flex-col gap-4">
                <div class="relative rounded-lg p-6 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Pengajuan</flux:subheading>
                    <flux:heading size="xl">Rp {{ number_format($totalBiayaPengajuan, 0, ',', '.') }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-6 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Disetujui</flux:subheading>
                    <flux:heading size="xl">Rp {{ number_format($totalDisetujui, 0, ',', '.') }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-6 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Tidak Disetujui</flux:subheading>
                    <flux:heading size="xl">Rp {{ number_format($totalTidakDisetujui, 0, ',', '.') }}</flux:heading>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.column-chart-basic :data="$columnChartPengajuan" :title="'Total Biaya Pengajuan'" :label="'chart-biaya-pengajuan'" :useRupiah="true" />
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
                    <x-table-heading-data>PENANGGUNG JAWAB</x-table-heading-data>
                    <x-table-heading-data>HARGA</x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetchData as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->date }}</x-table-body-data>
                        <x-table-body-data>{{ $value->employee->name }}</x-table-body-data>
                        <x-table-body-data>
                            {{ 'Rp. ' . number_format($value->price, 0, ',', '.') }}
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetchData" />
    </div>
</app>
