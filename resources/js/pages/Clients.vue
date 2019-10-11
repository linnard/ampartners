<template>
    <div>
        <div class="FilterBlock_buttons">
            <a class="BtnBlue BtnBlue-addContact FilterBlock_quickCreationBtn" href="javascript:void(0)"
               @click="createCard()">
                <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79">
                    <g data-name="Слой 2">
                        <path class="SvgIco_path"
                              d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z"
                              fill="#fff" data-name="Capa 1"></path>
                    </g>
                </svg>
                Швидке створення
            </a>
            <label class="BtnGreen BtnGreen-addContact" @click="createWithReserve()">
                <svg xmlns="http://www.w3.org/2000/svg" class="SvgIco" viewBox="0 0 16 11.79">
                    <g data-name="Слой 2">
                        <path class="SvgIco_path"
                              d="M.71 1.42h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zm0 3.45h7.65a.71.71 0 0 0 0-1.42H.71a.71.71 0 0 0 0 1.42zM5.08 6.9H.71a.71.71 0 0 0 0 1.42h4.37a.71.71 0 1 0 0-1.42zm10.21 0h-2.76V4.14a.71.71 0 1 0-1.42 0V6.9H8.36a.71.71 0 1 0 0 1.42h2.75v2.76a.71.71 0 0 0 1.42 0V8.32h2.76a.71.71 0 1 0 0-1.42z"
                              fill="#fff" data-name="Capa 1"></path>
                    </g>
                </svg>
                Створити новий контакт
            </label>
        </div>

        <div class="Receipts">

            <client-card v-for="client in clients"
                         :key="client.id"
                         :client="client"
                         :property_types="property_types"
                         :vacancies="vacancies"/>

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

    import ClientCard from "../components/ClientCard";

    export default {
        components: {ClientCard},
        data() {
            return {
                vacancies: {},
                clients: {},
                property_types: {},
                reserved: null,
            }
        },
        methods: {

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

            createCard(){
                axios.post('/api/v1/clients', {
                    vacancy_id: this.reserved
                }).then((response) => {
                    this.clients.unshift(response.data.client);
                })
            },

            getClients() {
                axios.get('/api/v1/clients').then((response) => {
                    this.clients = response.data.clients;
                })
            },

            getVacancies() {
                axios.get('/api/v1/vacancies', {
                    is_active: 1
                }).then((response) => {
                    this.vacancies = response.data.vacancies;
                });
            },

            getPropertyTypes() {
                axios.get('/api/v1/properties').then((response) => {
                    this.property_types = response.data.property_types;
                });
            },

            createWithReserve() {
                this.$modal.show('vacancyReserve', {
                    reserved: this.reserved
                })
            }

        },
        mounted: function () {
            this.getPropertyTypes();
            this.getClients();
            this.getVacancies();
        },
        watch: {
            clients: function (val) {
                console.log(val);
            },
        }
    }
</script>
