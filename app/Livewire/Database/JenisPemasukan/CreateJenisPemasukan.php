<?php

namespace App\Livewire\Database\JenisPemasukan;

use App\Http\Requests\TypeOfIncomeRequest;
use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateJenisPemasukan extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('viewAny', TypeOfIncome::class);
        return view('livewire.database.jenis-pemasukan.create-jenis-pemasukan');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new TypeOfIncomeRequest();
        $this->validate($request->rules(), $request->messages());
        TypeOfIncome::create([
            'name' => $this->name,
        ]);
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('jenis-pemasukan.index');
        }
    }
}
