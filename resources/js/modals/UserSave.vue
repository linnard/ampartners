<template>
    <div class="container">
        <h2 class="h2 text-center">Створення/редагування користувача</h2>


        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="login">Логін:</label>
                        <input type="text" class="form-control" id="login" v-model="user.login">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" class="form-control" id="password" v-model="user.password">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Ім’я:</label>
                        <input type="text" class="form-control" id="firstname" v-model="user.firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Прізвище:</label>
                        <input type="text" class="form-control" id="lastname" v-model="user.lastname">
                    </div>
                    <div class="form-group">
                        <label for="patronymic">По-батькові:</label>
                        <input type="text" class="form-control" id="patronymic" v-model="user.patronymic">
                    </div>


                    <div class="form-group">
                        <label>Роль:</label>
                        <v-select v-model="user.roles" :options="roles" label="name" multiple/>
                        <!--<select class="form-control" id="role" v-model="selectedRoles">
                            <option v-for="(role, index) in roles" :value="role.id" :index="index">
                                {{role.name}}
                            </option>
                        </select>-->
                    </div>
                </div>

                <div class="col-6">

                    <h4>Права</h4>
                    <hr>
                    <template v-for="permission in permissions">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" v-model="selectedPermissions"
                                   :value="permission.id" :id="'Permission'+permission.id">
                            <label class="form-check-label" :for="'Permission'+permission.id">
                                {{permission.title}}
                            </label>
                        </div>
                    </template>


                </div>
            </div>

            <button type="button" @click="save()" class="btn btn-success">Зберегти</button>
        </form>


        <notifications/>
    </div>
</template>

<script>
    export default {
        props: {
            users: {},
            roles: {},
            permissions: {},
            user: {},
        },
        data() {
            return {
                selectedPermissions: [],
            };
        },
        methods: {
            save() {
                if (this.user.id) {
                    this.update();
                } else {
                    this.create();
                }
            },

            create() {
                axios.post('/api/v1/users', {
                    login: this.user.login,
                    password: this.user.password,
                    firstname: this.user.firstname,
                    lastname: this.user.lastname,
                    patronymic: this.user.patronymic,
                    roles: this.pluck(this.user.roles, 'id'),
                    permissions: this.selectedPermissions,
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Користувача успішно створено!'
                    });

                    this.users.unshift(response.data.user);
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

                axios.put('/api/v1/users/' + this.user.id, {
                    login: this.user.login,
                    password: this.user.password,
                    firstname: this.user.firstname,
                    lastname: this.user.lastname,
                    patronymic: this.user.patronymic,
                    roles: this.pluck(this.user.roles, 'id'),
                    permissions: this.selectedPermissions,
                }).then((response) => {

                    this.$emit('close');

                    Vue.notify({
                        type: 'success',
                        title: 'Успіх',
                        text: 'Користувача успішно змінено!'
                    });

                    var index = this.users.indexOf(this.user);
                    this.users.splice(index, 1, response.data.user);
                }).catch(error => {
                    if (error.response) {
                        this.renderErrorMessages(error.response.data.errors);
                    }
                });
            },




        },

        mounted() {
            this.selectedPermissions = this.pluck(this.user.permissions, 'id');
            //this.selectedRoles = this.pluck(this.user.roles, 'id');

            //console.log(this.selectedRoles);
            // :selected="user.roles && user.roles.find(i => i.id === role.id)"

        }
    }
</script>

