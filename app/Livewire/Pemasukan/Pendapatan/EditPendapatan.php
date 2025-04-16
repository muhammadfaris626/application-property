<?php

namespace App\Livewire\Pemasukan\Pendapatan;

use App\Http\Requests\PendapatanRequest;
use App\Models\Customer;
use App\Models\Pendapatan;
use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditPendapatan extends Component
{
    public $pendapatanId;
    public $tanggal, $type_of_income_id, $customer_id, $keterangan, $total;
    public $fetchJenisPemasukan, $fetchCustomer;

    public function mount($id)
    {
        $this->pendapatanId = $id;

        $pendapatan = Pendapatan::findOrFail($id);
        Gate::authorize('update', $pendapatan);

        $this->tanggal = $pendapatan->tanggal;
        $this->type_of_income_id = $pendapatan->type_of_income_id;
        $this->customer_id = $pendapatan->customer_id;
        $this->keterangan = $pendapatan->keterangan;
        $this->total = number_format($pendapatan->total, 0, '', '.'); // Format agar tampilannya sesuai input awal

        $this->fetchJenisPemasukan = TypeOfIncome::all();

        // Tambahkan customer sekarang + yang belum dipakai di pendapatan
        $this->fetchCustomer = Customer::where(function ($query) use ($pendapatan) {
            $query->whereNotIn('id', function ($subQuery) {
                $subQuery->select('customer_id')->from('pendapatans');
            })
            ->orWhere('id', $pendapatan->customer_id); // tetap tampilkan customer yang sekarang
        })
        ->get()
        ->map(function ($list) {
            $obj = new \stdClass;
            $obj->id = $list->id;
            $obj->name = "[ " . $list->prospectiveCustomer->identification_number . " ] " . $list->prospectiveCustomer->name;
            return $obj;
        });
    }
    public function render()
    {
        return view('livewire.pemasukan.pendapatan.edit-pendapatan');
    }

    public function update()
    {
        $request = new PendapatanRequest();
        $this->validate($request->rules(), $request->messages());

        $pendapatan = Pendapatan::findOrFail($this->pendapatanId);

        $pendapatan->update([
            'tanggal' => $this->tanggal,
            'type_of_income_id' => $this->type_of_income_id,
            'customer_id' => $this->customer_id,
            'keterangan' => $this->keterangan,
            'total' => str_replace('.', '', $this->total),
        ]);

        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('pemasukan-pendapatan.index');
    }
}
