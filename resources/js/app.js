/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import vmodal from 'vue-js-modal'
import Notifications from 'vue-notification'
import FileUpload from 'v-file-upload'
import Datetime from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';

Vue.use(vmodal, {dynamic: true});
Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(FileUpload);
Vue.use(Datetime);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('component-header', require('./components/Header.vue').default);
Vue.component('notifications-block', require('./components/NotificationsBlock.vue').default);

import Companies from './pages/Companies';
import Vacancies from './pages/Vacancies';
import Users from './pages/Users';
import ClientCardsEditable from './pages/ClientCardsEditable';
import ClientCards from './pages/ClientCards';


const routes = [
    {
        path: '/adminpanel/companies',
        name: 'Компанії',
        component: Companies,
        role: 'admin',
        children:
            [{
                name: 'Заявки',
                path: 'new',
                component: {
                    template: '<div>Заявки</div>'
                }
            }, {
                name: 'Активні',
                path: 'approved',
                component: {
                    template: '<div>Активні</div>'
                }
            }, {
                name: 'Відхилені',
                path: 'cancelled',
                component: {
                    template: '<div>Відхилені</div>'
                }
            }]
    },
    {
        path: '/adminpanel/vacancies',
        name: 'Вакансії',
        component: Vacancies,
        role: 'admin',
    },
    {
        path: '/adminpanel/users',
        name: 'Користувачі',
        component: Users,
        role: 'admin',
    },
    {
        path: '/adminpanel/clients',
        name: 'Працевлаштування',
        component: ClientCards,
        role: 'admin',
        children:
            [{
                name: 'Заявки на бронювання',
                path: 'new',
                component: {
                    template: '<div>Заявки на бронювання</div>'
                }
            }, {
                name: 'Контакти з квитком',
                path: 'approved',
                component: {
                    template: '<div>Контакти з квитком</div>'
                }
            }, {
                name: 'Успішно завершені',
                path: 'cancelled',
                component: {
                    template: '<div>Успішно завершені</div>'
                }
            }]
    },

    {
        path: '/controlpanel/clients',
        name: 'Працевлаштування',
        component: ClientCardsEditable,
        role: 'partner',
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.prototype.$authUser = window.user;

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + window.user.apiToken,
};


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
    router
});
