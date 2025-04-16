<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Produk</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="#" divider="slash">Penjualan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash" :href="route('customer.index')">User</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <flux:custom.show-data :id="$id" :data="$show" :route="route('customer.index')" />
</app>
