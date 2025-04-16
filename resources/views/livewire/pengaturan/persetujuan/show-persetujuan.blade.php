<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('persetujuan.index')" divider="slash">Persetujuan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <div class="border rounded-lg p-4 dark:border-white/10">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <flux:input label="Nama Persetujuan" :value="$show->name" disabled></flux:input>
                </div>
                <div>
                    <flux:input label="Nama Model" :value="$show->model_type" disabled></flux:input>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 mb-4">
        <div class="flex gap-2">
            <flux:button :href="route('persetujuan.index')" size="sm" variant="danger">Kembali</flux:button>
        </div>
    </div>
    <flux:separator horizontol class="my-2" />
    <div class="flex flex-col md:flex-row gap-6 justify-end md:items-center mt-4">
        <div class="flex gap-4">
            <flux:button :href="route('langkah-persetujuan.create', $show->id)" icon="plus" size="sm" variant="primary">Tambah Data</flux:button>
        </div>
    </div>
    <div class="grid grid-cols-1 mt-4">
        <div class="border rounded-lg p-4 dark:border-white/10">
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>URUTAN LANGKAH</x-table-heading-data>
                        <x-table-heading-data>AREA</x-table-heading-data>
                        <x-table-heading-data>NAMA JABATAN</x-table-heading-data>
                        <x-table-heading-data>JENIS PERSETUJUAN</x-table-heading-data>
                        <x-table-heading-data></x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    @foreach($fetch as $key => $value)
                        <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                            <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                            <x-table-body-data>{{ $value->step }}</x-table-body-data>
                            <x-table-body-data>{{ $value->area->name }}</x-table-body-data>
                            <x-table-body-data>{{ $value->position->name }}</x-table-body-data>
                            <x-table-body-data>{{ $value->type_of_agreement }}</x-table-body-data>
                            <x-table-body-data :class="'text-right'">
                                <flux:button :href="route('langkah-persetujuan.edit', $value->id)" icon="pencil-square" size="xs" variant="primary"></flux:button>
                                <flux:custom.confirm-delete :id="$value->id" :action="route('langkah-persetujuan.destroy', $value->id)" />
                            </x-table-body-data>
                        </x-table-body-row>
                    @endforeach
                </x-table-body>
            </x-table>
        </div>
    </div>
</app>
