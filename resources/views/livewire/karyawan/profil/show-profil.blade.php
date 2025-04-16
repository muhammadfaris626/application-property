<app>
    <div class="flex flex-col md:flex-row gap-6 justify-between md:items-center mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="#" divider="slash">Karyawan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item :href="route('profil.index')" divider="slash">Profil</flux:breadcrumbs.item>
            <flux:breadcrumbs.item divider="slash">Lihat</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    <div class="grid grid-cols-1">
        <flux:heading size="xl" class="pb-2">Profil Karyawan</flux:heading>
        <div class="border rounded-lg p-4 dark:border-white/10">
            <div class="grid xl:grid-cols-2 lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
                <div>
                    <flux:heading>Nomor Identitas Kepegawaian</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee_number }}</flux:text>
                </div>
                <div>
                    <flux:heading>Nama Karyawan</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->name }}</flux:text>
                </div>
                <div>
                    <flux:heading>Area</flux:heading>
                    <flux:text class="mt-2">{{ $show->area->name }}</flux:text>
                </div>
                <div>
                    <flux:heading>Jabatan</flux:heading>
                    <flux:text class="mt-2">{{ $show->position->name }}</flux:text>
                </div>
                <div>
                    <flux:heading>Nomor Induk Kependudukan</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->identification_number }}</flux:text>
                </div>
                <div>
                    <flux:heading>Alamat</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->address }}</flux:text>
                </div>
                <div>
                    <flux:heading>Tempat Lahir</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->place_of_birth }}</flux:text>
                </div>
                <div>
                    <flux:heading>Tanggal Lahir</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->date_of_birth }}</flux:text>
                </div>
                <div>
                    <flux:heading>Nomor Whatsapp</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->whatsapp_number }}</flux:text>
                </div>
                <div>
                    <flux:heading>Email</flux:heading>
                    <flux:text class="mt-2">{{ $show->employee->email }}</flux:text>
                </div>
                <div>
                    <flux:heading>Status Karyawan</flux:heading>
                    <flux:badge
                        icon="{{ $show->employee->active == 1 ? 'check' : 'x-mark' }}"
                        class="mt-2"
                        color="{{ $show->employee->active == 1 ? 'green' : 'red' }}"
                    >
                        {{ $show->employee->active == 1 ? 'Aktif' : 'Tidak Aktif' }}
                    </flux:badge>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex gap-2">
            <flux:button :href="route('profil.index')" size="sm" variant="danger">Kembali</flux:button>
        </div>
    </div>
</app>
