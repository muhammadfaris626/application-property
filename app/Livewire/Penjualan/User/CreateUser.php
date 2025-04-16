<?php

namespace App\Livewire\Penjualan\User;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\ProspectiveCustomer;
use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUser extends Component
{
    use WithFileUploads;
    public $tanggal, $nomor_berkas, $prospective_customer_id, $type_of_house_id, $keterangan_rumah, $status_penjualan = "", $status_pengajuan_user = "", $upload_berkas, $verifikasi_dp;
    public $fetchCalonUser, $fetchJenisRumah, $nik, $nama, $alamat;
    public $search = "", $action;
    public $userSelected = false;

    public function mount() {
        $this->fetchCalonUser = ProspectiveCustomer::get()
            ->map(function($list) {
                $obj = new \stdClass;
                $obj->id = $list->id;
                $obj->name = "[ " . $list->identification_number . " ] " . $list->name;
                return $obj;
            });
        $this->fetchJenisRumah = TypeOfHouse::get()
            ->map(function($list) {
                $obj = new \stdClass;
                $obj->id = $list->id;
                $obj->name = "[ " . $list->area->name . " ] " . $list->name . " - Rp " . number_format($list->price, 0, ',', '.');
                return $obj;
            });
    }

    public function updatedProspectiveCustomerId($value)
    {
        $tampil = ProspectiveCustomer::find($value);

        if ($tampil) {
            $this->nik = $tampil->identification_number;
            $this->nama = $tampil->name;
            $this->alamat = $tampil->address;
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
        Gate::authorize('create', Customer::class);
        return view('livewire.penjualan.user.create-user');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new CustomerRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses untuk tambah data.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $this->validate([
            'upload_berkas' => 'required|file|mimes:pdf|max:2048',
        ], [
            'upload_berkas.required' => 'Kolom upload berkas wajib diisi.',
            'upload_berkas.mimes' => 'File berkas harus dalam format PDF.',
            'upload_berkas.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $filename = 'berkas_' . now()->format('Ymd_His') . '.' . $this->upload_berkas->getClientOriginalExtension();
        $filePath = $this->upload_berkas->storeAs('berkas-customer', $filename, 'public');

        Customer::create([
            'tanggal' => $this->tanggal,
            'nomor_berkas' => $this->nomor_berkas,
            'prospective_customer_id' => $this->prospective_customer_id,
            'type_of_house_id' => $this->type_of_house_id,
            'keterangan_rumah' => $this->keterangan_rumah,
            'status_penjualan' => $this->status_penjualan,
            'status_pengajuan_user' => $this->status_pengajuan_user,
            'verifikasi_dp' => $this->verifikasi_dp === true ? 1 : null,
            'upload_berkas' => $filePath,
            'employee_id' => Auth::user()->employee_id
        ]);

        $this->dispatch(['resetDropdown']);
        $this->reset([
            'tanggal', 'nomor_berkas', 'prospective_customer_id', 'type_of_house_id',
            'status_penjualan', 'status_pengajuan_user', 'verifikasi_dp',
            'upload_berkas'
        ]);

        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('customer.index');
        }
    }
}
