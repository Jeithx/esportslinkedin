// Admin panel için JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Form doğrulama
    const adminForms = document.querySelectorAll('.admin-form');
    adminForms.forEach(function(form) {
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
            
            // Eğer form geçerli değilse gönderimi engelle
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    
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
    
    // Tarih ve saat seçicileri için min değeri ayarla
    const dateInputs = document.querySelectorAll('input[type="datetime-local"]');
    if (dateInputs.length > 0) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        
        dateInputs.forEach(function(input) {
            // Sadece min değeri yoksa ayarla
            if (!input.hasAttribute('min')) {
                input.setAttribute('min', currentDateTime);
            }
        });
    }
    
    // Maç sonuçları için skor değiştirme
    // Maç sonuçları için skor değiştirme
    const scoreInputs = document.querySelectorAll('.score-input');
    if (scoreInputs.length > 0) {
        scoreInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const matchId = this.getAttribute('data-match-id');
                const teamId = this.getAttribute('data-team-id');
                const score = this.value;
                
                // AJAX ile skoru güncelle
                const xhr = new XMLHttpRequest();
                xhr.open('POST', siteUrl + '/admin/update-score', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Başarılı
                            showNotification('Skor başarıyla güncellendi.', 'success');
                        } else {
                            // Hata
                            showNotification('Skor güncellenirken bir hata oluştu.', 'error');
                        }
                    }
                };
                xhr.send('match_id=' + matchId + '&team_id=' + teamId + '&score=' + score);
            });
        });
    }
    
    // Bildirim gösterme
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = 'notification notification-' + type;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // 3 saniye sonra kaldır
        setTimeout(function() {
            notification.classList.add('fade-out');
            setTimeout(function() {
                document.body.removeChild(notification);
            }, 500);
        }, 3000);
    }
    
    // Turnuva durumu değişikliği
    const tournamentStatusSelect = document.querySelectorAll('.tournament-status-select');
    if (tournamentStatusSelect.length > 0) {
        tournamentStatusSelect.forEach(function(select) {
            select.addEventListener('change', function() {
                const tournamentId = this.getAttribute('data-tournament-id');
                const status = this.value;
                
                // AJAX ile durumu güncelle
                const xhr = new XMLHttpRequest();
                xhr.open('POST', siteUrl + '/admin/update-tournament-status', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Başarılı
                            showNotification('Turnuva durumu başarıyla güncellendi.', 'success');
                        } else {
                            // Hata
                            showNotification('Durum güncellenirken bir hata oluştu.', 'error');
                        }
                    }
                };
                xhr.send('tournament_id=' + tournamentId + '&status=' + status);
            });
        });
    }
    
    // Turnuva eşleşmelerini otomatik oluştur
    const generateMatchesBtn = document.querySelector('#generate-matches-btn');
    if (generateMatchesBtn) {
        generateMatchesBtn.addEventListener('click', function() {
            const tournamentId = this.getAttribute('data-tournament-id');
            
            // Onay iste
            if (!confirm('Turnuva eşleşmelerini otomatik olarak oluşturmak istediğinize emin misiniz?')) {
                return;
            }
            
            // AJAX ile eşleşmeleri oluştur
            const xhr = new XMLHttpRequest();
            xhr.open('POST', siteUrl + '/admin/generate-matches', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Başarılı
                        showNotification('Turnuva eşleşmeleri başarıyla oluşturuldu.', 'success');
                        // Sayfayı yenile
                        window.location.reload();
                    } else {
                        // Hata
                        showNotification('Eşleşmeler oluşturulurken bir hata oluştu: ' + response.message, 'error');
                    }
                }
            };
            xhr.send('tournament_id=' + tournamentId);
        });
    }
});