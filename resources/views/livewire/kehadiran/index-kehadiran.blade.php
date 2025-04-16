<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Platform</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Kehadiran</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input type="date" size="sm" x-data x-ref="datepicker1" @click="$refs.datepicker1.showPicker()" wire:model="startDate" />
            <flux:input type="date" size="sm" x-data x-ref="datepicker2" @click="$refs.datepicker2.showPicker()" wire:model="endDate" />
            <flux:button variant="primary" size="sm" wire:click="filterData">Filter</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
            <div class="flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700 text-center">
                    <flux:subheading>Absensi Masuk</flux:subheading>
                    <flux:heading size="lg">
                        {{ $kehadiran?->check_in ?? '--:--:--' }}
                    </flux:heading>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700 text-center">
                    <flux:subheading>Absensi Keluar</flux:subheading>
                    <flux:heading size="lg">
                        {{ $kehadiran?->check_out ?? '--:--:--' }}
                    </flux:heading>
                </div>
            </div>
            <div class="col-span-2 text-center">
                @if(!$kehadiran?->check_in)
                    <flux:button
                        variant="primary"
                        size="sm"
                        wire:click="absenMasuk"
                        wire:loading.attr="disabled"
                        wire:target="absenMasuk"
                    >
                        Absen Masuk
                    </flux:button>
                @elseif(!$kehadiran?->check_out)
                    <flux:button
                        variant="primary"
                        size="sm"
                        wire:click="absenKeluar"
                        wire:loading.attr="disabled"
                        wire:target="absenKeluar"
                    >
                        Absen Keluar
                    </flux:button>
                @endif
            </div>
        </div>
        <div>
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>TANGGAL</x-table-heading-data>
                        <x-table-heading-data>ABSEN MASUK</x-table-heading-data>
                        <x-table-heading-data>ABSEN KELUAR</x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    @foreach($fetch as $key => $value)
                        <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                            <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                            <x-table-body-data>{{ $value->date }}</x-table-body-data>
                            <x-table-body-data>{{ $value->check_in ?? '--:--:--' }}</x-table-body-data>
                            <x-table-body-data>{{ $value->check_out ?? '--:--:--' }}</x-table-body-data>
                        </x-table-body-row>
                    @endforeach
                </x-table-body>
            </x-table>
            <flux:pagination :paginator="$fetch" />
        </div>
    </div>
</app>
