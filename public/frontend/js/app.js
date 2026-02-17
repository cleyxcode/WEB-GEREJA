// Toast Notification Function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast bg-white rounded-lg shadow-lg p-4 flex items-center gap-3 min-w-[300px] border-l-4 ${
        type === 'success' ? 'border-green-500' : 'border-red-500'
    }`;
    
    const icon = type === 'success' 
        ? '<span class="material-symbols-outlined text-green-500">check_circle</span>'
        : '<span class="material-symbols-outlined text-red-500">error</span>';
    
    toast.innerHTML = `
        ${icon}
        <span class="text-sm text-slate-700">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideInRight 0.3s ease-out reverse';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Loading State for Button
function setButtonLoading(button, isLoading) {
    if (isLoading) {
        button.disabled = true;
        button.innerHTML = `
            <div class="spinner"></div>
            <span>Memproses...</span>
        `;
    } else {
        button.disabled = false;
    }
}

// Toggle Password Visibility
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.relative').querySelector('input');
            const icon = this.querySelector('.material-symbols-outlined');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        });
    });
});

// Form Validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    return password.length >= 8;
}