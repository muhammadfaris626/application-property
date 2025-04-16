@props([
    'id',
    'routeName'
])

@can($routeName . ': read')
    <flux:button :href="route($routeName . '.show', $id)" icon="eye" size="xs"></flux:button>
@endcan

@can($routeName . ': update')
    <flux:button :href="route($routeName . '.edit', $id)" icon="pencil-square" size="xs" variant="primary"></flux:button>
@endcan

@can($routeName . ': delete')
    <flux:custom.confirm-delete :id="$id" :action="route($routeName . '.destroy', $id)"/>
@endcan




