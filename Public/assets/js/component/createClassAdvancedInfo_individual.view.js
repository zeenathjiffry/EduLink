// ---------- Upload Image Button ----------
const imageBtn = document.querySelector('.media-item:first-child .upload-btn');
const thumbnailInput = document.getElementById('thumbnail-input');
const thumbnailName = document.getElementById('thumbnail-name');

// Trigger file explorer
imageBtn.addEventListener('click', () => {
    thumbnailInput.click();
});

// Show selected file name
thumbnailInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        thumbnailName.textContent = `🖼️ Selected: ${file.name}`;
        thumbnailName.style.display = 'block';
    } else {
        thumbnailName.textContent = '';
        thumbnailName.style.display = 'none';
    }
});


// ---------- Upload Video Button ----------
const videoBtn = document.querySelector('.media-item:nth-child(2) .upload-btn');
const videoInput = document.getElementById('video-input');
const videoName = document.getElementById('video-name');

// Trigger file explorer
videoBtn.addEventListener('click', () => {
    videoInput.click();
});

// Show selected file name
videoInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        videoName.textContent = `🎬 Selected: ${file.name}`;
        videoName.style.display = 'block';
    } else {
        videoName.textContent = '';
        videoName.style.display = 'none';
    }
});
