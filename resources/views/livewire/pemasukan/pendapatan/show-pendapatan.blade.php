<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan dan Pengeluaran</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Pemasukan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pemasukan-pendapatan.index')" divider="slash">Pendapatan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="mb-4">
        <flux:custom.show-data :id="$id" :data="$show" :route="route('pemasukan-pendapatan.index')" />
    </div>
</app>
