<?php

namespace App\Livewire\Penjualan\CalonUser;

use App\Models\ProspectiveCustomer;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowCalonUser extends Component
{
    public $id, $show;
    public function mount($id) {
        $this->id = $id;
        $list = ProspectiveCustomer::with('employee', 'area')->find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'date' => 'Tanggal',
            'identification_number' => 'Nomor Induk Kependudukan',
            'name' => 'Nama',
            'address' => 'Alamat',
            'whatsapp_number' => 'Nomor WhatsApp',
            'email' => 'Email',
            'employee_id' => 'Nama Marketing',
            'area_id' => 'Area Marketing',
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function ($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'employee_id' => $list->employee->name ?? '-',
                    'area_id' => $list->area->name ?? '-',
                    default => $value ?? '-',
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }
    public function render()
    {
        return view('livewire.penjualan.calon-user.show-calon-user');
    }


}
