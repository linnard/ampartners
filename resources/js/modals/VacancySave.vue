<template>
    <div class="container">
        <h2 class="h2 text-center">Створення/редагування вакансії</h2>


        <form id="vacancySaveForm">
            <div class="row">
                <div class="col-6">


                    <div class="form-group">
                        <label>Назва (Українська):</label>
                        <input type="text" class="form-control" name="title[uk]" v-model="vacancy.title.uk">
                    </div>

                    <div class="form-group">
                        <label>Назва (Русский):</label>
                        <input type="text" class="form-control" name="title[ru]" v-model="vacancy.title.ru">
                    </div>

                    <div class="form-group">
                        <label>Опис для клієнтів:</label>
                        <textarea class="form-control" name="description" v-model="vacancy.description" rows="6"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Значення для сортування:</label>
                        <input type="number" class="form-control" name="sort" v-model="vacancy.sort">
                    </div>


                    <div class="form-group">
                        <label>Зміни:</label>
                        <textarea class="form-control" name="changes" v-model="vacancy.changes" rows="6"></textarea>
                    </div>


                    <div class="form-group">
                        <label>Опис (Українська):</label>
                        <ckeditor :editor="editor" v-model="vacancy.content.uk"/>
                        <input type="hidden" name="content[uk]" v-model="vacancy.content.uk">
                    </div>

                    <div class="form-group">
                        <label>Опис (Русский):</label>
                        <ckeditor :editor="editor"  v-model="vacancy.content.ru"/>
                        <input type="hidden" name="content[ru]" v-model="vacancy.content.ru">
                    </div>


                    <div class="form-group">
                        <label>Статус:</label>
                        <select class="form-control" name="status" v-model="vacancy.status">
                            <option v-for="(status, index) in vacancyStatuses" :value="index">
                                {{status}}
                            </option>
                        </select>

                        <!--v-select v-model="vacancy.status" :options="vacancy_statuses"/>-->
                    </div>


                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_urgently" v-model="vacancy.is_urgently"
                                   type="checkbox" value="1">
                            <label class="form-check-label">Терміновий набір!</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="is_individual_coordination"
                                   v-model="vacancy.is_individual_coordination" type="checkbox"
                                   value="1">
                            <label class="form-check-label">Індивідуальне погодження</label>
                        </div>
                    </div>
                </div>

                <div class="col-6">

                    <h4>Фильтр</h4>
                    <hr>

                    <article class="card-group-item" v-for="filter in filters">
                        <header class="card-header">
                            <h6 class="title">{{filter.name}}</h6>
                        </header>
                        <div class="filter-content">
                            <div class="card-body">


                                <div v-if="filter.type === 'radio'">
                                    <label class="form-check" v-for="item in filter.items">
                                        <input class="form-check-input" type="radio" name="filter_items[]"
                                               v-model="selectedFilterItems[filter.id]" :value="item.id">
                                        <span class="form-check-label">{{item.name}}</span>
                                    </label>
                                </div>


                                <div v-else-if="filter.type === 'checkbox'">
                                    <label class="form-check" v-for="item in filter.items">
                                        <input class="form-check-input" type="checkbox" name="filter_items[]"
                                               :value="item.id" :checked="vacancy.filter_items && vacancy.filter_items.find(i => i.id === item.id)">
                                        <span class="form-check-label">{{item.name}}</span>
                                    </label>
                                </div>


                                <div v-else-if="filter.type === 'age'">
                                    <div class="form-group">
                                        <label>Від:</label>
                                        <v-select v-model="vacancy.age_from" :options="config.age.from"/>
                                        <input type="hidden" name="age_from" v-model="vacancy.age_from">
                                    </div>

                                    <div class="form-group">
                                        <label>До:</label>
                                        <v-select v-model="vacancy.age_to" :options="config.age.to"/>
                                        <input type="hidden" name="age_to" v-model="vacancy.age_to">
                                    </div>
                                </div>


                                <div class="form-group" v-else-if="filter.type === 'select'">
                                    <!--<select name="filter_items[]">
                                        <option value="">Не вибрано</option>
                                        <option v-for="item in filter.items" :value="item.id"
                                                :selected="vacancy.filter_items && vacancy.filter_items.find(i => i.id === item.id)">
                                            {{item.name}}
                                        </option>
                                    </select>-->

                                    <v-select v-model="selectedFilterItems[filter.id]" :options="filter.items" :reduce="o => o.id" label="name"></v-select>
                                    <input type="hidden" name="filter_items[]" v-model="selectedFilterItems[filter.id]">

                                </div>


                            </div>
                        </div>
                    </article>


                </div>
            </div>

            <button type="button" @click="save()" class="btn btn-success">Зберегти</button>
        </form>


        <notifications/>
    </div>
</template>

<script>
    import CKEditor from '@ckeditor/ckeditor5-vue'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        components: {
            ckeditor: CKEditor.component
        },
        props: {
            vacancies: {},
            filters: {},
            vacancy: {},
            vacancyStatuses: {},
            config: {},
            //selectedFilterItems: [],
        },
        data() {
            return {
                editor: ClassicEditor,
                editorConfig: {},
                selectedFilterItems: [],

            };
        },
        methods: {
            save() {
                if (this.vacancy.id) {
                    this.update();
                } else {
                    this.create();
                }
            },

            create() {
                let form = document.getElementById('vacancySaveForm');
                let formData = new FormData(form);

                axios.post('/api/v1/vacancies', formData).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Вакансію успішно створено!'
                    });

                    this.vacancies.unshift(response.data.vacancy);
                }).catch(error => {
                    if (error.response) {
                        this.renderErrorMessages(error.response.data.errors);
                    }
                });
            },

            renderErrorMessages(errors) {
                _.each(errors, function (errors, field) {
                    _.each(errors, function (message, index) {
                        Vue.notify({
                            type: 'error',
                            title: 'Помилка',
                            text: message
                        });
                    });
                });
            },

            update() {

                let form = document.getElementById('vacancySaveForm');
                let formData = new FormData(form);
                formData.append('_method', 'put');

                axios.post('/api/v1/vacancies/' + this.vacancy.id, formData).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Вакансію успішно змінено!'
                    });

                    var index = this.vacancies.indexOf(this.vacancy);
                    this.vacancies.splice(index, 1, response.data.vacancy);
                }).catch(error => {
                    if (error.response) {
                        this.renderErrorMessages(error.response.data.errors);
                    }
                });
            },


        },

        mounted() {
            //this.selectedPermissions = this.pluck(this.user.permissions, 'id');
            //this.selectedFilterItems = this.pluck(this.vacancy.filter_items, 'id');

            if(this.vacancy.filter_items){
                let selected = [];
                this.vacancy.filter_items.forEach(item => {

                    var list = selected[item.filter_id];

                    if (list) {
                        list.push(item.id);
                    } else {
                        selected[item.filter_id] = [item.id];
                    }
                });


                this.selectedFilterItems = selected;
            }


            //console.log(selected);
            // :selected="user.roles && user.roles.find(i => i.id === role.id)"

        }
    }
</script>

