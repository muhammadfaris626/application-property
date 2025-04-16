<?php

namespace App\Livewire\Pengaturan\Persetujuan;

use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowPersetujuan extends Component
{
    public $show, $fetch;
    public function mount($id) {
        $this->show = ApprovalFlow::find($id);
        Gate::authorize('view', $this->show);
        $this->fetch = ApprovalStep::where('approval_flow_id', $id)->get();
    }
    public function render()
    {
        return view('livewire.pengaturan.persetujuan.show-persetujuan');
    }

    public function destroy($id) {
        $data = ApprovalStep::findOrFail($id);
        $data->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        return back();
    }
}
