// Ana JavaScript dosyası
document.addEventListener('DOMContentLoaded', function() {
    // Mobil menü açma/kapatma
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Flash mesajlarını otomatik kapatma
    // const alerts = document.querySelectorAll('.alert');
    // alerts.forEach(function(alert) {
    //     // 5 saniye sonra mesajı kaldır
    //     setTimeout(function() {
    //         alert.style.opacity = '0';
    //         setTimeout(function() {
    //             alert.style.display = 'none';
    //         }, 500);
    //     }, 5000);
        
    //     // X butonuna tıklayınca mesajı kaldır
    //     const closeBtn = alert.querySelector('.close');
    //     if (closeBtn) {
    //         closeBtn.addEventListener('click', function() {
    //             alert.style.opacity = '0';
    //             setTimeout(function() {
    //                 alert.style.display = 'none';
    //             }, 500);
    //         });
    //     }
    // });
    
    // Form doğrulama
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Gerekli alanları kontrol et
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    showFieldError(field, 'Bu alan gereklidir.');
                } else {
                    clearFieldError(field);
                }
            });
            
            // E-posta alanlarını kontrol et
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(function(field) {
                if (field.value.trim() && !isValidEmail(field.value.trim())) {
                    isValid = false;
                    showFieldError(field, 'Geçerli bir e-posta adresi giriniz.');
                }
            });
            
            // Eğer form geçerli değilse gönderimi engelle
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    
    // E-posta doğrulama fonksiyonu
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // Alan hata mesajını göster
    function showFieldError(field, message) {
        // Mevcut hata mesajını temizle
        clearFieldError(field);
        
        // Hata mesajı elementi oluştur
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.textContent = message;
        
        // Hata mesajını ekle
        field.parentNode.appendChild(errorElement);
        
        // Alana hata sınıfı ekle
        field.classList.add('is-invalid');
    }
    
    // Alan hata mesajını temizle
    function clearFieldError(field) {
        const parentNode = field.parentNode;
        const errorElement = parentNode.querySelector('.field-error');
        
        if (errorElement) {
            parentNode.removeChild(errorElement);
        }
        
        field.classList.remove('is-invalid');
    }

    // public/assets/js/main.js dosyasına ekleyin
// Bildirim işlemleri
const notificationBell = document.getElementById('notification-bell');
const notificationDropdown = document.getElementById('notification-dropdown');
const markAllReadBtn = document.getElementById('mark-all-read');

if (notificationBell && notificationDropdown) {
    // Bildirim menüsünü aç/kapat
    notificationBell.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        notificationDropdown.classList.toggle('hidden');
    });
    
    // Dışarı tıklayınca kapat
    document.addEventListener('click', function(event) {
        if (!notificationDropdown.contains(event.target) && !notificationBell.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });
    
    // Bildirime tıklayınca okundu işaretle
    const notificationItems = document.querySelectorAll('.notification-list a');
    notificationItems.forEach(function(item) {
        item.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            markNotificationAsRead(notificationId);
        });
    });
    
    // Tümünü okundu işaretle
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            markAllNotificationsAsRead();
        });
    }
}

// Bildirimi okundu olarak işaretle
function markNotificationAsRead(notificationId) {
    fetch('/notifications/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'notification_id=' + notificationId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Bildirim sayısını güncelle
            updateNotificationCount();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Tüm bildirimleri okundu olarak işaretle
function markAllNotificationsAsRead() {
    fetch('/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Bildirim sayısını güncelle ve menüyü yenile
            updateNotificationCount();
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Bildirim sayısını güncelle
function updateNotificationCount() {
    fetch('/notifications/count')
    .then(response => response.json())
    .then(data => {
        const countBadge = notificationBell.querySelector('span');
        if (data.count > 0) {
            if (countBadge) {
                countBadge.textContent = data.count > 9 ? '9+' : data.count;
            } else {
                const newBadge = document.createElement('span');
                newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                newBadge.textContent = data.count > 9 ? '9+' : data.count;
                notificationBell.appendChild(newBadge);
            }
        } else {
            if (countBadge) {
                countBadge.remove();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
    // // Şifre görünürlüğünü aç/kapat
    // function togglePasswordVisibility(inputId) {
    //     const passwordInput = document.getElementById(inputId);
    //     const icon = event.currentTarget.querySelector('i');
        
    //     if (passwordInput.type === 'password') {
    //         passwordInput.type = 'text';
    //         icon.classList.remove('fa-eye');
    //         icon.classList.add('fa-eye-slash');
    //     } else {
    //         passwordInput.type = 'password';
    //         icon.classList.remove('fa-eye-slash');
    //         icon.classList.add('fa-eye');
    //     }
    // }
});