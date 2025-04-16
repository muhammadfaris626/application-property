<?php

namespace App\Livewire\Pemasukan\KasBesar;

use App\Models\Employee;
use App\Models\KasBesar;
use App\Models\ListKasBesar;
use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditPemasukanKasBesar extends Component
{
    public $id, $date, $employee_id;
    public $fetchKaryawan, $search = "", $fetchJenisPemasukan;
    public $allList = [];

    public function mount($id) {
        $this->id = $id;
        $data = KasBesar::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only('id', 'date', 'employee_id'));
        $this->fetchKaryawan = Employee::where('active', 1)->get();
        $this->allList = ListKasBesar::where('kas_besar_id', $id)
            ->get()
            ->map(function ($pemasukan) {
                return [
                    'type_of_income_id' => $pemasukan->type_of_income_id,
                    'desc' => $pemasukan->desc,
                    'total' => $pemasukan->total
                ];
            })->toArray();
        $this->fetchJenisPemasukan = TypeOfIncome::all();
    }

    public function addPemasukan() {
        $this->validate([
            'allList.*.type_of_income_id' => 'required',
            'allList.*.desc' => 'required',
            'allList.*.total' => 'required'
        ], [
            'allList.*.type_of_income_id.required' => 'Kolom jenis pemasukan wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.'
        ]);
        $this->allList[] = [
            'type_of_income_id' => null,
            'desc' => '',
            'total' => ''
        ];
    }

    public function removePemasukan($index) {
        unset($this->allList[$index]);
        $this->allList = array_values($this->allList);
    }

    public function render()
    {
        return view('livewire.pemasukan.kas-besar.edit-pemasukan-kas-besar');
    }

    public function update() {
        if (empty($this->allList)) {
            LivewireAlert::text('Silahkan tambah pemasukan terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $this->validate([
            'date' => 'required',
            'employee_id' => 'required',
            'allList.*.type_of_income_id' => 'required',
            'allList.*.desc' => 'required',
            'allList.*.total' => 'required'
        ], [
            'date.required' => 'Kolom tanggal wajib diisi.',
            'employee_id.required' => 'Kolom penanggung jawab wajib diisi.',
            'allList.*.type_of_income_id.required' => 'Kolom jenis pemasukan wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.'
        ]);

        KasBesar::findOrFail($this->id)->update([
            'date' => $this->date,
            'employee_id' => $this->employee_id
        ]);

        ListKasBesar::where('kas_besar_id', $this->id)->delete();
        foreach ($this->allList as $key => $value) {
            ListKasBesar::create([
                'kas_besar_id' => $this->id,
                'type_of_income_id' => $value['type_of_income_id'],
                'desc' => $value['desc'],
                'total' => $value['total'],
            ]);
        }
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('pemasukan-kas-besar.index');
    }
}
