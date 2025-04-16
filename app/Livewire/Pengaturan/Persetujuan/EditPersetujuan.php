<?php

namespace App\Livewire\Pengaturan\Persetujuan;

use App\Http\Requests\ApprovalFlowRequest;
use App\Models\ApprovalFlow;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class EditPersetujuan extends Component
{
    public $id, $name, $model_type, $models;
    public function render()
    {
        return view('livewire.pengaturan.persetujuan.edit-persetujuan');
    }

    public function mount($id) {
        $data = ApprovalFlow::findOrFail($id);
        Gate::authorize('update', $data);
        $this->model_type = basename(str_replace("\\", "/", $data->model_type));;
        $this->fill($data->only(['id', 'name']));
        $path = app_path('Models'); // Path ke folder Models

        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $this->models[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }
    }

    public function update() {
        $request = new ApprovalFlowRequest();
        $this->validate($request->rules(), $request->messages());
        $formatModelType = "App\\Models\\" . $this->model_type;
        ApprovalFlow::findOrFail($this->id)->update([
            'name' => $this->name,
            'model_type' => $formatModelType
        ]);
        session()->flash('success', 'Data berhasil diubah.');
        return to_route('persetujuan.index');
    }
}
