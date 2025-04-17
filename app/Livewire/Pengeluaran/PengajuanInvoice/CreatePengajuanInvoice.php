<?php

namespace App\Livewire\Pengeluaran\PengajuanInvoice;

use App\Http\Requests\PengajuanInvoiceRequest;
use App\Models\ApprovalFlow;
use App\Models\ApprovalStep;
use App\Models\Employee;
use App\Models\PengajuanInvoice;
use App\Models\Position;
use App\Models\Structure;
use App\Models\User;
use App\Notifications\PengajuanInvoiceNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CreatePengajuanInvoice extends Component
{
    public $date, $employee_id, $price, $desc, $action, $search = "";
    public $fetchKaryawan;

    public function mount() {
        $this->fetchKaryawan = Employee::where('active', 1)->get();
    }

    public function render()
    {
        Gate::authorize('create', PengajuanInvoice::class);
        return view('livewire.pengeluaran.pengajuan-invoice.create-pengajuan-invoice');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new PengajuanInvoiceRequest();
        $this->validate($request->rules(), $request->messages());
        if (empty(Auth::user()?->employee_id)) {
            LivewireAlert::text('Anda tidak punya akses untuk tambah data.')->error()->toast()->position('top-end')->show();
            return back();
        }
        $create = PengajuanInvoice::create([
            'date' => $this->date,
            'employee_id' => Auth::user()->employee_id,
            'area_id' => Auth::user()->area_id,
            'price' => str_replace('.', '', $this->price),
            'desc' => $this->desc
        ]);

        $flow = ApprovalFlow::where('model_type', 'App\Models\PengajuanInvoice')->first();
        $step = ApprovalStep::where('approval_flow_id', $flow->id)->where('step', 1)->first();

        $jabatan = Position::where('id', $step->position_id)->first();
        $struktur = Structure::where('position_id', $jabatan->id)->first();
        $penerima = User::where('employee_id', $struktur->employee_id)->first();
        $penerima->notify(new PengajuanInvoiceNotification($create));

        $this->dispatch('resetDropdown');
        $this->reset(['date', 'employee_id', 'price', 'desc']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('pengajuan-invoice.index');
        }
    }
}
