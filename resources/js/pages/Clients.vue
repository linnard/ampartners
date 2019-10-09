<template>
    <div>


        <modals-container/>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                clients: {},
                status: '',
            }
        },
        methods: {
            getClients(status = '') {
                axios.get('/api/v1/clients', {
                    params: {
                        status: status
                    }
                }).then((response) => {
                    this.clients = response.data.clients;
                })
            },
            filter() {
                this.getClients(this.status);
            },


        },
        mounted() {
            this.getClients();
        }
    }
</script>
