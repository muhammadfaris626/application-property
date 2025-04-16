<?php

namespace App\Livewire\Penjualan\KartuKontrol;

use App\Http\Requests\KartuKontrolRequest;
use App\Models\Customer;
use App\Models\KartuKontrol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class EditKartuKontrol extends Component
{
    public $kartuKontrolId;
    public $tanggal, $customer_id, $sbum, $dp, $imb, $sertifikat, $jkk, $listrik, $bestek;
    public $fetchCustomer;
    public $search = "";
    public $nik, $nama, $alamat;
    public $userSelected = false;

    public function mount($id) {
        $this->kartuKontrolId = $id;

        $data = KartuKontrol::with('customer.prospectiveCustomer')->findOrFail($id);
        Gate::authorize('update', $data);
        $this->tanggal     = $data->tanggal;
        $this->customer_id = $data->customer_id;
        $this->sbum        = $data->sbum === 1 ? true : false;
        $this->dp          = $data->dp === 1 ? true : false;
        $this->imb         = $data->imb === 1 ? true : false;
        $this->sertifikat  = $data->sertifikat === 1 ? true : false;
        $this->jkk         = $data->jkk === 1 ? true : false;
        $this->listrik     = $data->listrik === 1 ? true : false;
        $this->bestek      = $data->bestek === 1 ? true : false;

        $existingIds = KartuKontrol::pluck('customer_id')->toArray();
        $dataLama = isset($this->kartuKontrolId) ? KartuKontrol::find($this->kartuKontrolId) : null;
        $this->fetchCustomer = Customer::whereNotIn('id', $existingIds)
            ->when($dataLama, function ($query) use ($dataLama) {
                return $query->orWhere('id', $dataLama->customer_id);
            })
            ->get()
            ->map(function($list) {
                $obj = new \stdClass;
                $obj->id = $list->id;
                $obj->name = "[ " . $list->prospectiveCustomer->identification_number . " ] " . $list->prospectiveCustomer->name;
                return $obj;
            });

        $this->updatedCustomerId(); // Biar langsung isi NIK, nama, alamat saat load
    }

    public function updatedCustomerId() {
        $tampil = Customer::with('prospectiveCustomer')->where('id', $this->customer_id)->first();
        if ($tampil) {
            $this->nik = $tampil->prospectiveCustomer->identification_number;
            $this->nama = $tampil->prospectiveCustomer->name;
            $this->alamat = $tampil->prospectiveCustomer->address;
            $this->userSelected = true;
        } else {
            $this->nik = null;
            $this->nama = null;
            $this->alamat = null;
            $this->userSelected = false;
        }

    }

    public function render()
    {
        return view('livewire.penjualan.kartu-kontrol.edit-kartu-kontrol');
    }

    public function update()
    {
        $request = new KartuKontrolRequest();
        $this->validate($request->rules(), $request->messages());

        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses untuk ubah data.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $data = KartuKontrol::findOrFail($this->kartuKontrolId);
        $data->update([
            'tanggal'    => $this->tanggal,
            'customer_id'=> $this->customer_id,
            'sbum'       => $this->sbum === true ? 1 : null,
            'dp'         => $this->dp === true ? 1 : null,
            'imb'        => $this->imb === true ? 1 : null,
            'sertifikat' => $this->sertifikat === true ? 1 : null,
            'jkk'        => $this->jkk === true ? 1 : null,
            'listrik'    => $this->listrik === true ? 1 : null,
            'bestek'     => $this->bestek === true ? 1 : null,
        ]);

        session()->flash('success', 'Data berhasil diperbarui.');
        return to_route('kartu-kontrol.index');
    }
}
