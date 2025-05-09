// Ana JavaScript dosyası
document.addEventListener('DOMContentLoaded', function() {
    // Mobil menü açma/kapatma
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const nav = document.querySelector('nav');
            nav.classList.toggle('active');
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