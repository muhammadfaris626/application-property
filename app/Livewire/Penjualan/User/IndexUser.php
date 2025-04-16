<?php

namespace App\Livewire\Penjualan\User;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUser extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];

    public function render()
    {
        Gate::authorize('viewAny', Customer::class);
        $data = Customer::latest()->paginate(19);
        if ($this->search != null) {
            $data = Customer::where('tanggal', 'LIKE', '%' . $this->search . '%')
            ->orWhere('nomor_berkas', 'LIKE', '%' . $this->search . '%')
            ->orWhere('status_penjualan', 'LIKE', '%' . $this->search . '%')
            ->orWhere('status_pengajuan_user', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('employee', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('prospectiveCustomer', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->orWhereHas('typeOfHouse', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->latest()->paginate(19);
        }
        return view('livewire.penjualan.user.index-user', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = Customer::findOrFail($id);
        Gate::authorize('delete', $data);

        // Hapus file jika ada dan pastikan di disk 'public'
        if ($data->upload_berkas && Storage::disk('public')->exists($data->upload_berkas)) {
            Storage::disk('public')->delete($data->upload_berkas);
        }

        $data->delete();

        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
