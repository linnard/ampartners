<template>
    <div class="Wrapper">
        <header class="Header">

            <a href="/" title="AMpartners" class="Logo Header_logo">
                <img src="/img/small_logo.png" alt="Логотип" class="Logo_img">
            </a>

            <a href="/" title="AMpartners" class="SiteName SiteName-cherry Header_siteName" v-if="$authUser.roles.includes('admin')">
                <span class="SiteName_first">AM</span>partners
            </a>

            <div class="MainMenu Header_menu">

                <ul class="MainMenu_list">

                    <router-link v-for="item in $router.options.routes"
                                 :key="item.path"
                                 :to="item.path"
                                 tag="li"
                                 class="MainMenu_item"
                                 v-if="$authUser.roles.includes(item.role) && (!item.permission.length || $authUser.permissions.includes(item.permission))"
                                 exact>
                        <a class="MainMenu_link">{{ item.meta.name }}</a>
                        <span class="Number SecondaryMenu_number" :ref="item.meta.counter_id" v-if="item.meta.counter_id"></span>
                    </router-link>



                    <!--<ul v-if="item.path == $router.currentRoute.path">
                        <li class="SecondaryMenu_item" v-for="child in item.children" :key="child.path">
                            <a :to="item.path+'/'+child.path">{{ child.name }}</a>
                        </li>
                    </ul>-->


                </ul>
            </div>
        </header>

        <section class="Top">
            <div class="Top_left">
                <div class="Welcome Top_welcome">
                    <div class="Welcome_userPhoto">
                        <img src="/img/user.png" alt="Фото">
                    </div>
                    <div class="Welcome_text">
                        Привіт, <span class="Welcome_userName">{{$authUser.firstname}} {{$authUser.lastname}}!</span>
                    </div>
                </div>

                <a class="Link Top_logout" href="javascript:;" @click="logout()">Вийти</a>


            </div>
            <notifications-block v-if="$authUser.roles.includes('partner')"></notifications-block>

        </section>

        <main class="Main">
            <router-view></router-view>
        </main>

    </div>
</template>

<script>

    export default {
        props: {},
        data() {
            return {

            }
        },
        methods: {
            logout() {
                axios.post('/logout').then(function () {
                    document.location.href = "/login";
                })
            },

            updateCounts(){
                axios.get('/api/v1/counts').then((response) => {

                    this.$refs.new_clients_count[0].innerHTML = (response.data.counts.new_clients) ? response.data.counts.new_clients : '';
                });
            }
        },
        mounted: function () {

            if (this.$authUser.roles.includes('admin')){
                this.updateCounts();

                Echo.channel('Client')
                    .listen('.CountsUpdated', (e) => {
                        this.$refs.new_clients_count[0].innerHTML = (e.counts.new_clients) ? e.counts.new_clients : '';
                    });
            }

        },
    }
</script>
