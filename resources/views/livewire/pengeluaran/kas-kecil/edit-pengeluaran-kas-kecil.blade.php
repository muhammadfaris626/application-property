<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pengeluaran-kas-kecil.index')" divider="slash">Kas Kecil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Ubah</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <form wire:submit.prevent="update">
            <flux:heading size="xl" class="px-4 pb-2">Ubah Kas Kecil</flux:heading>
            <div class="border rounded-lg p-4 dark:border-white/10">
                <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                    <div>
                        <flux:input type="date" wire:model="date" label="Tanggal" badge="Required" x-data x-ref="datepicker" @click="$refs.datepicker.showPicker()" />
                    </div>
                    <div>
                        <flux:field>
                            <flux:label badge="Required">Penanggung Jawab</flux:label>
                            <flux:select wire:model="employee_id" variant="listbox" placeholder="Pilih Penanggung Jawab" :options="$fetchKaryawan" :selectedData="$employee_id" />
                            <flux:error name="employee_id" />
                        </flux:field>
                    </div>
                </div>
            </div>
            <flux:heading size="xl" class="px-4 py-2">Tambah Pengeluaran</flux:heading>
            <div class="border rounded-lg dark:border-white/10">
                <div class="grid grid-cols-1 gap-4 mt-4">
                    @foreach($allList as $key => $value)
                        <div class="border rounded-lg dark:border-white/10 mx-4">
                            <div class="flex flex-row justify-between items-center px-5 py-2">
                                <h3 class="text-base/7 font-semibold text-gray-900 dark:text-gray-200">PENGELUARAN #{{ $key + 1 }}</h3>
                                <flux:button icon="trash" variant="danger" size="xs" wire:click.prevent="removePengeluaran({{ $key }})"></flux:button>
                            </div>
                            <dl class="border-t divide-y divide-gray-100 dark:divide-white/10">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 m-4">
                                    <div class="md:col-span-2">
                                        <flux:field>
                                            <flux:label badge="Required">Jenis Pengeluaran</flux:label>
                                            <flux:select wire:model="allList.{{ $key }}.type_of_expenditure_id"
                                                variant="listbox" placeholder="Pilih Jenis Pengeluaran"
                                                :options="$fetchJenisPengeluaran" :selectedData="$allList[$key]['type_of_expenditure_id'] ?? null" />
                                            <flux:error name="allList.{{ $key }}.type_of_expenditure_id" />
                                        </flux:field>
                                    </div>
                                    <div class="md:col-span-2">
                                        <flux:input
                                            wire:model="allList.{{ $key }}.desc"
                                            label="Keterangan" badge="Required" />
                                    </div>
                                    <div x-data="rupiahInput(@entangle('allList.' . $key . '.total'))" class="w-full">
                                        <flux:input.group label="Total Biaya" badge="Required">
                                            <flux:input.group.prefix>Rp</flux:input.group.prefix>
                                            <flux:input
                                                x-model="formatted"
                                                @input="updateRawValue"
                                            />
                                        </flux:input.group>
                                        <flux:error name="allList.{{ $key }}.total" />
                                    </div>
                                </div>
                            </dl>
                        </div>
                    @endforeach
                    <div class="flex justify-center mb-4">
                        <flux:button variant="primary" size="sm" icon="plus" wire:click.prevent="addPengeluaran">
                            Tambah Pengeluaran
                        </flux:button>
                    </div>
                </div>
            </div>
            <flux:custom.confirm-update :route="route('pengeluaran-kas-kecil.index')" />
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
