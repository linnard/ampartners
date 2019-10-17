<template>
    <div class="Top_right">
        <label @click="showLogs"
               class="NotificationsBlock NotificationsBlock-new Top_notificationsBlock">
            <img src="/img/svg/info.svg" alt="" class="NotificationsBlock_icon">
            <span class="Number NotificationsBlock_number" v-if="unread">{{unread}}</span>
        </label>
    </div>
</template>

<script>

    import Logs from "../modals/Logs";

    export default {
        props: [],
        data() {
            return {
                unread: 0,
                logs: {}
            }
        },
        methods: {
            logout() {
                axios.post('/logout').then(function () {
                    document.location.href = "/login";
                })
            },

            getLogs() {
                axios.get('/api/v1/logs').then((response) => {
                    this.logs = response.data.logs;
                    this.unread = response.data.unread;
                })
            },

            showLogs() {
                this.$modal.show(Logs, {
                    logs: this.logs,
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 1200
                });

                this.read();
            },

            read(){
                axios.put('/api/v1/logs/read').then((response) => {
                    this.unread = 0;
                })
            }
        },
        mounted() {
            this.getLogs();
        }
    }
</script>

