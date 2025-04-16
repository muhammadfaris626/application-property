<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('jenis-rumah.index')" divider="slash">Jenis Rumah</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="code" label="Kode" badge="Otomatis" disabled />
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Area</flux:label>
                            <flux:select wire:model="area_id" variant="listbox" placeholder="Pilih Area" :options="$fetchData" :selectedData="$this->area_id" />
                            <flux:error name="area_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:input wire:model="name" label="Jenis Rumah" badge="Required" />
                    </div>
                    <div x-data="{ price: @entangle('price').live }" x-init="price = price?.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')">
                        <flux:input.group label="Harga" badge="Required">
                            <flux:input.group.prefix>Rp</flux:input.group.prefix>
                            <flux:input
                                wire:model.lazy="price"
                                x-model="price"
                                x-on:input.debounce.10ms="price = $event.target.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                            />
                        </flux:input.group>
                        <flux:error name="price" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('jenis-rumah.index')" />
        </form>
    </div>
</app>
