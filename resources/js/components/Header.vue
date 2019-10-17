<template>
    <div>
        <header class="Header">

            <a href="/" title="AMpartners" class="Logo Header_logo" v-if="$authUser.roles.includes('partner')">
                <img src="/img/small_logo.png" alt="Логотип" class="Logo_img">
            </a>

            <a href="/" title="AMpartners" class="SiteName SiteName-cherry Header_siteName" v-if="$authUser.roles.includes('admin')">
                <span class="SiteName_first">AM</span>partners
            </a>

            <div class="MainMenu Header_menu">
                <ul class="MainMenu_list">

                    <li class="MainMenu_item" v-for="item in $router.options.routes" :key="item.path">
                        <router-link :to="item.path" class="MainMenu_link" v-if="$authUser.roles.includes(item.role)">{{
                            item.name }}
                        </router-link>

                        <!--<ul v-if="item.path == $router.currentRoute.path">
                            <li class="SecondaryMenu_item" v-for="child in item.children" :key="child.path">
                                <router-link :to="item.path+'/'+child.path">{{ child.name }}</router-link>
                            </li>
                        </ul>-->

                    </li>

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

                <div class="SecondaryMenu Top_secondaryMenu">
                    <ul class="SecondaryMenu_list">

                        <!--<li class="SecondaryMenu_item" v-for="child in $router.currentRoute.children" :key="child.path">
                            <router-link :to="child.path">{{ child.name }}</router-link>
                        </li>-->


                        <!-- <li class="SecondaryMenu_item"><a href="#" class="SecondaryMenu_link">Всі контакти <span class="Number SecondaryMenu_number">4</span></a></li>
                         <li class="SecondaryMenu_item"><a href="#" class="SecondaryMenu_link">Заявки на бронювання</a></li>
                         <li class="SecondaryMenu_item"><a href="#" class="SecondaryMenu_link">Контакти з квитком</a></li>
                         <li class="SecondaryMenu_item"><a href="#" class="SecondaryMenu_link">Успішно завершені</a></li>-->
                    </ul>
                </div>
            </div>


            <notifications-block v-if="$authUser.roles.includes('partner')"></notifications-block>

        </section>
    </div>
</template>

<script>

    export default {
        props: [],
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
        },
        mounted() {
            //children: () => this.$router.currentRoute.children
            //console.log('Component mounted 1.');
            //console.log({router: this.$router.currentRoute.path});
            //console.log(this.firstname);
        }
    }
</script>
