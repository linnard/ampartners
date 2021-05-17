/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import Clipboard from 'v-clipboard'
import VueRouter from 'vue-router'
import vmodal from 'vue-js-modal'
import Notifications from 'vue-notification'
import FileUpload from 'v-file-upload'

import Datetime from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';


import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

Vue.use(Clipboard);
Vue.use(vmodal, {dynamic: true});
Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(FileUpload);
Vue.use(Datetime);

Vue.mixin({
    methods: {
        pluck: function (array, key) {
            if (array) return array.map(o => o[key]);
            return [];
        },
        sleep: function (ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
    }
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//alert(process.env.MIX_NODE_ENV);

Vue.component('app', require('./components/App.vue').default);
Vue.component('notifications-block', require('./components/NotificationsBlock.vue').default);
Vue.component("v-select", vSelect);

import Companies from './pages/Companies';
import ClientVacancies from './pages/ClientVacancies';
import Vacancies from './pages/Vacancies';
import Users from './pages/Users';
import ClientCardsEditable from './pages/ClientCardsEditable';
import ClientCards from './pages/ClientCards';
import VacanciesIndex from './pages/VacanciesIndex';

const AccessDenied = {template: '<div class="alert alert-danger">Доступ заборонено!</div>'};

const routes = [

    //Admin routes

    {
        path: '/adminpanel/companies',
        component: Companies,
        role: 'admin',
        permission: '',
        meta: {
            name: 'Компанії',
            counter_id: 'new_companies_count'
        }
    },
    {
        path: '/adminpanel/client-vacancies',
        component: ClientVacancies,
        role: 'admin',
        permission: '',
        meta: {
            name: 'Вакансії (old)',
            counter_id: 'new_vacancies_count'
        }
    },

    {
        path: '/adminpanel/vacancies',
        component: Vacancies,
        role: 'admin',
        permission: 'control_vacancies',
        meta: {
            name: 'Вакансії',
        }
    },

    {
        path: '/adminpanel/users',
        component: Users,
        role: 'admin',
        permission: '',
        meta: {
            name: 'Користувачі',
            counter_id: 'new_users_count'
        }
    },
    {
        path: '/adminpanel/clients',
        component: ClientCards,
        role: 'admin',
        permission: '',
        meta: {
            name: 'Працевлаштування',
            counter_id: 'new_clients_count'
        }
    },

    //Partner routes

    {
        path: '/controlpanel/info',
        component: AccessDenied,
        role: 'partner',
        permission: '',
        meta: {name: 'Інформація'}
    },
    {
        path: '/controlpanel/users',
        component: AccessDenied,
        role: 'partner',
        permission: '',
        meta: {name: 'Користувачі'}
    },
    {
        path: '/controlpanel/visa-support',
        component: AccessDenied,
        role: 'partner',
        permission: '',
        meta: {name: 'Візова підтримка'}
    },
    /*{
        path: '/controlpanel/clients',
        component: ClientCardsEditable,
        role: 'partner',
        permission: '',
        meta: {name: 'Працевлаштування'}
    },*/
    {
        path: '/controlpanel/rewards',
        component: AccessDenied,
        role: 'partner',
        permission: '',
        meta: {name: 'Отримати винагороду'}
    },
    {
        path: '/controlpanel/vacancies',
        component: VacanciesIndex,
        role: 'partner',
        permission: 'view_vacancies',
        meta: {name: 'Вакансії'}
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
