import './bootstrap';


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';  // اگر Pusher استفاده می‌کنی

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    // یا تنظیمات Redis/WebSocket خودت
});

// گوش دادن به کانال پرایوت کاربران
window.Echo.private(`users.${userId}`)
    .listen('.high-priority-task', (e) => {
        console.log('نوتیفیکیشن جدید رسید:', e);
        // اینجا باید نوتیفیکیشن جدید رو به لیست اضافه کنیم
        addNotificationToList(e);
    });

function addNotificationToList(notification) {
    const list = document.querySelector('#notificationList'); // لیست نوتیفیکیشن‌ها
    if (!list) return;

    const li = document.createElement('li');
    li.classList.add('mb-2');
    li.innerHTML = `
        <div class="fw-bold">${notification.title || 'بدون عنوان'}</div>
        <div>${notification.message || ''}</div>
        <hr class="my-1">
    `;

    list.prepend(li); // نوتیفیکیشن جدید بالای لیست اضافه می‌شود

    const emptyMsg = list.querySelector('.empty-message');
    if (emptyMsg) emptyMsg.remove();
}
