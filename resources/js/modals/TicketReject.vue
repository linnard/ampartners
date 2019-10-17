<template>
    <div class="container p-5">
        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>

        <h2 class="Popup_title">Повернення клієнта</h2>
        <div class="Popup_content">
            Для того щоб повернути на допрацювання клієнта <span class="Popup_name">{{client.firstname}} {{client.lastname}}</span> (партнер {{client.user.firstname}} {{client.user.lastname}} / {{client.company.name}}) введіть текст причини в поле нижче:
        </div>
        <div class="Form Popup_form">
            <textarea name="comment" v-model="comment" placeholder="Введіть текст причини повернення"
                      class="Textarea"></textarea>
        </div>
        <div class="Popup_prompt">
            <button type="button" @click="confirm" class="btn btn-success">Повернути клієнта</button>
            <button type="button" class="btn btn-info" @click="$emit('close')">Закрити вікно</button>
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
                status: 'ticket_confirmation_rejected',
                comment: ''
            };
        },
        methods: {

            confirm() {

                if (this.comment.length < 3){
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Напишіть причину повернення.'
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
                        text: 'Клієнта повернуто на допрацювання.'
                    });

                    this.client.status = this.status;
                });
            },
        }
    }
</script>

