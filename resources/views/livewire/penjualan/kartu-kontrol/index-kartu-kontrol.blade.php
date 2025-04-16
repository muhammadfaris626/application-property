<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Penjualan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Kartu Kontrol</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:custom.button-create-permission :routeName="'kartu-kontrol'" />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>NIK</x-table-heading-data>
                    <x-table-heading-data>NAMA</x-table-heading-data>
                    <x-table-heading-data>ALAMAT</x-table-heading-data>
                    <x-table-heading-data>STATUS DAJAM</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->tanggal }}</x-table-body-data>
                        <x-table-body-data>{{ $value->customer->prospectiveCustomer->identification_number }}</x-table-body-data>
                        <x-table-body-data>{{ $value->customer->prospectiveCustomer->name }}</x-table-body-data>
                        <x-table-body-data>{{ $value->customer->prospectiveCustomer->address }}</x-table-body-data>
                        <x-table-body-data>
                            <flux:modal.trigger :name="'status-dajam-'.$value->id">
                                <flux:button size="xs" variant="filled">Status</flux:button>
                            </flux:modal.trigger>
                            <flux:modal :name="'status-dajam-'.$value->id" class="md:w-150">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">STATUS DATA JAMINAN</flux:heading>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->sbum ? 'check' : 'x-mark'"
                                                :color="$value->sbum ? 'green' : 'red'"
                                            >
                                                SBUM
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->dp ? 'check' : 'x-mark'"
                                                :color="$value->dp ? 'green' : 'red'"
                                            >
                                                DP
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->imb ? 'check' : 'x-mark'"
                                                :color="$value->imb ? 'green' : 'red'"
                                            >
                                                IMB
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->sertifikat ? 'check' : 'x-mark'"
                                                :color="$value->sertifikat ? 'green' : 'red'"
                                            >
                                                SERTIFIKAT
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->jkk ? 'check' : 'x-mark'"
                                                :color="$value->jkk ? 'green' : 'red'"
                                            >
                                                JKK
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->listrik ? 'check' : 'x-mark'"
                                                :color="$value->listrik ? 'green' : 'red'"
                                            >
                                                LISTRIK
                                            </flux:badge>
                                        </div>
                                        <div>
                                            <flux:badge
                                                size="sm"
                                                :icon="$value->bestek ? 'check' : 'x-mark'"
                                                :color="$value->bestek ? 'green' : 'red'"
                                            >
                                                BESTEK
                                            </flux:badge>
                                        </div>
                                    </div>
                                </div>
                            </flux:modal>
                        </x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            <flux:custom.button-list-permission :id="$value->id" :routeName="'kartu-kontrol'" />
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
