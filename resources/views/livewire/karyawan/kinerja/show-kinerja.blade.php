<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('kinerja.index')" divider="slash">Kinerja</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <flux:separator />
    <div class="grid grid-cols-1 gap-4 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1 flex flex-col gap-4">
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Calon Nasabah / Hari</flux:subheading>
                    <flux:heading size="xl">{{ $totalHarian }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Calon Nasabah / Minggu</flux:subheading>
                    <flux:heading size="xl">{{ $totalMingguan }}</flux:heading>
                </div>
                <div class="relative rounded-lg p-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Total Calon Nasabah / Bulan</flux:subheading>
                    <flux:heading size="xl">{{ $totalBulanan }}</flux:heading>
                </div>
            </div>
            <div class="md:col-span-2 flex flex-col gap-4">
                <div class="relative flex-1 rounded-lg bg-zinc-50 text-center px-4 pt-4">
                    <flux:custom.column-chart-basic :data="$columnChartKinerja" :title="'Total Kinerja'" :label="'chart-kinerja'" :useRupiah="false" />
                </div>
            </div>
        </div>
    </div>
</app>
