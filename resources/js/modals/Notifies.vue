<template>
    <div class="container p-5">

        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>
        <h2 class="Popup_title">
            <span>Сповіщення</span>
        </h2>
        <div class="notifications-body">
            <div class="list_notification">
                <div class="item_notification" style="position: relative;" v-for="notification in notifies">
                    <div>
                        <span>Тип операції: <strong style="color: #a41710">{{notification.event}}</strong></span>
                        <span>Назва відділу: <strong>Адміністрація AMpartners</strong></span>
                        <span>Дата: <strong>{{notification.created_at}}</strong></span>
                        <span>ПІБ Клієнта: <strong>{{notification.client.firstname}} {{notification.client.lastname}}</strong></span>
                        <span>ID клієнта: <strong>{{notification.client_id}}</strong></span>
                    </div>
                    <div>
                        <span>Детальна інформація: <strong>{{notification.body}}</strong></span>
                    </div>
                    <button class="btn btn-success" style="position: absolute;right: 40px;top: 30px;"
                            @click="selectClient(notification.client_id)">Перейти до клієнта
                    </button>
                </div>
            </div>
            <div class="close_notification">
                <button @click="$emit('close')" class="btn btn-info">Закрити</button>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            notifies: {}
        },
        data() {
            return {};
        },
        methods: {
            selectClient(id) {
                this.$root.$emit('clientSelected', id);
                this.$emit('close');
            },
        },
        mounted() {

        }

    }
</script>

