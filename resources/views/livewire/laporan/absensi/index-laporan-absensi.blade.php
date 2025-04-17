<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Laporan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Absensi</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:input type="date" size="sm" x-data x-ref="datepicker1" @click="$refs.datepicker1.showPicker()" wire:model="startDate" />
            <flux:input type="date" size="sm" x-data x-ref="datepicker2" @click="$refs.datepicker2.showPicker()" wire:model="endDate" />
            <flux:button variant="primary" size="sm" wire:click="applyFilter">Filter</flux:button>
        </div>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-3 flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:heading class="mb-4 text-center">Top #5 Karyawan OnTime</flux:heading>
                    <x-table>
                        <x-table-heading>
                            <x-table-heading-row>
                                <x-table-heading-data>NO</x-table-heading-data>
                                <x-table-heading-data>NAMA</x-table-heading-data>
                                <x-table-heading-data>AREA</x-table-heading-data>
                            </x-table-heading-row>
                        </x-table-heading>
                        <x-table-body>
                            @foreach($top5KaryawanRajin as $key => $value)
                                <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                                    <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                                    <x-table-body-data>{{ $value->name }}</x-table-body-data>
                                    <x-table-body-data>{{ $value->area_name }}</x-table-body-data>
                                </x-table-body-row>
                            @endforeach
                        </x-table-body>
                    </x-table>
                </div>
            </div>
            <div class="md:col-span-3 flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:heading class="mb-4 text-center">Top #5 Karyawan Terlambat</flux:heading>
                    <x-table>
                        <x-table-heading>
                            <x-table-heading-row>
                                <x-table-heading-data>NO</x-table-heading-data>
                                <x-table-heading-data>NAMA</x-table-heading-data>
                                <x-table-heading-data>AREA</x-table-heading-data>
                            </x-table-heading-row>
                        </x-table-heading>
                        <x-table-body>
                            @foreach($top5KaryawanTerlambat as $key => $value)
                                <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                                    <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                                    <x-table-body-data>{{ $value->name }}</x-table-body-data>
                                    <x-table-body-data>{{ $value->area_name }}</x-table-body-data>
                                </x-table-body-row>
                            @endforeach
                        </x-table-body>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data>AREA</x-table-heading-data>
                    <x-table-heading-data>ONTIME</x-table-heading-data>
                    <x-table-heading-data>TERLAMBAT</x-table-heading-data>
                    <x-table-heading-data>TIDAK ABSEN MASUK</x-table-heading-data>
                    <x-table-heading-data>TIDAK ABSEN PULANG</x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @for($i = 0; $i < count($fetchData); $i++)
                <x-table-body-row :class="'border-b'">
                    <x-table-body-data :class="'py-2 w-4'">{{ $i + 1 }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['name'] }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['area'] }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['ontime'] }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['terlambat'] }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['tidak_absen_masuk'] }}</x-table-body-data>
                    <x-table-body-data>{{ $fetchData[$i]['tidak_absen_pulang'] }}</x-table-body-data>
                </x-table-body-row>
                @endfor
            </x-table-body>
        </x-table>
    </div>
</app>
