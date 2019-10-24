<template>
    <div class="container p-5">
        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>

        <h2 class="Popup_title">Підтвердження квитка</h2>
        <div class="Popup_content">Для підтвердження квитка та подальшого бронювання клієнта <span class="Popup_name">{{client.firstname}} {{client.lastname}}</span>
            введіть дані координатора та всю необхідну інформацію:
        </div>
        <div class="Form Popup_form">
            <datetime v-model="complete_at"
                      type="datetime"
                      :min-datetime="datetimeMin"
                      :title="'Дата та час завершення'">
            </datetime>
            <br>
            <textarea name="comment" v-model="comment" placeholder="Введіть дані координатора..."
                      class="Textarea"></textarea>
        </div>
        <div class="Popup_prompt">
            <button type="button" @click="confirm" class="btn btn-success">Підтвердити квиток</button>
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
                datetimeMin: new Date().toISOString(),
                comment: '',
                complete_at: ''
            };
        },
        methods: {

            confirm() {
                var errors = [];

                if (this.comment.length <= 3) {
                    errors.push('Введіть дані координатора та всю необхідну інформацію');
                }

                if (!this.complete_at.length) {
                    errors.push('Виберіть дату та час завершення');
                } else {
                    var now = Date.now();
                    var completed = Date.parse(this.complete_at);
                    if (completed < now) {
                        errors.push('Не можна вказувати час та дату, які вже минули!');
                    }
                }

                if (errors.length) {
                    errors.forEach(function (error) {
                        Vue.notify({
                            type: 'error',
                            title: 'Помилка',
                            text: error
                        });
                    });

                    return;
                }


                axios.post('/api/v1/clients/' + this.client.id + '/complete', {
                    comment: this.comment,
                    complete_at: this.complete_at,
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Успішно завершено.'
                    });

                    this.client.status = 'completed';
                });
            },
        },
        mounted() {
            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(9, 0, 0);
            this.complete_at = tomorrow.toISOString();
        }
    }
</script>

