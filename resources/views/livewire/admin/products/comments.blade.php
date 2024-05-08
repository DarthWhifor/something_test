<div class="card">
    <h4>{{ $product->title }} - comments</h4>
    <div class="overflow">
        <table>
            <thead>
            <tr>
                <th>{{ __('Text') }}</th>
                <th>{{ __('Rating') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($product->comments as $com)
                <tr>
                    <form action="{{ route('admin.products.update', $com->id) }}" method="POST">
                        @csrf
                        <td class="">
                            <div class="pl-1 pt-1">
                                <textarea id="comment_text" name="comment_text" class="bg-white  mt-1 border rounded-lg  mb-12 " rows="8" cols="100">{{ $com->comment_text }}</textarea>
                            </div>
                        </td>
                        <td>
                            <select  class="bg-white  mt-1 border rounded-lg  mb-12 h-10" id="rating" name="rating">
                                <option value="{{ $com->rating }}" >{{ $com->rating }}</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                <button type="submit" class="btn btn-blue">{{ __('Update') }}</button>
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true" class="btn btn-red">{{ __('Delete') }}</a>
                                        </x-slot>

                                        <x-slot name="modalTitle">{{ __('Confirm Delete') }}</x-slot>

                                        <x-slot name="content">
                                            <div class="text-center">
                                                {{ __('Are you sure you want to delete') }}: <b>This comment</b>
                                            </div>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <button @click="on = false">{{ __('Cancel') }}</button>
                                            <button class="btn btn-red" wire:click="deleteComment('{{ $com->id }}')">{{ __('Delete Comment') }}</button>
                                        </x-slot>
                                    </x-modal>
                            </div>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
