<?php

namespace App\Livewire\Penjualan\User;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowUser extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = Customer::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'tanggal' => 'Tanggal',
            'nomor_berkas' => 'Nomor Berkas',
            'prospective_customer_id' => 'User',
            'type_of_house_id' => 'Jenis Rumah',
            'keterangan_rumah' => 'Keterangan Rumah',
            'status_penjualan' => 'Status Penjualan',
            'status_pengajuan_user' => 'Status Pengajuan User',
            'verifikasi_dp' => 'Verifikasi DP',
            'upload_berkas' => 'Berkas',
            'employee_id' => 'Yang Mengajukan',

        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'prospective_customer_id' => "NIK : " . $list->prospectiveCustomer->identification_number . " \n NAMA : " . $list->prospectiveCustomer->name . " \n ALAMAT : " . $list->prospectiveCustomer->address,
                    'type_of_house_id' => "AREA : " . $list->typeOfHouse->area->name . " \n JENIS RUMAH : " . $list->typeOfHouse->name,
                    'verifikasi_dp' => $list->verifikasi_dp == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'employee_id' => $list->employee->name,
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.penjualan.user.show-user');
    }
}
