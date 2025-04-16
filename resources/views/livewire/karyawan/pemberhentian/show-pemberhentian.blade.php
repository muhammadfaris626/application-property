<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('pemberhentian.index')" divider="slash">Pemberhentian</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <flux:custom.show-data :id="$id" :data="$show" :route="route('pemberhentian.index')" />
</app>
