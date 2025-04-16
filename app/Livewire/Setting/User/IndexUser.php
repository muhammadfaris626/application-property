<?php

namespace App\Livewire\Setting\User;

use App\Models\User;
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
    public function render() {
        $data = User::latest()->paginate(15);
        if ($this->search != null) {
            $data = User::where('email', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->latest()->paginate(15);
        }
        return view('livewire.setting.user.index-user', [
            'fetch' => $data
        ]);
    }
}
