<x-filament::section 
    :aside="true" 
    :heading="__('Team Membership')" 
    :description="__('View your team memberships and roles.')"
>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{ $this->form }}
    </form>
</x-filament::section>
