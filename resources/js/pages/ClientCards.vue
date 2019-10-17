<template>
    <div>

        <div class="Receipts">

            <client-card v-for="client in clients"
                         :key="client.id"
                         :client="client"
                         :property_types="property_types"
                         :vacancies="vacancies"/>

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
                //console.log(val);
            },
        }
    }
</script>
