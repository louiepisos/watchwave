document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('upload-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        
        const formData = new FormData(this);

        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert('Upload successful!');
                window.location.reload(); // Reload the page to display the uploaded videos
            } else {
                alert('Upload failed!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Upload failed!');
        });
    });
});
