document.querySelector('.contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('submit_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert(data.message);
            this.reset(); // Clear the form
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again later.');
    });
});


function handleDownload(event) {
    event.preventDefault();
    
    const confirmDownload = confirm(
        "Important Security Information:\n\n" +
        "• This app is safe to install\n" +
        "• You may see a warning because the app is not from the Play Store\n" +
        "• To install, you'll need to allow installation from unknown sources\n\n" +
        "Would you like to proceed with the download?"
    );
    
    if (confirmDownload) {
        // Track the download
        trackDownload(event);
        
        // Proceed with download
        window.location.href = event.target.closest('a').href;
        
        // Show installation instructions
        setTimeout(() => {
            showInstallInstructions();
        }, 1000);
    }
}


function showInstallInstructions() {
    const instructions = document.createElement('div');
    instructions.className = 'install-instructions';
    instructions.innerHTML = `
        <div class="instructions-content">
            <h3>Installation Instructions</h3>
            <ol>
                <li>Open your device Settings</li>
                <li>Go to Security or Privacy</li>
                <li>Enable "Install from Unknown Sources" or "Install Unknown Apps"</li>
                <li>Open the downloaded APK</li>
                <li>Follow the installation prompts</li>
            </ol>
            <button onclick="this.parentElement.remove()">Got it!</button>
        </div>
    `;
    document.body.appendChild(instructions);
}
