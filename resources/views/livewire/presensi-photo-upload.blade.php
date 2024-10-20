<div class="bg-gradient-to-r from-blue-100 to-purple-100 min-h-screen py-12">
    <div class="container mx-auto max-w-5xl px-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Ambil Foto Presensi</h1>

                <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 shadow-md">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ambil Foto</h2>

                    <div class="mb-4">
                        <video id="video" width="100%" height="auto" autoplay playsinline></video>
                    </div>

                    <div class="flex justify-between">
                        <button id="ambilFotoBtn"
                            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 shadow-md">
                            Ambil Foto
                        </button>
                        <button id="submitPresensiBtn"
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 shadow-md">
                            Submit Presensi
                        </button>
                    </div>
                </div>

                <button wire:click="backToMap"
                    class="mt-4 px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 shadow-md">
                    Kembali ke Peta
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let videoStream;

    document.addEventListener('livewire:load', function () {
        console.log('Livewire loaded, initializing camera');
        initializeCamera();
    });

    function initializeCamera() {
        const video = document.getElementById('video');
        const ambilFotoBtn = document.getElementById('ambilFotoBtn');
        const submitPresensiBtn = document.getElementById('submitPresensiBtn');

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    videoStream = stream;
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function (error) {
                    console.error("Unable to access the camera: ", error);
                    alert("Unable to access the camera. Please make sure you've granted permission.");
                });
        } else {
            alert("Sorry, your browser does not support accessing the camera.");
        }

        ambilFotoBtn.addEventListener('click', function () {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const imageDataUrl = canvas.toDataURL('image/jpeg');
            @this.set('photo', imageDataUrl);
        });

        submitPresensiBtn.addEventListener('click', function () {
            @this.call('submitPresensi');
        });
    }

    document.addEventListener('livewire:navigated', function () {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
        }
    });
</script>