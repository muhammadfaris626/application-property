<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('persetujuan.index')" divider="slash">Persetujuan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="store">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="name" label="Nama Persetujuan" badge="Required" />
                    </div>
                    <div>
                        <flux:select label="Nama Model" badge="Required" wire:model="model_type" placeholder="Pilih Model">
                            @foreach($models as $key => $value)
                                <flux:select.option value="{{ $value }}">{{ $value }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('persetujuan.index')" />
        </form>
    </div>
</app>
