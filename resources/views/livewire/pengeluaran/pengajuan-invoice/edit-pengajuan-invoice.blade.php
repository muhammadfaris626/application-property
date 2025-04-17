<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pengajuan-invoice.index')" divider="slash">Pengajuan Invoice</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid:cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input type="date" wire:model="date" label="Tanggal" badge="Required" x-data x-ref="datepicker" @click="$refs.datepicker.showPicker()" />
                    </div>
                    {{-- <div>
                        <flux:field>
                            <flux:label badge="Required">Penanggung Jawab</flux:label>
                            <flux:select wire:model="employee_id" variant="listbox" placeholder="Pilih Karyawan" :options="$fetchKaryawan" :selectedData="$employee_id" />
                            <flux:error name="employee_id" />
                        </flux:field>
                    </div> --}}
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
                    <div>
                        <flux:input label="Keterangan" badge="Required" wire:model="desc" />
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('material.index')" />
        </form>
    </div>
    <script>
        function rupiahInput(model) {
            return {
                formatted: '',
                raw: model,
                init() {
                    this.formatted = this.format(this.raw);
                },
                format(value) {
                    value = parseInt(value);
                    return isNaN(value) ? '' : value.toLocaleString('id-ID');
                },
                unformat(value) {
                    return value.replace(/\./g, '');
                },
                updateRawValue() {
                    this.raw = this.unformat(this.formatted);
                    this.formatted = this.format(this.raw);
                }
            }
        }
    </script>
</app>
