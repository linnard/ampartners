<template>
    <div class="container">
        <h2 class="h2 text-center">Деталі</h2>
        <hr>
        <div class="row">
            <div class="col text-right"><strong>ID:</strong></div>
            <div class="col text-left">{{company.creator.id}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Логін:</strong></div>
            <div class="col text-left">{{company.creator.login}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Ім’я:</strong></div>
            <div class="col text-left">{{company.creator.firstname}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Прізвище:</strong></div>
            <div class="col text-left">{{company.creator.lastname}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>По-батькові:</strong></div>
            <div class="col text-left">{{company.creator.patronymic}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Назва компанії:</strong></div>
            <div class="col text-left">{{company.name}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Телефон:</strong></div>
            <div class="col text-left">{{company.phone}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Viber:</strong></div>
            <div class="col text-left">{{company.viber}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Сайт:</strong></div>
            <div class="col text-left"><a :href="company.site" target="_blank">{{company.site}}</a></div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Посилання на ліцензію:</strong></div>
            <div class="col text-left"><a :href="company.license_url" target="_blank">{{company.license_url}}</a></div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Сторінка компанії на FaceBook:</strong></div>
            <div class="col text-left"><a :href="company.facebook_url" target="_blank">{{company.facebook_url}}</a></div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Сторінка компанії в Instagram:</strong></div>
            <div class="col text-left"><a :href="company.instagram_url" target="_blank">{{company.instagram_url}}</a></div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Сторінка компанії на іншому ресурсі:</strong></div>
            <div class="col text-left"><a :href="company.other_url" target="_blank">{{company.other_url}}</a></div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>Додаткова інформація:</strong></div>
            <div class="col text-left">{{company.additional_info}}</div>
            <div class="w-100"></div>

            <div class="col text-right"><strong>E-mail для повідомлень:</strong></div>
            <div class="col text-left">{{company.email}}</div>
            <div class="w-100"></div>
        </div>

        <hr>
        <div class="row">
                <div class="col text-right">
                    <button class="btn btn-info" @click="$emit('close')">Закрити вікно</button>
                </div>
                <div class="col text-center">
                    <button class="btn btn-success" @click="enable()"
                            v-if="company.creator.status === 0 || company.creator.status === 2">Одобрити
                    </button>
                </div>
                <div class="col text-left">
                    <button class="btn btn-danger" @click="disable()"
                            v-if="company.creator.status === 0 || company.creator.status === 1">Відмінити
                    </button>
                </div>

        </div>
        <br>
    </div>
</template>

<script>
    export default {
        props: {
            company: {}
        },
        methods: {
            enable() {
                this.$emit('close');
                this.updateStatus(1);
            },
            disable() {
                this.$emit('close');
                this.updateStatus(2);
            },

            updateStatus(status) {
                axios.put('/api/v1/users/' + this.company.creator.id + '/status', {
                    status: status
                }).then((response) => {
                    this.company.creator.status = status
                })
            },
        },
        mounted() {

        }
    }
</script>
