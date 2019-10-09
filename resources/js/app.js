/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import vmodal from 'vue-js-modal'

Vue.use(vmodal, { dynamic: true } );
Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


//Vue.component('companies', require('./components/Companies.vue').default);
//Vue.component('vacancies', require('./components/Vacancies.vue').default);
Vue.component('component-header', require('./components/Header.vue').default);


import Companies from './pages/Companies';
import Vacancies from './pages/Vacancies';
import Users from './pages/Users';


const routes = [
        {
            path: '/adminpanel/companies',
            name: 'Компанії',
            component: Companies,
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
            name:
                'Вакансії',
            component:
            Vacancies
        }
        ,
        {
            path: '/adminpanel/users',
            name:
                'Користувачі',
            component:
            Users
        }
        ,
    ]
;

const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
    router
});
