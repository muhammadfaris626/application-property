<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('struktur.index')" divider="slash">Struktur Management</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="store">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Karyawan</flux:label>
                            <flux:select wire:model="employee_id" variant="listbox" placeholder="Pilih Karyawan" :options="$fetchKaryawan" />
                            <flux:error name="employee_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Jabatan</flux:label>
                            <flux:select wire:model="position_id" variant="listbox" placeholder="Pilih Jabatan" :options="$fetchJabatan" />
                            <flux:error name="position_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Area</flux:label>
                            <flux:select wire:model="area_id" variant="listbox" placeholder="Pilih Area" :options="$fetchArea" />
                            <flux:error name="area_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:input wire:model="employee_number" label="Nomor Identitas Kepegawaian" badge="Required" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('struktur.index')" />
        </form>
    </div>
</app>
