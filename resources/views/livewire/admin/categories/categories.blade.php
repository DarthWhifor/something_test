<div class="card">
    <div class="mb-5" x-data="{ isOpen: false }">

        <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4
            font-medium rounded-t text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
            {{ __('Add Category') }}
        </button>
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-400 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-400 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-gray-200 dark:bg-gray-700 rounded-b-md p-5"
            wire:ignore.self>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-1">
                <x-form.input type="text" id="title" name="title" :label="__('Category titile')" wire:model="title" />
            </div>
            <button type="submit" class="btn btn-green" wire:click="addCategory()">{{ __('Save') }}</button>
        </div>

    </div>

    <div class="overflow">
        <table>
            <thead>
            <tr>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Main category') }}</th>
                <th>{{ __('Subcategory') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($productCategories as $category)
                <tr>
                    <td class="flex">
                        <div class="pl-1 pt-1">{{ $category->title }}</div>
                    </td>
                    <td>{{ $category->getParentParent() }}</td>
                    <td>{{ $category->getParent() }}</td>
                    <td>
                        <div class="flex space-x-2">
                            @if(can('add_categories'))
                                <a href="{{ route('admin.products.subcategories' , $category->id) }}">{{ __('Edit') }}</a>
                            @endif

                            @if(can('delete_categories'))
                                <x-modal>
                                    <x-slot name="trigger">
                                        <a href="#" @click="on = true">{{ __('Delete') }}</a>
                                    </x-slot>

                                    <x-slot name="modalTitle">{{ __('Confirm Delete') }}</x-slot>

                                    <x-slot name="content">
                                        <div class="text-center">
                                            {{ __('Are you sure you want to delete') }}: <b>{{ $category->title }}</b>
                                        </div>
                                    </x-slot>

                                    <x-slot name="footer">
                                        <button @click="on = false">{{ __('Cancel') }}</button>
                                        <button class="btn btn-red" wire:click="deleteCategory('{{ $category->id }}')">{{ __('Delete Category') }}</button>
                                    </x-slot>
                                </x-modal>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <?php /* {{ $this->productCategories()->links() }} */?>
</div>
