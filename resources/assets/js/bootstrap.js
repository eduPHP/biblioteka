window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message, type='sucesso'){
    window.events.$emit('flash', message, type);
};

window.vueConfirm = function (message, acceptText = 'Continuar', acceptIcon = 'fa-check') {
    window.events.$emit('confirm', message, acceptText, acceptIcon);
};

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
