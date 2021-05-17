<template>
    <div>
        <div class="row m-2">
            <div class="col-2">
                <button class="btn btn-info" @click="create()">Створити вакансію</button>
            </div>

            <div class="col-2">
                <select id="status" @change="getVacancies(status)" v-model="status" class="form-control">
                    <option value="">Всі</option>
                    <option v-for="(status, key) in vacancyStatuses" :value="key">{{status}}</option>
                </select>
            </div>
        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Назва</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="vacancy in vacancies">
                <td>{{vacancy.id}}</td>
                <td>{{vacancy.title.ru}} / {{vacancy.title.uk}}</td>
                <td>
                <td>
                    <button type="button" class="btn btn-warning" @click="edit(vacancy)">Редагувати</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" @click="destroy(vacancy)">Видалити</button>
                </td>
            </tr>

            </tbody>
        </table>

        <modals-container/>
    </div>
</template>

<script>
    import VacancySave from '../modals/VacancySave'

    export default {
        data() {
            return {
                vacancies: {},
                filters: {},
                status: '',
                config: [],
                vacancyStatuses: [],
            }
        },

        methods: {
            create() {
                this.$modal.show(VacancySave, {
                    vacancies: this.vacancies,
                    filters: this.filters,
                    vacancyStatuses: this.vacancyStatuses,
                    config: this.config,
                    vacancy: {
                        id: 0,
                        title: {
                            ru: '',
                            uk: '',
                        },
                        content: {
                            ru: '',
                            uk: '',
                        },
                        changes: '',
                        status: '',
                    },
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 800
                })
            },

            destroy(vacancy) {
                if (confirm('Ви дійсно хочете видалити цю вакансію?')) {
                    axios.delete('/api/v1/vacancies/' + vacancy.id).then((response) => {
                        this.getVacancies();
                        Vue.notify({
                            type: 'success',
                            title: 'Успіх',
                            text: 'Вакансію успішно видалено!'
                        });
                    });
                }
            },

            edit(vacancy) {
                this.$modal.show(VacancySave, {
                    vacancies: this.vacancies,
                    filters: this.filters,
                    vacancyStatuses: this.vacancyStatuses,
                    config: this.config,
                    vacancy: vacancy
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 800
                })
            },
            getVacancies(status = '') {
                axios.get('/api/v1/vacancies', {
                    params: {
                        ...(status ? {status: status} : {})
                    }
                }).then((response) => {
                    this.vacancies = response.data.vacancies;
                })
            },

            loadFilters() {
                axios.get('/api/v1/filters').then((response) => {
                    this.filters = response.data.filters;
                });
            },

            loadFiltersConfig() {
                axios.get('/api/v1/config/filters').then((response) => {
                    this.config = response.data.config;
                });
            },

            loadVacancyStatuses() {
                axios.get('/api/v1/vacancy-statuses').then((response) => {
                    this.vacancyStatuses = response.data.statuses;
                });
            },

        },
        mounted() {
            this.getVacancies();
            this.loadFilters();
            this.loadFiltersConfig();
            this.loadVacancyStatuses();
        }
    }
</script>
