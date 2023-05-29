<x-filament::page>
    <x-filament::form wire:submit.prevent="create">
        {{ $this->form }}

        <!-- <x-filament::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        /> -->
        <x-filament::button type="submit" >
        Submit
        </x-filament::button>
    </x-filament::form>
</x-filament::page>
