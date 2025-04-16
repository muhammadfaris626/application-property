<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pengajuan-invoice.index')" divider="slash">Pengajuan Invoice</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <flux:custom.show-data :id="$id" :data="$show" :route="route('pengajuan-invoice.index')" />
</app>
