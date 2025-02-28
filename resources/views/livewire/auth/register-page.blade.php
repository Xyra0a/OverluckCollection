<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign up</h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a wire:navigate class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/login">
                  Sign in here
                </a>
              </p>
            </div>
            <hr class="my-5 border-slate-300">
            <!-- Form -->
            <form wire:submit.prevent="register">
              <div class="grid gap-y-4">
                <!-- Form Group -->

                <div>
                  <label for="name" class="block text-sm mb-2 dark:text-white">Name</label>
                  <div class="relative">
                    <input type="text" id="name" wire:model="name" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="name-error">
                    @error('name')
                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                            <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>
                        </div>
                    @enderror
                  </div>
                    @error('name')
                        <p class=" text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                  <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                  <div class="relative">
                    <input type="email" id="email" wire:model="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"  aria-describedby="email-error">
                    @error('email')
                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                            <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            </svg>
                        </div>
                    @enderror
                  </div>
                    @error('email')
                        <p class=" text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" id="password" wire:model.defer="password"
                                class="py-2 border px-3 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.9 0-9.27-3.5-11-7 1.73-3.5 6.1-7 11-7 1.26 0 2.48.2 3.625.575m3.56 2.175A10.03 10.03 0 0121 12c-1.73 3.5-6.1 7-11 7a10.03 10.03 0 01-3.625-.675m12.06-10.5l-14 14" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" id="password_confirmation" wire:model.defer="password_confirmation"
                                class="py-2 border px-3 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                                <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.9 0-9.27-3.5-11-7 1.73-3.5 6.1-7 11-7 1.26 0 2.48.2 3.625.575m3.56 2.175A10.03 10.03 0 0121 12c-1.73 3.5-6.1 7-11 7a10.03 10.03 0 01-3.625-.675m12.06-10.5l-14 14" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <!-- End Form Group -->

                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Sign up</button>
              </div>
            </form>
            <!-- End Form -->
            <div class="px-6 sm:px-0 max-w-sm">
                <div class="flex items-center my-4">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500">or</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                <a href="{{ route('google.login') }}"><button  type="button" class="text-white w-full  bg-[#181C14] hover:bg-[#3C3D37  ]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-between mr-2 mb-2"><svg class="mr-2 -ml-1 w-4 h-4" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><path fill="currentColor" d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"></path></svg>Sign up with Google<div></div></button></a>
            </div>
          </div>
        </div>
    </div>
  </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.addEventListener('redirectToRegister', function () {
            setTimeout(function () {
                window.location.href = "{{ route('register') }}";
            }, 3000); // Delay 3 detik sebelum redirect
        });
    });
</script>
