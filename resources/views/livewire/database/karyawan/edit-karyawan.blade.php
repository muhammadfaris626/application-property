<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Database</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('karyawan.index')" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input wire:model="identification_number" label="Nomor Induk Kependudukan" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="name" label="Nama" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="address" label="Alamat" badge="Required" />
                    </div>
                    <div>
                        <flux:input wire:model="place_of_birth" label="Tempat Lahir" badge="Required" />
                    </div>
                    <div>
                        <flux:input type="date" wire:model="date_of_birth" label="Tanggal Lahir" badge="Required" x-data x-ref="datepicker" @click="$refs.datepicker.showPicker()" />
                    </div>
                    <div>
                        <flux:input.group label="Nomor Whatsapp" badge="Required">
                            <flux:input.group.prefix>+62</flux:input.group.prefix>
                            <flux:input wire:model="whatsapp_number" placeholder="xxxxxxxxxxx" />
                        </flux:input.group>
                    </div>
                    <div>
                        <flux:input wire:model="email" label="Email" badge="Required" />
                    </div>
                    <div>
                        <flux:select label="Status Karyawan" badge="Required" wire:model="active">
                            <flux:select.option readonly>Pilih Status</flux:select.option>
                            <flux:select.option value="1">Aktif</flux:select.option>
                            <flux:select.option value="0">Tidak Aktif</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('karyawan.index')" />
        </form>
    </div>
</app>
