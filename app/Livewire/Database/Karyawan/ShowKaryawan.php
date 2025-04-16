<?php

namespace App\Livewire\Database\Karyawan;

use App\Models\Employee;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowKaryawan extends Component
{
    public $id, $show;
    public function render()
    {
        return view('livewire.database.karyawan.show-karyawan');
    }

    public function mount($id) {
        $this->id = $id;
        $list = Employee::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'identification_number' => 'Nomor Induk Kependudukan',
            'name' => 'Nama',
            'address' => 'Alamat',
            'place_of_birth' => 'Tempat Lahir',
            'date_of_birth' => 'Tanggal Lahir',
            'whatsapp_number' => 'Nomor Whatsapp',
            'email' => 'Email'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);

    }
}
