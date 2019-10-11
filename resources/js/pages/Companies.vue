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
                <td><a :href="company.site" target="_blank">{{company.site}}</a></td>
                <td><a :href="company.license_url" target="_blank">{{company.license_url}}</a></td>
                <td><button type="button" class="btn btn-info" @click="showDetails(company)">Повна інформація</button></td>
              </tr>

            </tbody>
        </table>

        <modals-container/>
    </div>
</template>

<script>

    import CompanyDetails from "../modals/CompanyDetails";

    export default {
        data() {
            return {
                companies: {},
                status: '',
            }
        },
        methods: {
            showDetails(company) {
                this.$modal.show(CompanyDetails, {
                    company: company
                }, {
                    resizable: true,
                    scrollable: true,
                    height: 'auto',
                    width: 1200
                })
            },
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


        },
        mounted() {
            this.getCompanies();
        }
    }
</script>
