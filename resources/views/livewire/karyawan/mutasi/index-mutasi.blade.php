<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Mutasi</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'mutasi'" />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>NAMA KARYAWAN</x-table-heading-data>
                    <x-table-heading-data>AREA SEBELUMNYA</x-table-heading-data>
                    <x-table-heading-data>MUTASI KE</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @php
                    $lastEntries = $fetch->groupBy('employee_id')->map->keys()->map->last();
                @endphp
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->date }}</x-table-body-data>
                        <x-table-body-data>{{ $value->employee->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->fromArea->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->toArea->name }}</x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            @can('mutasi: read')
                                <flux:button :href="route('mutasi.show', $value->id)" icon="eye" size="xs"></flux:button>
                            @endcan
                            @if($lastEntries[$value->employee_id] === $loop->index)
                                @can('mutasi: update')
                                    <flux:button :href="route('mutasi.edit', $value->id)" icon="pencil-square" size="xs" variant="primary"></flux:button>
                                @endcan
                                @can('mutasi: delete')
                                    <flux:custom.confirm-delete :id="$value->id" :action="route('mutasi.destroy', $value->id)"/>
                                @endcan
                            @endif
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
