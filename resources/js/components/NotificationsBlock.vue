<template>
    <div class="Top_right">
        <label @click="showNotifications"
               class="NotificationsBlock Top_notificationsBlock" :class="{ 'NotificationsBlock-new': unread_notifications }">
            <img src="/img/svg/info.svg" alt="" class="NotificationsBlock_icon">
            <span class="Number NotificationsBlock_number" v-if="unread_notifications">{{unread_notifications}}</span>
        </label>

        <label @click="showHistory"
               class="NotificationsBlock Top_notificationsBlock">
            <img src="/img/svg/logs.svg" alt="" class="NotificationsBlock_icon">
        </label>
    </div>
</template>

<script>

    import Logs from "../modals/Logs";
    import Notifies from "../modals/Notifies";

    export default {
        props: [],
        data() {
            return {
                unread_notifications: 0,
                logs: {},
                notifications: {}
            }
        },
        methods: {
            logout() {
                axios.post('/logout').then(function () {
                    document.location.href = "/login";
                })
            },

            getNotifications() {
                axios.get('/api/v1/notifications').then((response) => {
                    this.notifications = response.data.notifications;
                    this.unread_notifications = response.data.unread;
                })
            },

            getLogs() {
                axios.get('/api/v1/logs').then((response) => {
                    this.logs = response.data.logs;
                })
            },

            showNotifications() {
                this.$modal.show(Notifies, {
                    notifies: this.notifications,
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 1200
                });

                this.readNotifications();
            },

            showHistory() {
                this.$modal.show(Logs, {
                    logs: this.logs,
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 1200
                });
            },

            readNotifications() {
                axios.put('/api/v1/notifications/read').then((response) => {
                    this.unread_notifications = 0;
                })
            }
        },
        mounted() {
            this.getNotifications();
            this.getLogs();


            if (this.$authUser.companies){
                var companies = this.$authUser.companies;
                for (var k in companies){
                    Echo.channel('Company.' + companies[k].id)
                        .listen('.NotificationCreated', (e) => {
                            this.notifications.unshift(e.notification);
                            this.unread_notifications++;
                        });
                }
            }


        }
    }
</script>

