<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      
    <div class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
  
    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
  
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
      <form class="add-staff-modal">
      <div class="bg-white">
         <!-- Modal header -->
         <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                {{$header}}
                </h3>
                <button wire:click="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
        <!-- <div class="flex justify-between table-heading">
            <h4 class="flex justify-center items-center font-bold">{{$header}}</h4>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">            
              <button wire:click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md  px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700  hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            X</button>
            </span>
        </div> -->
        <div class="py-5 px-5">
              <div class="mb-4">
                  <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-medium mb-2">Name:</label>
                  <input type="text" class="shadow appearance-none border rounded w-full text-sm py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" wire:model="name">
                  @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
              </div>
              <div class="mb-4">
                  <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-medium mb-2">Email:</label>
                  <input type="text" class="shadow appearance-none border rounded w-full text-sm py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Email" wire:model="email">
                  @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
              </div>
              <div class="mb-4">
                  <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-medium mb-2">Phone:</label>
                  <input type="tel" class="shadow appearance-none border rounded w-full text-sm py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Phone" wire:model="phone" minlength="10" maxlength="10">
                  @error('phone') <span class="text-red-500">{{ $message }}</span>@enderror
              </div>
        </div>
      </div>
   <!-- Modal footer -->
   <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
   <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-2/5 rounded-md border border-transparent px-4 py-2 bg-dark-blue hover:bg-blue-700 text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            Save
          </button>            
  </div>
      <!-- <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
          <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-purple hover:bg-blue-700 text-base leading-6 font-medium text-white shadow-sm focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
            Save
          </button>
        </span>
        
        </form>
      </div> -->
        
    </div>
</div>
