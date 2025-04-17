<?php

namespace App\Livewire\Pemasukan\Pendapatan;

use App\Http\Requests\PendapatanRequest;
use App\Models\Customer;
use App\Models\Pendapatan;
use App\Models\TypeOfIncome;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePendapatan extends Component
{
    public $tanggal, $type_of_income_id, $customer_id, $keterangan, $total, $action, $search = "";
    public $fetchJenisPemasukan, $fetchCustomer;

    public function mount() {
        $this->fetchJenisPemasukan = TypeOfIncome::all();
        $this->fetchCustomer = Customer::whereNotIn('id', function($query) {
                $query->select('customer_id')->from('pendapatans');
            })
            ->get()
            ->map(function($list) {
                $obj = new \stdClass;
                $obj->id = $list->id;
                $obj->name = "[ " . $list->prospectiveCustomer->identification_number . " ] " . $list->prospectiveCustomer->name;
                return $obj;
            });
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function render()
    {
        Gate::authorize('create', Pendapatan::class);
        return view('livewire.pemasukan.pendapatan.create-pendapatan');
    }

    public function store() {
        $request = new PendapatanRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses untuk tambah data.')->error()->toast()->position('top-end')->show();
            return back();
        }

        Pendapatan::create([
            'tanggal' => $this->tanggal,
            'type_of_income_id' => $this->type_of_income_id,
            'customer_id' => $this->customer_id,
            'keterangan' => $this->keterangan,
            'total' => str_replace('.', '', $this->total),
            'employee_id' => Auth::user()->employee_id,
            'area_id' => Auth::user()->area_id,
        ]);

        $this->dispatch(['resetDropdown']);
        $this->reset(['tanggal', 'type_of_income_id', 'customer_id', 'keterangan', 'total']);

        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pemasukan-pendapatan.index');
        }
    }
}
