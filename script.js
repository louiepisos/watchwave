
document.getElementById('upload-btn').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const video = document.createElement('video');
        video.controls = true;

        const source = document.createElement('source');
        source.src = URL.createObjectURL(file);
        source.type = 'video/mp4';

        video.appendChild(source);
        video.style.maxWidth = '200px';
        video.style.maxHeight = '150px';

        document.getElementById('uploaded-videos').appendChild(video);

        const videoData = {
            src: source.src,
            type: source.type
        };
        localStorage.setItem('uploadedVideo', JSON.stringify(videoData));
    }
});

window.onload = function() {
    const uploadedVideoData = localStorage.getItem('uploadedVideo');
    if (uploadedVideoData) {
        const videoData = JSON.parse(uploadedVideoData);

        const video = document.createElement('video');
        video.controls = true;

        const source = document.createElement('source');
        source.src = videoData.src;
        source.type = videoData.type;

        video.appendChild(source);
        video.style.maxWidth = '200px';
        video.style.maxHeight = '150px';

        document.getElementById('uploaded-videos').appendChild(video);
    }

    loadUploadedVideos();
};

function loadUploadedVideos() {
    fetch('get_uloaded_videos.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(video => {
                const videoElement = document.createElement('video');
                videoElement.controls = true;
                videoElement.src = 'videos/' + video.filename;
                document.getElementById('uploaded-videos').appendChild(videoElement);
            });
        })
        .catch(error => console.error('Error loading uploaded videos:', error));
}