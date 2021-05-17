<template>
    <div>
        <button class="btn btn-info" @click="create()">Створити користувача</button>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Логін</th>
                <th scope="col">Ім’я</th>
                <th scope="col">Прізвище</th>
                <th scope="col">По-батькові</th>
                <th scope="col">Ролі</th>
                <th scope="col">Права</th>


                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <th scope="row">{{user.id}}</th>
                <td>{{user.login}}</td>
                <td>{{user.firstname}}</td>
                <td>{{user.lastname}}</td>
                <td>{{user.patronymic}}</td>
                <td>
                    <ul>
                        <li v-for="role in user.roles">
                            {{role.name}}
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="permission in user.permissions">
                            {{permission.title}}
                        </li>
                    </ul>
                </td>
                <td><button type="button" class="btn btn-warning" @click="edit(user)">Редагувати</button></td>
            </tr>

            </tbody>
        </table>

        <modals-container/>
    </div>
</template>

<script>
    import UserSave from '../modals/UserSave'

    export default {
        data() {
            return {
                users: {},
                roles: {},
                status: '',
            }
        },

        methods: {
            create() {
                this.$modal.show(UserSave, {
                    users: this.users,
                    roles: this.roles,
                    permissions: this.permissions,
                    user: {
                        id: 0,
                        login: '',
                        password: '',
                        firstname: '',
                        lastname: '',
                    },
                }, {
                    height: 600,
                    width: 700
                })
            },
            edit(user) {
                this.$modal.show(UserSave, {
                    users: this.users,
                    roles: this.roles,
                    permissions: this.permissions,
                    user: user
                }, {
                    height:600,
                    width: 700
                })
            },
            getUsers(status = '') {
                axios.get('/api/v1/users', {
                    params: {
                        ...(status ? {status: status} : {})
                    }
                }).then((response) => {
                    this.users = response.data.users;
                })
            },

            loadRoles() {
                axios.get('/api/v1/roles').then((response) => {
                    this.roles = response.data.roles;
                });
            },

            loadPermissions() {
                axios.get('/api/v1/permissions').then((response) => {
                    this.permissions = response.data.permissions;
                });
            },
        },
        mounted() {
            this.getUsers();
            this.loadRoles();
            this.loadPermissions();
        }
    }
</script>
