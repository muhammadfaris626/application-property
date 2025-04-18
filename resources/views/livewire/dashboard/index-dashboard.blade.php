<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Dashboard</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:select size="sm" wire:model="area_id" placeholder="Pilih Area">
                <flux:select.option value="all">Semua Area</flux:select.option>
                @foreach($fetchArea as $key => $value)
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Total Omzet</flux:subheading>
                <flux:heading size="xl">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Unit Terjual</flux:subheading>
                <flux:heading size="xl">{{ $unitTerjual }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Karyawan Aktif</flux:subheading>
                <flux:heading size="xl">{{ $totalKaryawan }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Calon User</flux:subheading>
                <flux:heading size="xl">{{ $totalCalonUser }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>User : SPR</flux:subheading>
                <flux:heading size="xl">{{ $totalUserSpr }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>User : SP3K</flux:subheading>
                <flux:heading size="xl">{{ $totalUserSp3k }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>User : AKAD</flux:subheading>
                <flux:heading size="xl">{{ $totalUserAkad }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>User : CASH</flux:subheading>
                <flux:heading size="xl">{{ $totalUserCash }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Total Pemasukan Kas Besar</flux:subheading>
                <flux:heading size="xl">Rp {{ number_format($this->totalPemasukan('kas-besar'), 0, ',', '.') }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Total Pemasukan Kas Kecil</flux:subheading>
                <flux:heading size="xl">Rp {{ number_format($this->totalPemasukan('kas-kecil'), 0, ',', '.') }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Total Pengeluaran Kas Kecil</flux:subheading>
                <flux:heading size="xl">Rp {{ number_format($this->totalPengeluaran('kas-besar'), 0, ',', '.') }}</flux:heading>
            </div>
            <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                <flux:subheading>Total Pengeluaran Kas Kecil</flux:subheading>
                <flux:heading size="xl">Rp {{ number_format($this->totalPengeluaran('kas-kecil'), 0, ',', '.') }}</flux:heading>
            </div>
        </div>
    </div>
</app>
