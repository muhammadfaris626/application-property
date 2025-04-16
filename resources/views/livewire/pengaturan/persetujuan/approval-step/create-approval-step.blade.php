<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pengaturan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('persetujuan.show', $id)" divider="slash">Persetujuan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Langkah Persetujuan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="store">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:select label="Urutan Langkah" badge="Required" wire:model="step" placeholder="Pilih Urutan">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Area</flux:label>
                            <flux:select wire:model="area_id" variant="listbox" placeholder="Pilih Area" :options="$fetchArea" />
                            <flux:error name="area_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Jabatan</flux:label>
                            <flux:select wire:model="position_id" variant="listbox" placeholder="Pilih Jabatan" :options="$fetchPosition" />
                            <flux:error name="position_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:select label="Jenis Persetujuan" badge="Required" wire:model="type_of_agreement" placeholder="Pilih Jenis Persetujuan">
                            <flux:select.option value="Pemberi Persetujuan">Pemberi Persetujuan</flux:select.option>
                            <flux:select.option value="Pemeriksa">Pemeriksa</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('persetujuan.show', $id)" />
        </form>
    </div>
</app>
