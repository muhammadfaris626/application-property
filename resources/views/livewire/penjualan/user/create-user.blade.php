<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Penjualan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash" :href="route('customer.index')">User</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Tambah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="store">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input type="date" wire:model="tanggal" label="Tanggal" badge="Required" x-data x-ref="datepicker" @click="$refs.datepicker.showPicker()" />
                    </div>
                    <div>
                        <flux:input wire:model="nomor_berkas" label="Nomor Berkas" badge="Required" />
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Calon User</flux:label>
                            <flux:select
                                wire:model="prospective_customer_id"
                                variant="listbox"
                                placeholder="Pilih Calon User"
                                :options="$fetchCalonUser" />
                            @if($userSelected)
                                <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center px-4">
                                    <div>
                                        <flux:text class="text-xs">NIK</flux:text>
                                        <flux:text class="text-xs">NAMA</flux:text>
                                        <flux:text class="text-xs">ALAMAT</flux:text>
                                    </div>
                                    <div class="text-right">
                                        <flux:text class="text-xs">{{ $nik }}</flux:text>
                                        <flux:text class="text-xs">{{ $nama }}</flux:text>
                                        <flux:text class="text-xs">{{ $alamat }}</flux:text>
                                    </div>
                                </div>
                            @endif
                            <flux:error name="prospective_customer_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Jenis Rumah</flux:label>
                            <flux:select
                                wire:model="type_of_house_id"
                                variant="listbox"
                                placeholder="Pilih Jenis Rumah"
                                :options="$fetchJenisRumah" />
                            <flux:error name="type_of_house_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:input wire:model="keterangan_rumah" label="Keterangan Rumah" badge="Required" />
                    </div>
                    <div>
                        <flux:select label="Status Penjualan" badge="Required" wire:model="status_penjualan" placeholder="Pilih Status">
                            <flux:select.option value="KREDIT FLPP">KREDIT FLPP</flux:select.option>
                            <flux:select.option value="KREDIT TAPERA">KREDIT TAPERA</flux:select.option>
                            <flux:select.option value="CASH">CASH</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:select
                            label="Status Pengajuan User"
                            badge="Required"
                            wire:model.lazy="status_pengajuan_user"
                            placeholder="Pilih Status"
                        >
                            <flux:select.option value="SPR">SPR</flux:select.option>
                            <flux:select.option value="SP3K">SP3K</flux:select.option>
                            <flux:select.option value="AKAD">AKAD</flux:select.option>
                        </flux:select>
                        @if ($status_pengajuan_user === 'SPR')
                            <div class="mt-2 px-3">
                                <flux:checkbox wire:model="verifikasi_dp" label="Verifikasi DP" />
                            </div>
                        @endif
                    </div>
                    <div>
                        <flux:input type="file" wire:model="upload_berkas" label="Upload Berkas" badge="Required" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('customer.index')" />
        </form>
    </div>
</app>
