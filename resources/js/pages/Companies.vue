<template>
    <div>

        <div class="col-2">
            <select id="status" @change="filter($event)" v-model="status" class="form-control">
                <option value="" selected>Всі</option>
                <option value="0">Заявки</option>
                <option value="1">Активні</option>
                <option value="2">Відхилені</option>
            </select>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Логін</th>
                <th scope="col">Ім’я</th>
                <th scope="col">Прізвище</th>
                <th scope="col">По-батькові</th>
                <th scope="col">Назва компанії</th>
                <th scope="col">Телефон</th>
                <th scope="col">Viber</th>
                <th scope="col">Сайт</th>
                <th scope="col">Посилання на ліцензію</th>
                <th scope="col">Сторінка компанії на FaceBook</th>
                <th scope="col">Сторінка компанії в Instagram</th>
                <th scope="col">Сторінка компанії на іншому ресурсі</th>
                <th scope="col">Додаткова інформація про компанію</th>
                <th scope="col">E-mail для повідомлень</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="company in companies" :class="{'table-success': company.creator.status === 1, 'table-danger': company.creator.status === 2}">
                <th scope="row">{{company.id}}</th>
                <td>{{company.creator.login}}</td>
                <td>{{company.creator.firstname}}</td>
                <td>{{company.creator.lastname}}</td>
                <td>{{company.creator.patronymic}}</td>
                <td>{{company.name}}</td>
                <td>{{company.phone}}</td>
                <td>{{company.viber}}</td>
                <td>{{company.site}}</td>
                <td>{{company.license_url}}</td>
                <td>{{company.facebook_url}}</td>
                <td>{{company.instagram_url}}</td>
                <td>{{company.other_url}}</td>
                <td>{{company.additional_info}}</td>
                <td>{{company.email}}</td>

                <td>
                    <button type="button" class="btn btn-success" @click="enable(company.creator.id, index)" v-if="company.creator.status === 0 || company.creator.status === 2">Одобрити</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" @click="disable(company.creator.id, index)" v-if="company.creator.status === 0 || company.creator.status === 1">Відмінити</button>
                </td>
            </tr>

            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                companies: {},
                status: '',
                index: '',
            }
        },
        methods: {
            getCompanies(status = '') {
                axios.get('/api/v1/companies', {
                    params: {
                        status: status
                    }
                }).then((response) => {
                    this.companies = response.data.companies;
                })
            },
            filter() {
                this.getCompanies(this.status);
            },
            enable(user_id, index) {
                axios.put('/api/v1/users/' + user_id, {
                     status: 1
                }).then((response) => {
                    this.companies.splice(index, 1)
                })
            },
            disable(user_id, index) {
                axios.put('/api/v1/users/' + user_id, {
                    status: 2
                }).then((response) => {
                    this.companies.splice(index, 1)
                })
            }

        },
        mounted() {
            this.getCompanies();
            //console.log('Component mounted.')
        }
    }
</script>
