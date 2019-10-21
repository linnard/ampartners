<template>
    <div>
        <button class="btn btn-info" @click="create()">Створити вакансію</button>

        <div class="row">
            <div class="col-6">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Назва</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="vacancy in vacancies" :class="[(vacancy.is_active) ? 'table-success':'table-danger']">
                        <th scope="row">{{vacancy.id}}</th>
                        <td>{{vacancy.name}}</td>

                        <td>
                            <button type="button" class="btn btn-warning" @click="edit(vacancy)">Редагувати</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" @click="showDetails(vacancy)">Повна інформація</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" @click="updateStatus(vacancy, status_enabled)" v-if="!vacancy.is_active">Активувати</button>
                            <button type="button" class="btn btn-danger" @click="updateStatus(vacancy, status_disabled)" v-if="vacancy.is_active">Деактивувати</button>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <notifications/>
        <modals-container/>
    </div>
</template>

<script>
    import VacancySave from '../modals/VacancySave'
    import VacancyDetails from '../modals/VacancyDetails'

    export default {
        data() {
            return {
                vacancies: {},
                status: '',
                status_enabled: 1,
                status_disabled: 0
            }
        },
        methods: {
            create() {
                this.$modal.show(VacancySave, {
                    vacancies: this.vacancies,
                    vacancy: {
                        id: 0,
                        name: '',
                        description: ''
                    },
                }, {
                    height: 500,
                    width: 700
                })
            },

            edit(vacancy) {
                this.$modal.show(VacancySave, {
                    vacancies: this.vacancies,
                    vacancy: vacancy
                }, {
                    height: 500,
                    width: 700
                })
            },

            showDetails(vacancy) {
                this.$modal.show(VacancyDetails, {
                    vacancy: vacancy
                }, {
                    resizable: true,
                    scrollable: true,
                    height: 500,
                    width: 700
                })
            },

            getVacancies(is_active = '') {
                axios.get('/api/v1/vacancies', {
                    params: {
                        is_active: is_active
                    }
                }).then((response) => {
                    this.vacancies = response.data.vacancies;
                })
            },

            updateStatus(vacancy, status) {
                axios.put('/api/v1/vacancies/' + vacancy.id, {
                    is_active: status
                }).then((response) => {
                    var index = this.vacancies.indexOf(vacancy);
                    this.vacancies.splice(index, 1, response.data.vacancy);
                })
            },


        },
        mounted() {
            this.getVacancies();
        }
    }
</script>
