<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pengajuan-invoice.index')" divider="slash">Permintaan Material</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Persetujuan</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-4">
        <form wire:submit.prevent="persetujuan">
            <div class="grid grid-cols-1">
                <div class="border rounded-lg dark:border-white/10">
                    <div class="px-5 py-2">
                        <h3 class="text-base/7 font-semibold text-gray-900 dark:text-gray-200">ID #{{ $id }}</h3>
                    </div>
                    <div class="border-t border-gray-100 dark:border-white/10">
                        <dl class="divide-y divide-gray-100 dark:divide-white/10">
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200">Tanggal</dt>
                                <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $show->date }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200">Penanggung Jawab</dt>
                                <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $show->employee->name }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200">Harga</dt>
                                <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ 'Rp. ' . number_format($show->price, 0, ',', '.') }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200">Keterangan</dt>
                                <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">{{ $show->desc }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 px-5 font-medium text-gray-900 dark:text-gray-200 {{ $show->approved_price ? '' : 'py-2' }}">Yang Disetujui</dt>
                                <dd class="mt-1 text-sm/6 px-5 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-300">
                                    @if(empty($show->approved_price))
                                        <div x-data="{ price: @entangle('price').defer }">
                                            <flux:input.group>
                                                <flux:input.group.prefix>Rp</flux:input.group.prefix>
                                                <flux:input
                                                    wire:model="approved_price"
                                                    x-model="price"
                                                    x-on:input.debounce.10ms="price = $event.target.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')"
                                                />
                                            </flux:input.group>
                                            <flux:error name="price" />
                                        </div>
                                    @else
                                        {{ 'Rp. ' . number_format($show->approved_price, 0, ',', '.') }}
                                    @endif

                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex gap-2">
                    <flux:button type="submit" size="sm" variant="primary">Disetujui</flux:button>
                    <flux:button :href="route('pengajuan-invoice.index')" size="sm" variant="danger">Kembali</flux:button>
                </div>
            </div>
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
