<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Pengajuan Invoice</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex flex-col md:flex-row gap-4">
            <flux:input icon="magnifying-glass" placeholder="Pencarian..." size="sm" wire:model.live="search" />
            <flux:select size="sm" wire:model.live="filterStatus" placeholder="Pilih Status">
                <flux:select.option value="all">Semua Status</flux:select.option>
                <flux:select.option value="Pemeriksaan">Pemeriksaan</flux:select.option>
                <flux:select.option value="Persetujuan">Persetujuan</flux:select.option>
            </flux:select>
            <flux:custom.button-create-permission :routeName="'pengajuan-invoice'" />
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
        <x-table>
            <x-table-heading>
                <x-table-heading-row>
                    <x-table-heading-data>NO</x-table-heading-data>
                    <x-table-heading-data>TANGGAL</x-table-heading-data>
                    <x-table-heading-data>PENANGGUNG JAWAB</x-table-heading-data>
                    <x-table-heading-data>HARGA</x-table-heading-data>
                    <x-table-heading-data>STATUS PERSETUJUAN</x-table-heading-data>
                    <x-table-heading-data></x-table-heading-data>
                </x-table-heading-row>
            </x-table-heading>
            <x-table-body>
                @foreach($fetch as $key => $value)
                    <x-table-body-row :class="$loop->last ? 'border-none' : 'border-b'">
                        <x-table-body-data :class="'py-2 w-4'">{{ $key + 1 }}</x-table-body-data>
                        <x-table-body-data>{{ $value->date }}</x-table-body-data>
                        <x-table-body-data>{{ $value->employee->name }}</x-table-body-data>
                        <x-table-body-data>
                            {{ 'Rp. ' . number_format($value->price, 0, ',', '.') }}
                        </x-table-body-data>
                        <x-table-body-data>
                            <flux:modal.trigger :name="'status-persetujuan-'.$value->id">
                                @if($value->approvalHistories->where('marker', 'disetujui')->count() == $value->approvalHistories->count())
                                    <flux:button size="xs" variant="filled">Disetujui</flux:button>
                                @else
                                    <flux:button size="xs" variant="filled">Sedang diproses</flux:button>
                                @endif
                            </flux:modal.trigger>
                            <flux:modal :name="'status-persetujuan-'.$value->id" class="md:w-150">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">STATUS PERSETUJUAN</flux:heading>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-2">
                                        <div>
                                            <flux:heading>Tanggal</flux:heading>
                                            <flux:heading>Penanggung Jawab</flux:heading>
                                            <flux:heading>Harga</flux:heading>
                                            <flux:heading>Keterangan</flux:heading>
                                            <flux:heading>Yang Disetujui</flux:heading>
                                        </div>
                                        <div class="text-right">
                                            <flux:text>{{ $value->date }}</flux:text>
                                            <flux:text>{{ $value->employee->name }}</flux:text>
                                            <flux:text>{{ 'Rp. ' . number_format($value->price, 0, ',', '.') }}</flux:text>
                                            <flux:text>{{ $value->desc }}</flux:text>
                                            <flux:text>{{ 'Rp. ' . number_format($value->approved_price, 0, ',', '.') }}</flux:text>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <flux:heading size="lg">PERSETUJUAN</flux:heading>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        @foreach($value->approvalHistories as $keyList => $list)
                                            <div>
                                                <flux:heading>{{ $keyList + 1 }}</flux:heading>
                                            </div>
                                            <div>
                                                <flux:heading>{{ $list->approvedBy->name }}</flux:heading>
                                            </div>
                                            <div class="text-right">
                                                @if($list->marker == 'menunggu persetujuan')
                                                    <flux:badge variant="solid" color="orange" size="xs">{{ $list->marker }}</flux:badge>
                                                @else
                                                    <flux:badge variant="solid" color="green" size="xs">{{ $list->marker }}</flux:badge>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </flux:modal>
                        </x-table-body-data>
                        <x-table-body-data :class="'text-right'">
                            @php
                                $history = $value->approvalHistories->firstWhere('status', 1);
                                $semuaDisetujui = $value->approvalHistories->every(fn($item) => $item->marker === 'disetujui');
                                $isApprover = Auth::user()->employee_id === $history?->approved_by;
                                $butuhPemeriksaan = $history?->approvalStep?->type_of_agreement === 'Pemeriksa';
                            @endphp
                            @if(!$semuaDisetujui && $isApprover)
                                <flux:button
                                    variant="subtle"
                                    icon="{{ $butuhPemeriksaan ? 'numbered-list' : 'check' }}"
                                    size="xs"
                                    :href="route('pengajuan-invoice.approval', $value->id)"
                                >
                                    {{ $butuhPemeriksaan ? 'Butuh Pemeriksaan' : 'Butuh Persetujuan' }}
                                </flux:button>
                            @endif
                            @can('pengajuan-invoice: read')
                                <flux:button :href="route('pengajuan-invoice.show', $value->id)" icon="eye" size="xs"></flux:button>
                            @endcan
                            @if($value->approvalHistories->where('marker', 'disetujui')->count() < 1)
                                @can('pengajuan-invoice: update')
                                    <flux:button :href="route('pengajuan-invoice.edit', $value->id)" icon="pencil-square" size="xs" variant="primary"></flux:button>
                                @endcan
                            @endif
                            @can('pengajuan-invoice: delete')
                                <flux:custom.confirm-delete :id="$value->id" :action="route('pengajuan-invoice.destroy', $value->id)"/>
                            @endcan
                        </x-table-body-data>
                    </x-table-body-row>
                @endforeach
            </x-table-body>
        </x-table>
        <flux:pagination :paginator="$fetch" />
    </div>
</app>
