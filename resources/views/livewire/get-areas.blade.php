  <div class="mt-4">

    <select wire:model.live="city_id" id="city">
        <option value="">{{__('messages.city')}}</option>
        @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endforeach
    </select>


    <select wire:model.live="selected_area" id="area">
        <option value="">{{__('messages.area')}}</option>
@foreach($areas as $area)

        <option value="{{$area->id}}">{{$area->name}}</option>

@endforeach
    </select>


            <x-input-label for="street" :value="__('messages.street')" />
            <x-text-input id="street" class="block mt-1 w-full" type="text" name="address[street]" :value="old('street')" autocomplete="street" />
            <x-input-error :messages="$errors->get('street')" class="mt-2" />

    <input type="hidden" name="address[city_id]" value="{{ $city_id }}">
    <input type="hidden" name="address[area_id]" value="{{$selected_area}}">

</div>