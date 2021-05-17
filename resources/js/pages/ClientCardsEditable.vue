<template>
    <div>
        <div class="FilterBlock">
            <div class="FilterBlock_left">
                <select @change="getClients(selected_status)" v-model="selected_status" class="form-control">
                    <option value="" selected>Усі</option>
                    <option v-for="(item, index) in statuses" :value="index">{{item}}</option>
                </select>
            </div>

            <div class="FilterBlock_left">
                <div class="Search FilterBlock_search">
                    <button class="btn btn-light btn-sm" style="font-size: 1em; color: #ff0000;"
                            v-if="search_query.length" @click="clearSearchInput">
                        <i class="fas fa-times"></i>
                    </button>
                    <input class="FormText FormText-search Search_text" type="text" @keyup.enter="search"
                           v-model="search_query" placeholder="Введіть пошуковий запит">

                    <button class="Search_btn" @click="search"></button>
                </div>
            </div>
            <div class="FilterBlock_right">
                <div class="FilterBlock_buttons">
                    <label class="BtnBlue BtnBlue-addContact FilterBlock_quickCreationBtn" @click="createCard()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79">
                            <g data-name="Слой 2">
                                <path class="SvgIco_path"
                                      d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z"
                                      fill="#fff" data-name="Capa 1"></path>
                            </g>
                        </svg>
                        Швидке бронювання
                    </label>
                    <label class="BtnGreen BtnGreen-addContact" @click="createWithReserve()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79">
                            <g data-name="Слой 2">
                                <path class="SvgIco_path"
                                      d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z"
                                      fill="#fff" data-name="Capa 1"></path>
                            </g>
                        </svg>
                        Переглянути вакансії
                    </label>
                </div>

            </div>
        </div>


        <div class="Receipts" v-if="clients.length">
            <client-card-editable v-for="client in clients"
                                  :key="client.id"
                                  :client="client"
                                  :property_types="property_types"
                                  :vacancies="vacancies"/>
        </div>

        <div class="Receipts" v-else>
            <div class="alert alert-info">Клієнтів не знайдено.</div>
        </div>

        <notifications/>
        <modals-container/>
        <modal name="vacancyReserve" :width="1200" :height="'auto'" :scrollable="true">
            <div class="container">
                <div class="Popup_header">
                    <h2 class="Popup_title">Забронювати вакансію</h2>
                </div>

                <div class="Popup_body">
                    <div class="WhiteBlock VacancyInfo Popup_vacancyInfo" v-for="vacancy in vacancies">
                        <div class="VacancyInfo_header">
                            <h2 class="VacancyInfo_title">{{vacancy.name}}</h2>
                            &nbsp;&nbsp;<button type="button" @click="reserve(vacancy.id)" class="btn btn-success">
                            Забронювати вакансію
                        </button>

                        </div>
                        <div class="VacancyInfo_text" v-html="vacancy.description"></div>
                    </div>
                </div>

                <div class="Popup_footer">
                    <button type="button" @click="$modal.hide('vacancyReserve')" class="btn btn-success">Закрити вікно
                    </button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>

    import ClientCardEditable from "../components/ClientCardEditable";

    export default {
        components: {ClientCardEditable},
        data() {
            return {
                vacancies: {},
                clients: {},
                property_types: {},
                reserved: '',
                search_query: '',
                selected_status: '',
                statuses: {},
            }
        },
        methods: {

            clearSearchInput() {
                this.search_query = '';
            },

            search() {
                if (this.search_query.length < 3) {
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Пошуковий запит має бути не менше 3 символів!'
                    });

                    return;
                }

                axios.post('/api/v1/clients/search', {
                    query: this.search_query
                }).then((response) => {
                    this.clients = response.data.clients;
                })

            },

            reserve(id) {
                this.reserved = id;

                this.$modal.hide('vacancyReserve');

                Vue.notify({
                    type: 'success',
                    title: 'Успіх',
                    text: 'Вакансію успішно заброньовано!'
                });

                this.createCard()
            },

            createCard() {
                axios.post('/api/v1/clients', {
                    vacancy_id: this.reserved
                }).then((response) => {
                    this.clients.unshift(response.data.client);
                })
            },

            getClients(status = '') {
                axios.get('/api/v1/clients', {
                    params: {
                        ...(status ? {statuses: [status]} : {})
                    }
                }).then((response) => {
                    this.clients = response.data.clients;
                })
            },

            getVacancies() {
                axios.get('/api/v1/client-vacancies', {
                    params: {
                        is_active: 1
                    }
                }).then((response) => {
                    this.vacancies = response.data.vacancies;
                });
            },

            getPropertyTypes() {
                axios.get('/api/v1/properties').then((response) => {
                    this.property_types = response.data.property_types;
                });
            },

            getStatuses() {
                axios.get('/api/v1/statuses').then((response) => {
                    this.statuses = response.data.statuses;
                });
            },

            createWithReserve() {
                this.$modal.show('vacancyReserve', {
                    reserved: this.reserved
                })
            },

            getKeyElement(key) {
                var clients = this.clients;
                for (var client in clients) {
                    if (clients[client].id == key) {
                        return client;
                    }
                }

                return false;
            }

        },
        mounted: function () {
            this.getVacancies();
            this.getStatuses();
            this.getPropertyTypes();
            this.getClients();


            Echo.channel('Client')
                .listen('.StatusUpdated', (e) => {

                    var index = this.getKeyElement(e.client.id);
                    if (index) {

                        Vue.notify({
                            type: 'success',
                            title: 'Статус клієнта змінено',
                            text: e.status_description
                        });

                        this.clients[index].status = e.client.status;
                        this.clients[index].latest_notification = e.comment;
                    }

                });

            this.$root.$on('clientSelected', (id) => {
                this.search_query = 'ID' + id;
                this.search();
            });

        },
        watch: {
            search_query: function (val) {
                if (!val.length) {
                    this.getClients();
                }
            }
        }
    }
</script>
