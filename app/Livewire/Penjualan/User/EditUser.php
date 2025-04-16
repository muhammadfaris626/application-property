<?php

namespace App\Livewire\Penjualan\User;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\ProspectiveCustomer;
use App\Models\TypeOfHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;

    public $id, $customer;
    public $tanggal, $nomor_berkas, $prospective_customer_id, $type_of_house_id, $keterangan_rumah, $status_penjualan, $status_pengajuan_user, $upload_berkas, $verifikasi_dp;
    public $fetchCalonUser, $fetchJenisRumah, $nik, $nama, $alamat;
    public $upload_berkas_preview;
    public $search = "";
    public $userSelected = false;

    public function mount($id)
    {
        $this->id = $id;
        $customer = Customer::findOrFail($id);
        Gate::authorize('update', $customer);
        $this->customer = $customer;
        $this->fetchCalonUser = ProspectiveCustomer::get()
            ->map(function($list) {
                return (object)[
                    'id' => $list->id,
                    'name' => "[ {$list->identification_number} ] {$list->name}"
                ];
            });

        $this->fetchJenisRumah = TypeOfHouse::get()
            ->map(function($list) {
                return (object)[
                    'id' => $list->id,
                    'name' => "[ {$list->area->name} ] {$list->name} - Rp " . number_format($list->price, 0, ',', '.')
                ];
            });

        $this->tanggal = $customer->tanggal;
        $this->nomor_berkas = $customer->nomor_berkas;
        $this->prospective_customer_id = $customer->prospective_customer_id;
        $this->type_of_house_id = $customer->type_of_house_id;
        $this->keterangan_rumah = $customer->keterangan_rumah;
        $this->status_penjualan = $customer->status_penjualan;
        $this->status_pengajuan_user = $customer->status_pengajuan_user;
        $this->verifikasi_dp = $customer->verifikasi_dp === 1 ? true : false;
        $this->upload_berkas_preview = $customer->upload_berkas;
        $this->userSelected = true;
        $this->nik = $customer->prospectiveCustomer->identification_number;
        $this->nama = $customer->prospectiveCustomer->name;
        $this->alamat = $customer->prospectiveCustomer->address;
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

    public function update()
    {
        $request = new CustomerRequest();
        $this->validate($request->rules(), $request->messages());

        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses.')->error()->toast()->position('top-end')->show();
            return back();
        }

        $filePath = $this->upload_berkas_preview;

        if ($this->upload_berkas) {
            if ($this->customer->upload_berkas && Storage::disk('public')->exists($this->customer->upload_berkas)) {
                Storage::disk('public')->delete($this->customer->upload_berkas);
            }

            $filename = 'berkas_' . now()->format('Ymd_His') . '.' . $this->upload_berkas->getClientOriginalExtension();
            $filePath = $this->upload_berkas->storeAs('berkas-customer', $filename, 'public');
        }

        $this->customer->update([
            'tanggal' => $this->tanggal,
            'nomor_berkas' => $this->nomor_berkas,
            'prospective_customer_id' => $this->prospective_customer_id,
            'type_of_house_id' => $this->type_of_house_id,
            'keterangan_rumah' => $this->keterangan_rumah,
            'status_penjualan' => $this->status_penjualan,
            'status_pengajuan_user' => $this->status_pengajuan_user,
            'verifikasi_dp' => $this->verifikasi_dp === true ? 1 : null,
            'upload_berkas' => $filePath,
        ]);

        session()->flash('success', 'Data berhasil diubah.');
        return to_route('customer.index');
    }

    public function render()
    {
        return view('livewire.penjualan.user.edit-user');
    }
}
