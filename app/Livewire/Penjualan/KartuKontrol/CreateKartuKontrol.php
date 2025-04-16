<?php

namespace App\Livewire\Penjualan\KartuKontrol;

use App\Http\Requests\KartuKontrolRequest;
use App\Models\Customer;
use App\Models\KartuKontrol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreateKartuKontrol extends Component
{
    public $tanggal, $customer_id, $sbum, $dp, $imb, $sertifikat, $jkk, $listrik, $bestek;
    public $fetchCustomer;
    public $search = "", $action;
    public $nik, $nama, $alamat;

    public function mount() {
        $this->fetchCustomer = Customer::get()
            ->map(function($list) {
                $obj = new \stdClass;
                $obj->id = $list->id;
                $obj->name = "[ " . $list->prospectiveCustomer->identification_number . " ] " . $list->prospectiveCustomer->name;
                return $obj;
            });
    }

    public function updatedCustomerId() {
        $tampil = Customer::where('id', $this->customer_id)->first();
        $this->nik = $tampil->prospectiveCustomer->identification_number;
        $this->nama = $tampil->prospectiveCustomer->name;
        $this->alamat = $tampil->prospectiveCustomer->address;
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function render()
    {
        Gate::authorize('create', KartuKontrol::class);
        return view('livewire.penjualan.kartu-kontrol.create-kartu-kontrol');
    }

    public function store() {
        $request = new KartuKontrolRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses untuk tambah data.')->error()->toast()->position('top-end')->show();
            return back();
        }

        KartuKontrol::create([
            'tanggal' => $this->tanggal,
            'customer_id' => $this->customer_id,
            'sbum' => $this->sbum === true ? 1 : null,
            'dp' => $this->dp === true ? 1 : null,
            'imb' => $this->imb === true ? 1 : null,
            'sertifikat' => $this->sertifikat === true ? 1 : null,
            'jkk' => $this->jkk === true ? 1 : null,
            'listrik' => $this->listrik === true ? 1 : null,
            'bestek' => $this->bestek === true ? 1 : null,
        ]);

        $this->dispatch(['resetDropdown']);
        $this->reset([
            'tanggal', 'customer_id', 'sbum', 'dp', 'imb',
            'sertifikat', 'jkk', 'listrik', 'bestek'
        ]);

        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('kartu-kontrol.index');
        }
    }
}
