<template>
    <div>
        <div class="SecondaryMenu Top_secondaryMenu p-3">
            <ul class="SecondaryMenu_list">
                     <li class="SecondaryMenu_item"><a href="javascript:void(0)" @click="getClients('booking_confirmation_expected')" class="SecondaryMenu_link">Заявки на бронювання<!--<span class="Number SecondaryMenu_number">4</span>--></a></li>
                     <li class="SecondaryMenu_item"><a href="javascript:void(0)" @click="getClients('ticket_confirmation_expected')" class="SecondaryMenu_link">Контакти з квитком</a></li>
                     <li class="SecondaryMenu_item"><a href="javascript:void(0)" @click="getClients('completed')" class="SecondaryMenu_link">Успішно завершені</a></li>
            </ul>
        </div>

        <div class="Receipts" v-if="clients.length">
            <client-card v-for="client in clients"
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

            getClients(status = '') {

                var statuses = [
                    'booking_confirmation_expected',
                    'ticket_confirmation_expected',
                    'completed'
                ];

                if (status){
                    statuses = [status];
                }

                axios.get('/api/v1/clients', {
                    params: {
                        statuses: statuses
                    }
                }).then((response) => {
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
                //console.log(val);
            },
        }
    }
</script>
