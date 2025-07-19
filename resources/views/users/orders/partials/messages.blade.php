@if(session()->has('success') || session()->has('failed'))
  <div id="flashModal" 
       class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-100 transition-opacity duration-500"
       onclick="backgroundClick(event)">
    <div id="flashContent" 
         class="bg-white rounded-lg shadow-xl p-6 w-96 max-w-full text-center relative transform transition-transform duration-500"
         onclick="event.stopPropagation()">
      
      <button onclick="closeFlashModal()" 
              class="absolute top-3 right-3 text-gray-500 hover:text-gray-900 text-2xl font-bold focus:outline-none">&times;</button>
      
      @if(session()->has('success'))
        <h3 class="text-green-600 text-xl font-semibold mb-3">{{ __('messages.success') }}</h3>
        <p class="text-gray-700">{{ session('success') }}</p>
      @endif

      @if(session()->has('failed'))
        <h3 class="text-red-600 text-xl font-semibold mb-3">{{ __('messages.failed') }}</h3>
        <p class="text-gray-700">{{ session('failed') }}</p>
      @endif

    </div>
  </div>

  <script>
    function closeFlashModal() {
      const modal = document.getElementById('flashModal');
      const content = document.getElementById('flashContent');
      
      modal.style.opacity = '0';
      content.style.transform = 'translateY(-20px)';
      
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 500);
    }

    function backgroundClick(event) {
      if (event.target.id === 'flashModal') {
        closeFlashModal();
      }
    }
  </script>
@endif
