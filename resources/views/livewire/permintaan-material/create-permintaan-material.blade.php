<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Logistik</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('permintaan-material.index')" divider="slash">Permintaan Material</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="store">
            <flux:heading size="xl" class="px-4 pb-2">Tambah Permintaan Material</flux:heading>
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="no_number" label="Nomor RO" badge="Otomatis" value="RO-XXXXXX-XXXXX" disabled />
                    </div>
                    <div>
                        <flux:input type="date" wire:model="date" label="Tanggal" badge="Required" x-data x-ref="datepicker" @click="$refs.datepicker.showPicker()" />
                    </div>
                </div>
            </div>

            <flux:heading size="xl" class="px-4 py-2">Tambah Material</flux:heading>
            <div class="border rounded-lg dark:border-white/10">
                <div class="grid grid-cols-1 gap-4 mt-4">
                    @foreach($allMaterials as $key => $value)
                        <div class="border rounded-lg dark:border-white/10 mx-4">
                            <div class="flex flex-row justify-between items-center px-5 py-2">
                                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-gray-200">MATERIAL #{{ $key + 1 }}</h3>
                                <flux:button icon="trash" variant="danger" size="xs" wire:click.prevent="removeMaterial({{ $key }})"></flux:button>
                            </div>
                            <dl class="border-t divide-y divide-gray-100 dark:divide-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4">
                                    <div>
                                        <flux:field>
                                            <flux:label badge="Required">Material</flux:label>
                                            <flux:select wire:model="allMaterials.{{ $key }}.material_id"
                                                variant="listbox" placeholder="Pilih Material"
                                                :options="$fetchMaterial" />
                                            <flux:error name="allMaterials.{{ $key }}.material_id" />
                                        </flux:field>
                                    </div>
                                    <div>
                                        <flux:input type="number"
                                            wire:model.live="allMaterials.{{ $key }}.quantity"
                                            label="Jumlah" badge="Required" />
                                    </div>
                                </div>
                            </dl>
                        </div>
                    @endforeach
                    <div class="flex justify-center mb-4">
                        <flux:button variant="primary" size="sm" icon="plus" wire:click.prevent="addMaterial">
                            Tambah Material
                        </flux:button>
                    </div>
                </div>
            </div>

            <flux:custom.confirm-create :route="route('permintaan-material.index')" />
        </form>
    </div>
</app>
