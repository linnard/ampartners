<template>
    <div class="container p-5">
        <label class="Popup_close" @click="$emit('close')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"
                      fill="#B8B8B8"></path>
            </svg>
        </label>
        <h2 class="Popup_title">Підтвердження бронювання</h2>
        <div class="Popup_content">Ви дійсно хочете забронювати контакт <span class="Popup_name">{{client.firstname}} {{client.lastname}}</span>?
            Зверніть увагу, що після бронювання ви не зможете редагувати та вносити будь-які зміни по цьому контакту.
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
                status: 'booking_confirmation_expected'
            };
        },
        methods: {

            confirm() {
                axios.put('/api/v1/clients/' + this.client.id + '/status', {
                    status: this.status
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Контакт очікує підтвердження бронювання.'
                    });

                    this.client.status = this.status;
                });
            },
        }
    }
</script>

