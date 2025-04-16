<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Penjualan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash" :href="route('kartu-kontrol.index')">Kartu Kontrol</flux:breadcrumbs.item>
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
                        <flux:field>
                            <flux:label badge="Required">User</flux:label>
                            <flux:select
                                wire:model="customer_id"
                                variant="listbox"
                                placeholder="Pilih User"
                                :options="$fetchCustomer"
                                wire:change="updatedCustomerId" />
                            @if(!empty($customer_id))
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
                            <flux:error name="customer_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:checkbox.group label="Status Dajam">
                            <flux:checkbox wire:model="sbum" label="SBUM" />
                            <flux:checkbox wire:model="dp" label="DP"  />
                            <flux:checkbox wire:model="imb" label="IMB" />
                            <flux:checkbox wire:model="sertifikat" label="SERTIFIKAT" />
                            <flux:checkbox wire:model="jkk" label="JKK" />
                            <flux:checkbox wire:model="listrik" label="LISTRIK" />
                            <flux:checkbox wire:model="bestek" label="BESTEK" />
                        </flux:checkbox.group>
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('kartu-kontrol.index')" />
        </form>
    </div>
</app>
