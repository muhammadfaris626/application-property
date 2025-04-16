<?php

namespace App\Livewire\Pemasukan\KasKecil;

use App\Http\Requests\KasKecilRequest;
use App\Models\Employee;
use App\Models\KasKecil;
use App\Models\ListKasKecil;
use App\Models\TypeOfIncome;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePemasukanKasKecil extends Component
{
    public $date, $employee_id, $action, $search = "";
    public $fetchPenanggungJawab, $fetchJenisPemasukan;
    public $allList = [];

    public function mount() {
        $this->fetchPenanggungJawab = Employee::where('active', 1)->get();
        $this->fetchJenisPemasukan = TypeOfIncome::all();
    }

    public function render()
    {
        Gate::authorize('create', KasKecil::class);
        return view('livewire.pemasukan.kas-kecil.create-pemasukan-kas-kecil');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function addPemasukan() {
        $this->validate([
            'allList.*.type_of_income_id' => 'required',
            'allList.*.desc' => 'required|string',
            'allList.*.total' => 'required|numeric|min:1',
        ], [
            'allList.*.type_of_income_id.required' => 'Kolom jenis pemasukan wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.',
            'allList.*.total.numeric' => 'Total biaya harus berupa angka.',
            'allList.*.total.min' => 'Total biaya minimal harus lebih dari 0.'
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

    public function store() {
        $request = new KasKecilRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty($this->allList)) {
            LivewireAlert::text('Silahkan tambah pemasukan terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }
        $this->validate([
            'allList.*.type_of_income_id' => 'required',
            'allList.*.desc' => 'required',
            'allList.*.total' => 'required'
        ], [
            'allList.*.type_of_income_id.required' => 'Kolom jenis pemasukan wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.'
        ]);
        $create = KasKecil::create([
            'category' => 'Pemasukan',
            'date' => $this->date,
            'employee_id' => $this->employee_id,
            'area_id' => User::where('employee_id', $this->employee_id)->first()->area_id
        ]);
        for ($i=0; $i < count($this->allList); $i++) {
            ListKasKecil::create([
                'kas_kecil_id' => $create->id,
                'type_of_income_id' => $this->allList[$i]['type_of_income_id'],
                'desc' => $this->allList[$i]['desc'],
                'total' => $this->allList[$i]['total']
            ]);
        }
        $this->dispatch('resetDropdown');
        $this->reset(['date', 'employee_id', 'allList']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pemasukan-kas-kecil.index');
        }
    }
}
