<div class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen py-12">
    <div class="container mx-auto max-w-5xl px-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Upload Foto Presensi</h1>

                <!-- Photo Upload Form -->
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ambil Foto</h2>

                    @if (session()->has('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form wire:submit.prevent="capturePhoto" class="space-y-4">
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Pilih atau Ambil
                                Foto</label>
                            <input type="file" wire:model="photo" id="photo" accept="image/*" capture="user" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            " />
                            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit"
                            class="w-full px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 shadow-md">
                            Submit Presensi dengan Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>