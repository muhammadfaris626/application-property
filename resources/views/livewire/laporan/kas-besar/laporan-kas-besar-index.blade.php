<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Laporan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Kas Besar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
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
                    <flux:subheading>Total Pemasukan</flux:subheading>
                    <flux:heading size="lg">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Pengeluaran</flux:subheading>
                    <flux:heading size="lg">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Sisa Kas</flux:subheading>
                    <flux:heading size="lg">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</flux:heading>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.column-chart-basic :data="$columnChartKasBesar" :title="'Pemasukan dan Pengeluaran'" :label="'kas-besar'" :useRupiah="true" />
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.bar-chart :label="'bar-kas-besar'" :data="$barChartKasBesar" :category="$categoryYears" :title="'Pemasukan dan Pengeluaran (' . \Carbon\Carbon::now()->year - 2 . ' - ' . \Carbon\Carbon::now()->year . ')'" :useRupiah="true" />
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>KATEGORI</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>PENANGGUNG JAWAB</x-table-heading-data>
                    <x-table-heading-data>TOTAL BIAYA</x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetchData as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->category }}</x-table-body-data>
                        <x-table-body-data>{{ $value->date }}</x-table-body-data>
                        <x-table-body-data>{{ $value->employee->name }}</x-table-body-data>
                        <x-table-body-data>
                            {{ 'Rp. ' . number_format($value->listKasBesars->sum('total'), 0, ',', '.') }}
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetchData" />
    </div>
</app>
