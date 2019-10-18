<template>
    <div class="container p-5">

        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>
        <h2 class="Popup_title">Сповіщення</h2>
        <div class="notifications-body">
            <div class="list_notification">
                <div class="item_notification" style="position: relative;" v-for="log in logs">
                    <div>
                        <span>Тип операції: <strong style="color: #a41710">{{log.status_description}}</strong></span>
                        <span>Назва відділу: <strong>Адміністрація AMpartners</strong></span>
                        <span>Дата: <strong>{{log.created_at}}</strong></span>
                        <span>Партнеру: <strong>{{log.user.firstname}} {{log.user.lastname}}</strong></span>
                        <span>ПІБ Клієнта: <strong>{{log.client.firstname}} {{log.client.lastname}}</strong></span>
                        <span>ID клієнта: <strong>{{log.client_id}}</strong></span>
                    </div>
                    <div>
                        <span>Детальна інформація: <strong>{{log.comment}}</strong></span>
                    </div>
                    <button class="btn btn-success" style="position: absolute;right: 40px;top: 30px;"
                            @click="selectClient(log.client_id)">Перейти до клієнта
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
            logs: {}
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

    }
</script>

