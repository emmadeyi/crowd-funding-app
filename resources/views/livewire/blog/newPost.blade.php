<x-jet-dialog-modal wire:model="showPostsModal">
    <x-slot name="title">
        {{ __('Create a Post') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="title" value="{{ __('Title') }}" />
            <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" wire:model.defer="state.title" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="body" value="{{ __('Body') }}" />
            <x-jet-input id="body" class="block mt-1 w-full" type="text" name="body" :value="old('body')" required autofocus autocomplete="body" wire:model.defer="state.body" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$set('showPostsModal', false)" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-jet-secondary-button>
        <x-jet-button wire:click="savePost">
            {{ __('Save')}}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>