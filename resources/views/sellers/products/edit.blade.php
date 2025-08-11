@if(isset($product))
    <div id="editModal-{{ $product->id }}" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">

            <form action="{{ route('seller.product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @method('PATCH')
                <div>
                    <label class="block text-gray-700 text-sm">{{__('messages.name')}}</label>
                    <input type="text" name="name" id="editName-{{ $product->id }}" class="w-full p-2 border rounded text-sm" value="{{ $product->name }}">
                </div>

                <div class="mt-2">
                    <label class="block text-gray-700 text-sm">{{__('messages.price')}}</label>
                    <input type="number" name="price" id="editPrice-{{ $product->id }}" class="w-full p-2 border rounded text-sm" value="{{ $product->price }}">
                </div>

                <div class="mt-2">
                    <label class="block text-gray-700 text-sm">{{__('messages.descount')}}</label>
                    <input type="number" name="discount" id="editDiscount-{{ $product->id }}" class="w-full p-2 border rounded text-sm" value="{{ $product->discount }}">
                </div>

                <div class="mt-2">
                    <label class="block text-gray-700 text-sm">{{__('messages.description')}}</label>
                    <textarea name="description" id="editDescription-{{ $product->id }}" class="w-full p-2 border rounded text-sm">{{ $product->description }}</textarea>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 text-sm"> {{__('messages.images')}}</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->images as $image)
                            <div class="relative" id="image-{{ $image->id }}">
                                <img src="{{Storage::url($image->path) }}" class="w-16 h-16 object-cover rounded border">

                                <a href="javascript:void(0)" onclick="deleteImage({{ $image->id }})" class="absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded">X</a>

                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-2">
                    <label class="block text-gray-700 text-sm">{{__('messages.new_images')}}</label>
                    <input type="file" name="images[]" multiple class="w-full p-2 border rounded text-sm">
                </div>

                <div class="flex justify-between mt-3">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm">{{__('messages.save')}}</button>

                    <button type="button" onclick="closeEditModal({{ $product->id }})" class="bg-red-500 text-white px-4 py-2 rounded text-sm">{{__('messages.close')}}</button>
                </div>
            </form>


        </div>
    </div>
@endif

<script>
    function deleteImage(imageId) {
        if (!confirm("{{__('messages.confirm_delete_image')}}")) return;

        fetch(`{{ url('api/seller/products-managemt/delete-image') }}/${imageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for security
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert("{{__('messages.image_deleted_success')}}");
                  document.getElementById(`image-${imageId}`).remove();
              } else {
                  alert("{{__('messages.something_went_wrong')}}");
              }
          }).catch(error => console.error('Error:', error));
    }
</script>