<div>

<form method="POST" action="">
                        @csrf
                        @method("PATCH")

                        <select wire:change = "changeStatus($event.target.value)" name="status" class="text-sm border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">


                            <option value="0">يتم التجهيز</option>
                            <option value="1">تم التسليم</option>
                            <option value="2">الغاء</option>

                        </select>

                        
                    </form>


                    @if(session()->has('failed'))

{{ session()->get('failed') }}
    
@endif 
</div>
