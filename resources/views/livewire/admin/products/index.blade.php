<div class="card">
    <div class="mb-5" x-data="{ isOpen: @if($errors->any()) true @else false @endif }">

        <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4
            font-medium rounded-t text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
            {{ __('Add Product') }}
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

                <form action="{{ route('admin.products.add-product') }}" method="POST">
                    @csrf
                    <label for="title" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Title</label>
                    <input type="text" id="title" name="title" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" />
                    @error('title')
                        <p class="error">{{ $message }}</p>
                    @enderror

                    <label for="description" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Description</label>
                    <textarea id="description" name="description" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" rows="4" cols="50"></textarea>
                    @error('description')
                        <p class="error">{{ $message }}</p>
                    @enderror


                    <label for="price" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Price</label>
                    <input type="text" id="price" name="price" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" />
                    @error('price')
                        <p class="error">{{ $message }}</p>
                    @enderror

                    <label for="category_id" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Category</label>
                    <select  class="bg-white  mt-1 border rounded-lg  mb-12 h-10" id="category_id" name="category_id" id="category_id">
                        <option value="" ></option>
                        @foreach ($categories as $m)
                            <option value="{{$m->id}}">{{$m->title}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <br>
                    <button type="submit" class="btn btn-green mt-2" >{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow">
        <table>
            <thead>
            <tr>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($products as $product)
            <tr>
                <td class="flex">
                    <div class="pl-1 pt-1">{{ $product->title }}</div>
                </td>
                <td>{{ $product->getParent() }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>
                    <div class="flex space-x-2">
                        @if(can('add_products'))
                        <a href="{{ route('admin.products.edit-product' , $product->id) }}">{{ __('Edit') }}</a>
                        @endif

                        @if(can('delete_products'))
                        <x-modal>
                            <x-slot name="trigger">
                                <a href="#" @click="on = true">{{ __('Delete') }}</a>
                            </x-slot>

                            <x-slot name="modalTitle">{{ __('Confirm Delete') }}</x-slot>

                            <x-slot name="content">
                                <div class="text-center">
                                    {{ __('Are you sure you want to delete') }}: <b>{{ $product->title }}</b>
                                </div>
                            </x-slot>

                            <x-slot name="footer">
                                <button @click="on = false">{{ __('Cancel') }}</button>
                                <button class="btn btn-red" wire:click="deleteProduct('{{ $product->id }}')">{{ __('Delete Product') }}</button>
                            </x-slot>
                        </x-modal>
                        @endif
                            <a href="{{ route('admin.products.comments' , $product->id) }}">{{ __('Comments') }}</a>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <?php /* {{ $this->products()->links() }} */?>
</div>
