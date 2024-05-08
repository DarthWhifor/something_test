@use(App\Models\ProductCategory)

<div>
    <p class="mb-5">
        <a class="link" href="{{ route('admin.products.list-categories') }}">{{ __('Categories') }}</a>
        <span class="dark:text-gray-200">: <b>{{ $productCategory->title }}</b></span>
    </p>
    <div class="clearfix"></div>
    <form method="POST" action="{{ route('admin.products.update-subcategories', $productCategory->id) }}">
        @csrf
        <label for="title" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200">Title</label>
        <input type="text" id="title" name="title" class="lg:w-1/2 h-10" value="{{ $productCategory->title }}"/>
        <label for="parent_parent_id" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 mt-5">Main Category</label>
        <select  class="bg-white  mt-1 border rounded-lg lg:w-1/2 mb-12 h-10" id="parent_parent_id" name="parent_parent_id">
            <option value="{{ $productCategory->getParentParentId() }}" selected>{{ $productCategory->getParentParent() }}</option>
            @foreach ($mainCategories as $m)
                @if($m->id !== $productCategory->id)
                    <option value="{{$m->id}}">{{$m->title}}</option>
                @endif
            @endforeach
        </select>
        <label for="parent_id" class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-200 mt-5">Sub Category</label>
        <select class="bg-white  mt-1 border rounded-lg lg:w-1/2 mb-10 h-10" id="parent_id" name="parent_id">
            <option value="{{ $productCategory->getParentId() }}" selected>{{ $productCategory->getParent() }}</option>
            @foreach ($parentCategories as $p)
                <option value="{{$p->id}}">{{$p->title}}</option>
            @endforeach
        </select>
        <br>
        <button type="submit" class="btn btn-green mt-1">{{ __('Update Category') }}</button>
    </form>
</div>

