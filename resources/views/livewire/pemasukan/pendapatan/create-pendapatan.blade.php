<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pemasukan-pendapatan.index')" divider="slash">Pendapatan</flux:breadcrumbs.item>
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
                            <flux:label badge="Required">Jenis Pemasukan</flux:label>
                            <flux:select wire:model="type_of_income_id"
                                variant="listbox" placeholder="Pilih Jenis Pemasukan"
                                :options="$fetchJenisPemasukan" />
                            <flux:error name="type_of_income_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">User</flux:label>
                            <flux:select wire:model="customer_id"
                                variant="listbox" placeholder="Pilih User"
                                :options="$fetchCustomer" />
                            <flux:error name="customer_id" />
                        </flux:field>
                    </div>
                    <div>
                        <flux:input wire:model="keterangan" label="Keterangan" badge="Required" />
                    </div>
                    <div x-data="{ total: @entangle('total').defer }">
                        <flux:input.group label="Harga" badge="Required" >
                            <flux:input.group.prefix>Rp</flux:input.group.prefix>
                            <flux:input
                                wire:model="total"
                                x-model="total"
                                x-on:input.debounce.10ms="total = $event.target.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                            />
                        </flux:input.group>
                        <flux:error name="total" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-create :route="route('pemasukan-pendapatan.index')" />
        </form>
    </div>
</app>
