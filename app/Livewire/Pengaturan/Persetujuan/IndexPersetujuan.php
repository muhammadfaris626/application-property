<?php

namespace App\Livewire\Pengaturan\Persetujuan;

use App\Models\ApprovalFlow;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPersetujuan extends Component
{
    use WithPagination;
    public $search;
    protected $updateQueryString = [
        ['page' => ['except' => 1]],
        ['search' => ['except' => '']]
    ];
    public function render()
    {
        Gate::authorize('viewAny', ApprovalFlow::class);
        $data = ApprovalFlow::latest()->paginate(19);
        if ($this->search != null) {
            $data = ApprovalFlow::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('model_type', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(19);
        }
        return view('livewire.pengaturan.persetujuan.index-persetujuan', [
            'fetch' => $data
        ]);
    }

    public function destroy($id) {
        $data = ApprovalFlow::findOrFail($id);
        Gate::authorize('delete', $data);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
