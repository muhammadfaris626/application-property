@props([
    'routeName'
])
@can($routeName . ': create')
    <flux:separator vertical class="my-2" />
    <flux:button :href="route($routeName . '.create')" icon="plus" size="sm" variant="primary">Tambah Data</flux:button>
@endcan

