<?php

namespace App\Livewire\Pengeluaran\KasKecil;

use App\Http\Requests\KasKecilRequest;
use App\Models\Employee;
use App\Models\KasKecil;
use App\Models\ListKasKecil;
use App\Models\TypeOfExpenditure;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePengeluaranKasKecil extends Component
{
    public $date, $employee_id, $action, $search = "";
    public $fetchPenanggungJawab, $fetchJenisPengeluaran;
    public $allList = [];

    public function mount() {
        $this->fetchPenanggungJawab = Employee::where('active', 1)->get();
        $this->fetchJenisPengeluaran = TypeOfExpenditure::all();
    }

    public function render()
    {
        Gate::authorize('create', KasKecil::class);
        return view('livewire.pengeluaran.kas-kecil.create-pengeluaran-kas-kecil');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function addPengeluaran() {
        $this->validate([
            'allList.*.type_of_expenditure_id' => 'required',
            'allList.*.desc' => 'required|string',
            'allList.*.total' => 'required|numeric|min:1',
        ], [
            'allList.*.type_of_expenditure_id.required' => 'Kolom jenis pengeluaran wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.',
            'allList.*.total.numeric' => 'Total biaya harus berupa angka.',
            'allList.*.total.min' => 'Total biaya minimal harus lebih dari 0.'
        ]);

        $this->allList[] = [
            'type_of_expenditure_id' => null,
            'desc' => '',
            'total' => ''
        ];
    }

    public function removePengeluaran($index) {
        unset($this->allList[$index]);
        $this->allList = array_values($this->allList);
    }

    public function store() {
        $request = new KasKecilRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty($this->allList)) {
            LivewireAlert::text('Silahkan tambah pengeluaran terlebih dahulu.')->error()->toast()->position('top-end')->show();
            return back();
        }
        $this->validate([
            'allList.*.type_of_expenditure_id' => 'required',
            'allList.*.desc' => 'required',
            'allList.*.total' => 'required'
        ], [
            'allList.*.type_of_expenditure_id.required' => 'Kolom jenis pengeluaran wajib diisi.',
            'allList.*.desc.required' => 'Kolom keterangan wajib diisi.',
            'allList.*.total.required' => 'Kolom total biaya wajib diisi.'
        ]);
        $create = KasKecil::create([
            'category' => 'Pengeluaran',
            'date' => $this->date,
            'employee_id' => $this->employee_id,
            'area_id' => User::where('employee_id', $this->employee_id)->first()->area_id
        ]);
        for ($i=0; $i < count($this->allList); $i++) {
            ListKasKecil::create([
                'kas_kecil_id' => $create->id,
                'type_of_expenditure_id' => $this->allList[$i]['type_of_expenditure_id'],
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
            return to_route('pengeluaran-kas-kecil.index');
        }
    }
}
