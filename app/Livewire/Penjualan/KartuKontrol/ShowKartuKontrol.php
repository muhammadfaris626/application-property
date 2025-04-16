<?php

namespace App\Livewire\Penjualan\KartuKontrol;

use App\Models\KartuKontrol;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowKartuKontrol extends Component
{
    public $id, $show;

    public function mount($id) {
        $this->id = $id;
        $list = KartuKontrol::find($id);
        Gate::authorize('view', $list);
        $fieldNames = [
            'tanggal' => 'Tanggal',
            'customer_id' => 'User',
            'sbum' => 'SBUM',
            'dp' => 'DP',
            'imb' => 'IMB',
            'sertifikat' => 'SERTIFIKAT',
            'jkk' => 'JKK',
            'listrik' => 'LISTRIK',
            'bestek' => 'BESTEK'
        ];
        $data = $list ? $list->toArray() : [];
        $filteredData = array_intersect_key($data, $fieldNames);
        $this->show = array_map(function($key, $value) use ($list, $fieldNames) {
            return [
                'name' => $fieldNames[$key],
                'value' => match ($key) {
                    'customer_id' => "NIK : " . $list->customer->prospectiveCustomer->identification_number . "\n NAMA : " . $list->customer->prospectiveCustomer->name . "\n ALAMAT : " . $list->customer->prospectiveCustomer->address,
                    'sbum' => $list->sbum == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'dp' => $list->dp == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'imb' => $list->imb == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'sertifikat' => $list->sertifikat == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'jkk' => $list->jkk == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'listrik' => $list->listrik == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    'bestek' => $list->bestek == 1 ? 'Terverifikasi' : 'Belum diverifikasi',
                    default => $value ?? '-'
                }
            ];
        }, array_keys($filteredData), $filteredData);
    }

    public function render()
    {
        return view('livewire.penjualan.kartu-kontrol.show-kartu-kontrol');
    }
}
