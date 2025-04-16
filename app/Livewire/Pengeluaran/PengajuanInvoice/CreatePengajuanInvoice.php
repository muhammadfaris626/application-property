<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Http\Requests\PengajuanInvoiceRequest;
use App\Models\Employee;
use App\Models\PengajuanInvoice;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePengajuanInvoice extends Component
{
    public $date, $employee_id, $price, $desc, $action, $search = "";
    public $fetchKaryawan;

    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }

    public function render()
    {
        Gate::authorize('create', PengajuanInvoice::class);
        return view('livewire.pengeluaran.pengajuan-invoice.create-pengajuan-invoice');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new PengajuanInvoiceRequest();
        $this->validate($request->rules(), $request->messages());
        PengajuanInvoice::create([
            'date' => $this->date,
            'employee_id' => $this->employee_id,
            'price' => str_replace('.', '', $this->price),
            'desc' => $this->desc
        ]);
        $this->dispatch('resetDropdown');
        $this->reset(['date', 'employee_id', 'price', 'desc']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pengajuan-invoice.index');
        }
    }
}
