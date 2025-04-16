<?php

namespace App\Livewire\Pengaturan\Persetujuan;

use App\Http\Requests\ApprovalFlowRequest;
use App\Models\ApprovalFlow;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CreatePersetujuan extends Component
{
    public $name, $model_type = '', $action;
    public $models = [];
    public function mount() {
        $path = app_path('Models'); // Path ke folder Models

        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $this->models[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }
    }
    public function render()
    {
        Gate::authorize('create', ApprovalFlow::class);
        return view('livewire.pengaturan.persetujuan.create-persetujuan');
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->store();
    }

    public function store() {
        $request = new ApprovalFlowRequest();
        $this->validate($request->rules(), $request->messages());
        $formatModelType = "App\\Models\\" . $this->model_type;
        ApprovalFlow::create([
            'name' => $this->name,
            'model_type' => $formatModelType
        ]);
        $this->reset(['name', 'model_type']);
        if ($this->action === 'save_and_add') {
            LivewireAlert::text('Data berhasil ditambahkan.')->success()->toast()->position('top-end')->show();
            return back();
        } else {
            session()->flash('success', 'Data berhasil ditambahkan.');
            return to_route('persetujuan.index');
        }
    }
}
