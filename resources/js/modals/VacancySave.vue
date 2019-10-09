<template>
    <div class="container">
        <h2 class="h2 text-center">Створення/редагування вакансії</h2>
        <form>
            <div class="form-group">
                <label for="name">Назва:</label>
                <input type="text" class="form-control" id="name" v-model="name">
            </div>
            <div class="form-group">
                <label for="description">Опис:</label>
                <ckeditor :editor="editor" :config="editorConfig" v-model="description" id="description"></ckeditor>
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
            vacancy: {}
        },
        data() {
            return {
                editor: ClassicEditor,
                editorConfig: {},
                name: this.vacancy.name,
                description: this.vacancy.description,
                id: this.vacancy.id
            };
        },
        methods: {
            save() {

                if (!this.name.length || !this.description.length){
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Потрібно заповнити усі поля'
                    });
                    return;
                }

                if (this.id){
                    this.update();
                } else {
                    this.create();
                }


            },

            create(){
                axios.post('/api/v1/vacancies', {
                    name: this.name,
                    description: this.description
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Вакансію успішно створено!'
                    });

                    this.vacancies.push(response.data.vacancy);
                });
            },

            update(){
                axios.put('/api/v1/vacancies/' + this.id, {
                    name: this.name,
                    description: this.description
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Вакансію успішно змінено!'
                    });

                    var index = this.vacancies.indexOf(this.vacancy);
                    this.vacancies.splice(index, 1, response.data.vacancy);
                });
            },

            updateStatus(status) {
                axios.put('/api/v1/users/' + this.company.creator.id, {
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

<style>
    .ck-editor__editable {
        height: 200px;
    }
</style>
