<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('area.index')" divider="slash">Area</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="name" label="Nama Area" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="address" label="Alamat" badge="Required" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('area.index')" />
        </form>
    </div>
</app>
