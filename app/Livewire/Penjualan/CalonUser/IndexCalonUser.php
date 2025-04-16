<?php

namespace App\Livewire\Penjualan\CalonUser;

use App\Models\ProspectiveCustomer;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCalonUser extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', ProspectiveCustomer::class);
        $data = ProspectiveCustomer::latest()->paginate(19);
        if ($this->search != null) {
            $data = ProspectiveCustomer::where('date', 'LIKE', '%' . $this->search . '%')
            ->orWhere('identification_number', 'LIKE', '%' . $this->search . '%')
            ->orWhere('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('address', 'LIKE', '%' . $this->search . '%')
            ->orWhere('whatsapp_number', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orWhereHas('employee', function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->latest()->paginate(19);
        }
        return view('livewire.penjualan.calon-user.index-calon-user', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = ProspectiveCustomer::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
