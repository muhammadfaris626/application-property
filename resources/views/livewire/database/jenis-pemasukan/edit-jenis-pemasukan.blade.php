<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('jenis-pemasukan.index')" divider="slash">Jenis Pemasukan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="name" label="Jenis Pemasukan" badge="Required" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('jenis-pemasukan.index')" />
        </form>
    </div>
</app>
