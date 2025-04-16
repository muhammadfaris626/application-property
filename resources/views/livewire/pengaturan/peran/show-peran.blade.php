<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('peran.index')" divider="slash">Peran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center">
        <div class="flex gap-2">
            <flux:button :href="route('peran.index')" size="sm" variant="danger">Kembali</flux:button>
        </div>
        <div class="uppercase font-bold">
            {{ $show->name }}
        </div>
    </div>
    <flux:separator horizontol class="my-2" />
    <div class="grid grid-cols-1 mt-4">
        <div class="border rounded-lg p-4 dark:border-white/10">
            <x-table>
                <x-table-heading>
                    <x-table-heading-row>
                        <x-table-heading-data>NO</x-table-heading-data>
                        <x-table-heading-data>NAMA</x-table-heading-data>
                        <x-table-heading-data :position="'text-center'">MENU</x-table-heading-data>
                        <x-table-heading-data :position="'text-center'">TAMBAH</x-table-heading-data>
                        <x-table-heading-data :position="'text-center'">LIHAT</x-table-heading-data>
                        <x-table-heading-data :position="'text-center'">UBAH</x-table-heading-data>
                        <x-table-heading-data :position="'text-center'">HAPUS</x-table-heading-data>
                    </x-table-heading-row>
                </x-table-heading>
                <x-table-body>
                    @php
                        $order = ['menu', 'create', 'read', 'update', 'delete'];
                    @endphp
                    @foreach($fetch as $key => $value)
                        <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                            <x-table-body-data class="py-2 w-4 text-center">{{ $key + 1 }}</x-table-body-data>
                            <x-table-body-data>{{ $value['category'] }}</x-table-body-data>
                            @php
                                $sortedPermissions = collect($value[$value['category']])
                                    ->sortBy(function ($item) use ($order) {
                                        $suffix = explode(':', $item['name'])[1] ?? 'menu';
                                        return array_search($suffix, $order) !== false ? array_search($suffix, $order) : 999;
                                    });
                            @endphp

                            @foreach($sortedPermissions as $list)
                                <x-table-body-data class="text-center">
                                    <input
                                        type="checkbox"
                                        class="h-5 w-5 mt-1"
                                        @checked($list['status'] == 1)
                                        wire:click="updatePermission({{ $value[1] }}, {{ $list['id'] }})"
                                    />
                                </x-table-body-data>
                            @endforeach
                        </x-table-body-row>
                    @endforeach


                </x-table-body>
            </x-table>
        </div>
    </div>
</app>
