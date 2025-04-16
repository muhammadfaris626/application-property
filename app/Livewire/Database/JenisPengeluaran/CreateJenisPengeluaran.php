<?php

namespace App\Livewire\Database\JenisPengeluaran;

use App\Http\Requests\TypeOfExpenditureRequest;
use App\Models\TypeOfExpenditure;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateJenisPengeluaran extends Component
{
    public $name, $action;
    public function render()
    {
        Gate::authorize('create', TypeOfExpenditure::class);
        return view('livewire.database.jenis-pengeluaran.create-jenis-pengeluaran');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new TypeOfExpenditureRequest();
        $this->validate($request->rules(), $request->messages());
        TypeOfExpenditure::create([
            'name' => $this->name,
        ]);
        $this->reset(['name']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('jenis-pengeluaran.index');
        }
    }
}
