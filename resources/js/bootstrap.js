import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// import Echo from 'laravel-echo';


// let e = new Echo({
//     broadcaster: 'socket.io',

//     host: window.location.hostname + ':6001'

// })

// e.channel('chan-user')
//     .listen('UserNotification',(e)=>{
//         console.log(e)
//             document.getElementById('laravel-echo-message').innerText = e.message.message;

//     })


import Echo from 'laravel-echo';

let e = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

e.channel('chan-user')
    .listen('UserNotification', (e) => {
        console.log('دریافت پیام:', e);

        const ul = document.getElementById('notificationList');

        if (ul) {
            const li = document.createElement('li');
            li.classList.add('mb-2');
            li.innerHTML = `
                <div class="realtime">نوتیفیکیشن جدید</div>
                <div>${e.message.message}</div>
            `;

            ul.prepend(li); 
        }
    });


