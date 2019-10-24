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

const AccessDenied = { template: '<div class="alert alert-danger">Доступ заборонено!</div>' };

const routes = [

    //Admin routes

    {
        path: '/adminpanel/companies',
        component: Companies,
        role: 'admin',
        meta: { name: 'Компанії'}
    },
    {
        path: '/adminpanel/vacancies',
        component: Vacancies,
        role: 'admin',
        meta: { name: 'Вакансії'}
    },
    {
        path: '/adminpanel/users',
        component: Users,
        role: 'admin',
        meta: { name: 'Користувачі'}
    },
    {
        path: '/adminpanel/clients',
        component: ClientCards,
        role: 'admin',
        meta: { name: 'Працевлаштування'}
    },

    //Partner routes

    {
        path: '/controlpanel/info',
        component: AccessDenied,
        role: 'partner',
        meta: { name: 'Інформація'}
    },
    {
        path: '/controlpanel/users',
        component: AccessDenied,
        role: 'partner',
        meta: { name: 'Користувачі'}
    },
    {
        path: '/controlpanel/visa-support',
        component: AccessDenied,
        role: 'partner',
        meta: { name: 'Візова підтримка'}
    },
    {
        path: '/controlpanel/clients',
        component: ClientCardsEditable,
        role: 'partner',
        meta: { name: 'Працевлаштування'}
    },
    {
        path: '/controlpanel/rewards',
        component: AccessDenied,
        role: 'partner',
        meta: { name: 'Отримати винагороду'}
    },

];

const router = new VueRouter({
    linkExactActiveClass: 'MainMenu_item-active',
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
