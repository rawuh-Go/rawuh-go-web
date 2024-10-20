<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Test</title>
</head>

<body>
    <h1>Camera Test</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="snap">Ambil Foto</button>
    <canvas id="canvas" width="640" height="480"></canvas>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const constraints = {
            audio: false,
            video: {
                width: 640, height: 480
            }
        };

        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                console.error(`navigator.getUserMedia error:${e.toString()}`);
            }
        }

        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }

        init();

        snap.addEventListener("click", function () {
            canvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
        });
    </script>
</body>

</html>