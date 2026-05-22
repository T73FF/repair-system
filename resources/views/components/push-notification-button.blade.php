@props(['text' => '🔔 Включить уведомления'])

<button id="push-notification-btn" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-xl transition">
    {{ $text }}
</button>

@push('scripts')
<script>
(function() {
    const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
    const button = document.getElementById('push-notification-btn');
    
    if (!button) return;
    
    // Конвертация base64 в Uint8Array (требуется для Push API)
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
    
    async function subscribeToPush() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            alert('Ваш браузер не поддерживает push-уведомления');
            return false;
        }
        
        // Запрашиваем разрешение
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            alert('Разрешение на уведомления не получено');
            return false;
        }
        
        // Регистрируем service worker
        const registration = await navigator.serviceWorker.ready;
        
        // Подписываемся на push
        const subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
        });
        
        // Отправляем подписку на сервер
        const response = await fetch('/push-subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(subscription)
        });
        
        if (response.ok) {
            button.textContent = '✅ Уведомления включены';
            button.disabled = true;
            return true;
        } else {
            alert('Ошибка при сохранении подписки');
            return false;
        }
    }
    
    button.addEventListener('click', subscribeToPush);
})();
</script>
@endpush