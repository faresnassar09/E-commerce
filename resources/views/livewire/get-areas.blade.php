  <div class="mt-4">

    <select wire:model.live="city_id" id="city">
    <option value="">{{ __('messages.city') }}</option>
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


    <input type="hidden" name="city_id" value="{{$city_id}}">
    <input type="hidden" name="area_id" value="{{$selected_area}}">

</div>