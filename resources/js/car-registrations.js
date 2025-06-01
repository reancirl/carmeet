// Add loading state to buttons
function setLoading(button, isLoading) {
    if (isLoading) {
        button.disabled = true;
        button.innerHTML = `
            <svg class="loading-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            ${button.textContent}
        `;
    } else {
        button.disabled = false;
        // Restore original content if available
        if (button.dataset.originalHtml) {
            button.innerHTML = button.dataset.originalHtml;
        }
    }
}

// Show flash message
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
    // Store original button HTML for loading states
    document.querySelectorAll('button').forEach(btn => {
        btn.dataset.originalHtml = btn.innerHTML;
    });

    // Handle status dropdown changes with loading state
    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', async function() {
            const form = this.closest('form');
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            const originalText = submitButton ? submitButton.innerHTML : '';
            
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
            
            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Add visual feedback
                    const row = form.closest('tr');
                    row.classList.add('bg-green-50', 'dark:bg-green-900', 'status-updated');
                    setTimeout(() => {
                        row.classList.remove('bg-green-50', 'dark:bg-green-900');
                    }, 1000);
                    
                    showFlashMessage(data.message || 'Status updated successfully');
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                showFlashMessage(error.message || 'An error occurred', 'error');
                // Revert the select to its previous value
                this.value = this.dataset.previousValue || this.value;
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            }
            
            // Store current value for next change
            this.dataset.previousValue = this.value;
        });
        
        // Initialize previous value
        select.dataset.previousValue = select.value;
    });
    
    // Handle paid checkbox changes with loading state
    const paidCheckboxes = document.querySelectorAll('.paid-checkbox');
    paidCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const form = this.closest('form');
            const originalChecked = this.checked;
            
            // Show loading state
            const originalHtml = this.nextElementSibling.innerHTML;
            this.nextElementSibling.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ${this.nextElementSibling.textContent}
            `;
            
            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Add visual feedback
                    const row = form.closest('tr');
                    row.classList.add('bg-blue-50', 'dark:bg-blue-900', 'status-updated');
                    setTimeout(() => {
                        row.classList.remove('bg-blue-50', 'dark:bg-blue-900');
                    }, 1000);
                    
                    showFlashMessage('Payment status updated successfully');
                } else {
                    throw new Error(data.message || 'Failed to update payment status');
                }
            } catch (error) {
                console.error('Error updating payment status:', error);
                showFlashMessage(error.message || 'An error occurred', 'error');
                // Revert the checkbox
                this.checked = !originalChecked;
            } finally {
                // Restore original label
                this.nextElementSibling.innerHTML = originalHtml;
            }
        });
    });
    
    // Registration Details Modal
    const modal = document.getElementById('registration-modal');
    const closeModalButton = document.getElementById('close-modal');
    const viewDetailsButtons = document.querySelectorAll('.view-details');
    const modalContent = document.getElementById('modal-content');
    
    // Modal action buttons
    const approveButton = document.getElementById('approve-btn');
    const denyButton = document.getElementById('deny-btn');
    const waitlistButton = document.getElementById('waitlist-btn');
    const modalPaidCheckbox = document.getElementById('modal-paid');
    const paymentNoteTextarea = document.getElementById('payment-note');
    const savePaymentButton = document.getElementById('save-payment');
    
    let currentRegistrationId = null;
    
    // Open modal when View Details is clicked
    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const registrationId = this.getAttribute('data-registration-id');
            currentRegistrationId = registrationId;
            
            // Fetch registration details via AJAX
            fetch(`/registrations/${registrationId}/details`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal with registration details
                    let content = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-lg mb-3">${data.user.name}</h4>
                                <p class="text-gray-600 dark:text-gray-400">${data.user.email}</p>
                                
                                <div class="mt-4">
                                    <h5 class="font-medium">Car Details</h5>
                                    <p>${data.car.year} ${data.car.make} ${data.car.model} ${data.car.trim || ''}</p>
                                    <p>Color: ${data.car.color}</p>
                                    ${data.car.plate ? `<p>Plate: ${data.car.plate}</p>` : ''}
                                </div>
                                
                                ${data.registration.crew_name ? `
                                <div class="mt-4">
                                    <h5 class="font-medium">Crew</h5>
                                    <p>${data.registration.crew_name}</p>
                                </div>` : ''}
                                
                                ${data.registration.notes_to_organizer ? `
                                <div class="mt-4">
                                    <h5 class="font-medium">Notes to Organizer</h5>
                                    <p>${data.registration.notes_to_organizer}</p>
                                </div>` : ''}
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-lg mb-3">Car Photos</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    ${data.car.image_urls && Array.isArray(data.car.image_urls) ? 
                                        data.car.image_urls.map(url => `
                                            <div>
                                                <img src="${url}" class="w-full h-32 object-cover rounded" alt="Car photo">
                                            </div>
                                        `).join('') : 
                                        '<p>No photos available</p>'
                                    }
                                </div>
                                
                                ${data.car.mods ? `
                                <div class="mt-4">
                                    <h5 class="font-medium">Modifications</h5>
                                    <p>${data.car.mods}</p>
                                </div>` : ''}
                                
                                ${data.car.description ? `
                                <div class="mt-4">
                                    <h5 class="font-medium">Description</h5>
                                    <p>${data.car.description}</p>
                                </div>` : ''}
                            </div>
                        </div>
                    `;
                    
                    modalContent.innerHTML = content;
                    
                    // Set current status in the modal action buttons
                    const currentStatus = data.registration.status;
                    approveButton.classList.toggle('ring-2', currentStatus === 'approved');
                    denyButton.classList.toggle('ring-2', currentStatus === 'denied');
                    waitlistButton.classList.toggle('ring-2', currentStatus === 'waitlist');
                    
                    // Set payment info
                    modalPaidCheckbox.checked = data.registration.is_paid;
                    paymentNoteTextarea.value = data.registration.payment_note || '';
                    
                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching registration details:', error);
                });
        });
    });
    
    // Close modal when close button is clicked
    closeModalButton.addEventListener('click', function() {
        modal.classList.add('hidden');
        currentRegistrationId = null;
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
            currentRegistrationId = null;
        }
    });
    
    // Action buttons functionality
    function updateRegistrationStatus(status) {
        if (!currentRegistrationId) return;
        
        fetch(`/registrations/${currentRegistrationId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the status in the table without refreshing
                const statusSelect = document.querySelector(`.status-select[data-registration-id="${currentRegistrationId}"]`);
                if (statusSelect) {
                    statusSelect.value = status;
                }
                
                // Highlight the active button
                approveButton.classList.toggle('ring-2', status === 'approved');
                denyButton.classList.toggle('ring-2', status === 'denied');
                waitlistButton.classList.toggle('ring-2', status === 'waitlist');
            }
        })
        .catch(error => {
            console.error('Error updating registration status:', error);
        });
    }
    
    approveButton.addEventListener('click', function() {
        updateRegistrationStatus('approved');
    });
    
    denyButton.addEventListener('click', function() {
        updateRegistrationStatus('denied');
    });
    
    waitlistButton.addEventListener('click', function() {
        updateRegistrationStatus('waitlist');
    });
    
    // Save payment info
    savePaymentButton.addEventListener('click', function() {
        if (!currentRegistrationId) return;
        
        const isPaid = modalPaidCheckbox.checked;
        const paymentNote = paymentNoteTextarea.value;
        
        fetch(`/registrations/${currentRegistrationId}/payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                is_paid: isPaid,
                payment_note: paymentNote
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the payment status in the table
                const checkbox = document.querySelector(`#paid-${currentRegistrationId}`);
                if (checkbox) {
                    checkbox.checked = isPaid;
                }
                
                // Update the payment note in the table
                const noteElement = checkbox?.closest('td')?.querySelector('.text-xs');
                if (noteElement) {
                    noteElement.textContent = paymentNote;
                    noteElement.setAttribute('title', paymentNote);
                }
            }
        })
        .catch(error => {
            console.error('Error updating payment info:', error);
        });
    });
});
