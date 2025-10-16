//Upload Image button direction to file explorer
document.getElementById('upload-thumbnail-btn').addEventListener('click', function() {
    document.getElementById('thumbnail-input').click(); // Open file explorer
});

//Preview uploaded image
const fileInput = document.getElementById('thumbnail-input');
const uploadArea = document.querySelector('.media-item:first-child .upload-area');

// Create a text element for the file name
const fileNameDisplay = document.createElement('p');
fileNameDisplay.id = 'thumbnail-name';
fileNameDisplay.style.marginTop = '1rem';
fileNameDisplay.style.color = '#374151';
fileNameDisplay.style.display = 'none';
uploadArea.appendChild(fileNameDisplay);

fileInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileIcon = '🖼️';
        fileNameDisplay.textContent = `${fileIcon} Selected: ${file.name}`;
        fileNameDisplay.style.display = 'block';
        document.getElementById('thumbnail-preview').style.display = 'none'; 
    }
});

// --- Upload Video button ---
const videoBtn = document.getElementById('upload-video-btn');
const videoInput = document.getElementById('video-input');
const videoName = document.getElementById('video-name');

// Open file explorer
videoBtn.addEventListener('click', function() {
    videoInput.click();
});

// Show selected file name
videoInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        videoName.textContent = `🎬 Selected: ${file.name}`;
        videoName.style.display = 'block';
    }
});

// Direct to Find a Teacher page
document.getElementById('find-teacher-btn').addEventListener('click', function() {
    window.location.href = 'createClassFindTeacher.php';
});