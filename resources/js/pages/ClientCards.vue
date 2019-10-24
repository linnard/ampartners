<template>
    <div>
        <div class="SecondaryMenu Top_secondaryMenu p-3">
            <ul class="SecondaryMenu_list">
                <li class="SecondaryMenu_item">
                    <a href="javascript:void(0)" @click="filter"
                       class="SecondaryMenu_link">Усі</a>
                </li>
                <li class="SecondaryMenu_item" :class="{'SecondaryMenu_item-active' : selected_status == 'booking_confirmation_expected'}">
                    <a href="javascript:void(0)" @click="filter('booking_confirmation_expected')"
                       class="SecondaryMenu_link">Заявки на бронювання</a>
                      <span class="Number SecondaryMenu_number" v-if="counts['booking_confirmation_expected']">{{counts['booking_confirmation_expected']}}</span>
                </li>
                <li class="SecondaryMenu_item" :class="{'SecondaryMenu_item-active' : selected_status == 'ticket_confirmation_expected'}">
                    <a href="javascript:void(0)" @click="filter('ticket_confirmation_expected')"
                       class="SecondaryMenu_link">Контакти з квитком</a>
                      <span class="Number SecondaryMenu_number" v-if="counts['ticket_confirmation_expected']">{{counts['ticket_confirmation_expected']}}</span>
                </li>
                <li class="SecondaryMenu_item" :class="{'SecondaryMenu_item-active' : selected_status == 'completed'}">
                    <a href="javascript:void(0)" @click="filter('completed')" class="SecondaryMenu_link">Успішно
                        завершені</a>
                </li>
            </ul>
        </div>

        <div class="Receipts" v-if="clients.length">
            <client-card v-for="client in clients"
                         :key="client.id"
                         :client="client"
                         :property_types="property_types"
                         :vacancies="vacancies"
                         :visible_statuses="visible_statuses"
                         :class="{'Receipts_item-new':client.is_updated}"
                         @update_counts="updateCounts"/>
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

    const DEFAULT_STATUSES = [
            'booking_confirmation_expected',
            'ticket_confirmation_expected',
            'completed'
        ];

    export default {
        components: {ClientCard},
        data() {
            return {
                vacancies: {},
                clients: {},
                property_types: {},
                reserved: null,
                visible_statuses: DEFAULT_STATUSES,
                selected_status: '',
                counts: []
            }
        },
        methods: {

            filter(status = ''){
                if (DEFAULT_STATUSES.includes(status)){
                    this.visible_statuses = [status];
                    this.selected_status = status;
                } else {
                    this.visible_statuses = DEFAULT_STATUSES;
                    this.selected_status = '';
                }
            },

            getClients() {
                axios.get('/api/v1/clients').then((response) => {
                    this.clients = response.data.clients;
                    this.updateCounts();
                })
            },

            updateCounts(){

                let counts = [];
                this.clients.map(function (client) {
                    if (DEFAULT_STATUSES.includes(client.status) && client.is_updated){
                        if (counts[client.status]) {
                            counts[client.status]++;
                        } else {
                            counts[client.status] = 1;
                        }
                    }
                });

                this.counts = counts;
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

            getClient(id) {
                return axios.get('/api/v1/clients/' + id).then((response) => {
                    return response.data.client;
                });
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
            this.getPropertyTypes();
            this.getClients();
            this.getVacancies();

            Echo.channel('Client')
                .listen('.StatusUpdated', (e) => {

                    var index = this.getKeyElement(e.client.id);
                    if (index) {

                        Vue.notify({
                            type: 'success',
                            title: 'Статус клієнта змінено',
                            text: e.status_description
                        });

                        this.getClient(e.client.id).then(client => {
                            this.clients[index] = client;
                            this.updateCounts();
                        });
                    } else {
                        this.getClient(e.client.id).then(client => {
                            this.clients.unshift(client);
                            this.updateCounts();
                        });
                    }

                });
        },

    }
</script>
