

<!--<button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-green-700">{{__('messages.traking')}}</button>-->


<form action="{{route('user.orders.cancel',$order->id)}}" method="post">
  @csrf
  @method('PATCH')

  <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-yellow-600">{{__('messages.cancel') }}</button>

</form>






  