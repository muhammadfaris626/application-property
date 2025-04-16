<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Http\Requests\PengajuanInvoiceRequest;
use App\Models\Employee;
use App\Models\PengajuanInvoice;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditPengajuanInvoice extends Component
{
    public $id, $date, $employee_id, $price, $desc, $search = "";
    public $fetchKaryawan;

    public function mount($id) {
        $data = PengajuanInvoice::findOrFail($id);
        Gate::authorize('update', $data);
        $this->fill($data->only(['id', 'date', 'employee_id', 'price', 'desc']));
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }
    public function render()
    {
        return view('livewire.pengeluaran.pengajuan-invoice.edit-pengajuan-invoice');
    }

    public function update() {
        $request = new PengajuanInvoiceRequest();
        $this->validate($request->rules(), $request->messages());
        $cleanPrice = str_replace('.', '', $this->price);
        PengajuanInvoice::findOrFail($this->id)->update([
            'date' => $this->date,
            'employee_id' => $this->employee_id,
            'price' => $cleanPrice,
            'desc' => $this->desc,
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('pengajuan-invoice.index');
    }
}
