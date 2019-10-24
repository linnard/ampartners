<template>
    <div class="container p-5">
        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>
        <h2 class="Popup_title">Підтвердження бронювання</h2>
        <div class="Popup_content">Для підтвердження бронювання клієнта <span class="Popup_name">{{client.firstname}} {{client.lastname}}</span> введіть дату можливого прибуття:</div>
        <div class="Form Popup_form">
            <textarea name="comment" v-model="comment" placeholder="Введіть дату можливого прибуття..." class="Textarea"></textarea>
        </div>

        <div class="Popup_prompt">
            <button type="button" class="btn btn-success" @click="confirm">Підтвердити бронювання</button>
            <button type="button" class="btn btn-info float-right" @click="$emit('close')">Закрити вікно</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            client: {},
        },
        data() {
            return {
                status: 'ticket_expected',
                comment: ''
            };
        },
        methods: {

            confirm() {

                if (this.comment.length < 3){
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Для підтвердження бронювання клієнта введіть дату можливого прибуття.'
                    });
                    return;
                }

                axios.put('/api/v1/clients/' + this.client.id + '/status', {
                    status: this.status,
                    comment: this.comment
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Контакт передано партнеру для завантаження квитка.'
                    });

                    this.client.status = this.status;
                });
            },
        }
    }
</script>

