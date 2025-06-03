// Show flash message if there's a flash message in the session
function showFlashMessage(message, type = 'success') {
    const flashDiv = document.createElement('div');
    flashDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg ${type === 'error' ? 'bg-red-100 border-l-4 border-red-500 text-red-700' : 'bg-green-100 border-l-4 border-green-500 text-green-700'}`;
    flashDiv.role = 'alert';
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex';
    
    const textDiv = document.createElement('div');
    textDiv.className = 'py-1';
    textDiv.innerHTML = `
        <svg class="h-6 w-6 ${type === 'error' ? 'text-red-500' : 'text-green-500'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="ml-2">${message}</p>
    `;
    
    const closeButton = document.createElement('button');
    closeButton.className = 'ml-4';
    closeButton.innerHTML = `
        <svg class="h-5 w-5 ${type === 'error' ? 'text-red-500' : 'text-green-500'}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    `;
    closeButton.onclick = () => flashDiv.remove();
    
    messageDiv.appendChild(textDiv);
    messageDiv.appendChild(closeButton);
    flashDiv.appendChild(messageDiv);
    
    document.body.appendChild(flashDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        flashDiv.style.opacity = '0';
        flashDiv.style.transition = 'opacity 0.5s';
        setTimeout(() => flashDiv.remove(), 500);
    }, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Show flash message if there's a flash message in the session
    const flashMessage = document.querySelector('.flash-message');
    if (flashMessage) {
        const message = flashMessage.dataset.message;
        const type = flashMessage.classList.contains('flash-error') ? 'error' : 'success';
        showFlashMessage(message, type);
    }
    
    // Add loading state to form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${submitButton.textContent}
                `;
            }
        });
    });
});
