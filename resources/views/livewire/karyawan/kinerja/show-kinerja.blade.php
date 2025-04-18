<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('kinerja.index')" divider="slash">Kinerja</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
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
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Calon User</flux:subheading>
                    <flux:heading size="xl">{{ $totalCalonUser }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total User</flux:subheading>
                    <flux:heading size="xl">{{ $totalUser }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Kartu Kontrol</flux:subheading>
                    <flux:heading size="xl">{{ $totalKartuKontrol }}</flux:heading>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.column-chart-basic :data="$columnChartKinerja" :title="'Data Kinerja Karyawan'" :label="'kinerja'" :useRupiah="false" />
                </div>
            </div>
        </div>
    </div>
</app>
