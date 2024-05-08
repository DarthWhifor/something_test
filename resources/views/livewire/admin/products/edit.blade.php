
<div class="card">
    <div class="flex justify-between">
        <h2 class="mb-5">{{ $product->title }}</h2>
    </div>

    <form action="{{ route('admin.products.update-product', $product->id) }}" method="POST">
        @csrf
        <label for="title" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Title</label>
        <input type="text" id="title" name="title" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" value="{{ $product->title }}"/>
        @error('title')
        <p class="error">{{ $message }}</p>
        @enderror

        <label for="description" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Description</label>
        <textarea id="description" name="description" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" rows="4" cols="50">{{ $product->description }}</textarea>
        @error('description')
        <p class="error">{{ $message }}</p>
        @enderror


        <label for="price" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Price</label>
        <input type="text" id="price" name="price" class="bg-white  mt-1 border rounded-lg  mb-12 h-10" value="{{ $product->price }}"/>
        @error('price')
        <p class="error">{{ $message }}</p>
        @enderror

        <label for="category_id" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Category</label>
        <select  class="bg-white  mt-1 border rounded-lg  mb-12 h-10" id="category_id" name="category_id" id="category_id">
            <option value="{{ $product->getParentId() }}" >{{ $product->getParent() }}</option>
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

    <form action="{{ route('admin.products.update-gallery', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="gallery" class="mt-10 block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">
            Gallery
        </label>
        <input class="border" id="gallery" name="gallery[]" type="file" multiple/>
        @foreach($imageExist as $image)
            @if($image->main == \App\Models\Photo::PHOTO_MAIN)
            <label for="p" class="mt-5 block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Main photo</label>
            @endif
            <img id="p" name="p" src="{{ storage_url($image->path) }}" width="100px" class="mt-2 mb-5 border">
        @endforeach
        <button type="submit" class="btn btn-yellow mt-2">{{ __('Update gallery') }}</button>
    </form>
</div>


