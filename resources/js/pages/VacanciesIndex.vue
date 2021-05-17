<template>
    <div>
        <div class="Jobs">
            <form action="#" class="JobFilter Jobs_filter" id="FormFilter">
                <div class="JobFilter_content" id="JobFilter_content">

                    <div class="ChoiceBlock JobFilter_choiceBlock">
                        <div class="ChoiceBlock_header">
                            <span class="ChoiceBlock_close" @click="clearFilter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8.844" height="8.844">
                                    <path d="M8.559 1.663L5.808 4.421 8.529 7.15a.982.982 0 0 1-1.387 1.391L4.421 5.812 1.7 8.541A.983.983 0 0 1 .312 7.15l2.721-2.729L.282 1.663A.982.982 0 1 1 1.669.272L4.421 3.03 7.172.272a.982.982 0 1 1 1.387 1.391z"
                                          fill="#8d0000" fill-rule="evenodd"></path></svg> Очистити все</span>
                        </div>
                    </div>

                    <div class="FilterElement FilterElement-large JobFilter_item">
                        <div class="FilterElement_header FilterElement_header-spaceBetween">
                            <h4 class="FilterElement_title">Сортування</h4>
                        </div>
                        <div class="FilterElement_content">
                            <v-select v-model="selectedOrder" :options="orders" :reduce="o => o.code" label="label"
                                      @input="applyFilter"/>
                            <input type="hidden" name="order" v-model="selectedOrder">
                        </div>
                    </div>

                    <div class="FilterElement FilterElement-large JobFilter_item">
                        <div class="FilterElement_header FilterElement_header-spaceBetween">
                            <h4 class="FilterElement_title">Мова</h4>
                        </div>
                        <div class="FilterElement_content">
                            <v-select v-model="selectedLang" :options="languages" :reduce="o => o.code" label="label"
                                      @input="applyFilter"/>
                            <input type="hidden" name="lang" v-model="selectedLang">
                        </div>
                    </div>


                    <div v-for="filter in filters">
                        <div class="FilterElement JobFilter_item" v-if="filter.type === 'radio'">
                            <div class="FilterElement_header FilterElement_header-spaceBetween">
                                <h4 class="FilterElement_title">{{filter.name}}</h4>
                            </div>
                            <div class="FilterElement_content">
                                <div class="RadioBtnsList RadioBtnsList-flex">

                                    <div class="RadioBtn RadioBtnsList_item" v-for="item in filter.items">
                                        <input class="RadioBtn_input FilterItem" type="radio"
                                               :name="'filters['+filter.id+'][]'"
                                               :value="item.id" @click="applyFilter()">
                                        <label class="RadioBtn_label">{{item.name}}</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="FilterElement JobFilter_item" v-else-if="filter.type === 'checkbox'">
                            <div class="FilterElement_header FilterElement_header-spaceBetween">
                                <h4 class="FilterElement_title">{{filter.name}}</h4>
                            </div>
                            <div class="FilterElement_content">
                                <div class="CheckboxList">
                                    <div class="CheckboxList_content"
                                         :class="filter.slug !== 'city' ? 'CheckboxList_content-flex':''">
                                        <div class="Checkbox Checkbox-filterElement CheckboxList_item"
                                             v-for="item in filter.items">
                                            <input class="Checkbox_input FilterItem" type="checkbox"
                                                   :name="'filters['+filter.id+'][]'"
                                                   :id="'filters['+filter.id+']['+item.id+']'"
                                                   :value="item.id" @change="applyFilter()">
                                            <label class="Checkbox_label" :for="'filters['+filter.id+']['+item.id+']'">{{item.name}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="FilterElement JobFilter_item" v-else-if="filter.type === 'age'">
                            <div class="FilterElement_header FilterElement_header-spaceBetween">
                                <h4 class="FilterElement_title">{{filter.name}}</h4>
                            </div>
                            <div class="FilterElement_content">
                                <div class="FilterElement_selects">
                                    <div class="FilterElement_selectItem">
                                        <label class="FilterElement_selectLabel">Від</label>
                                        <v-select v-model="selectedAgeFrom" :options="config.age.from"
                                                  @input="applyFilter"/>
                                        <input type="hidden" :name="'filters['+filter.id+'][from]'"
                                               :id="'filters['+filter.id+'][from]'" v-model="selectedAgeFrom">
                                    </div>
                                    <div class="FilterElement_selectItem">
                                        <label class="FilterElement_selectLabel">До</label>
                                        <v-select v-model="selectedAgeTo" :options="config.age.to"
                                                  @input="applyFilter"/>
                                        <input type="hidden" :name="'filters['+filter.id+'][to]'"
                                               :id="'filters['+filter.id+'][to]'" v-model="selectedAgeTo">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="FilterElement FilterElement-large JobFilter_item"
                             v-else-if="filter.type === 'select'">
                            <div class="FilterElement_header FilterElement_header-spaceBetween">
                                <h4 class="FilterElement_title">{{filter.name}}</h4>
                            </div>
                            <div class="FilterElement_content">
                                <v-select v-model="selectedFilterItems[filter.id]" :options="filter.items"
                                          :reduce="o => o.id" label="name" @input="applyFilter"/>
                                <input type="hidden" :name="'filters['+filter.id+']'" :id="'filters['+filter.id+']'"
                                       v-model="selectedFilterItems[filter.id]">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="JobList Jobs_list">
                <div class="JobsResults JobList_results">
                    <div class="ChoiceBlock ChoiceBlock-inline JobResults_choiceBlock">
                        <div class="ChoiceBlock_header">
                            <h4 class="ChoiceBlock_title">Ви вибрали:</h4>
                        </div>
                        <div class="ChoiceBlock_items">
                            <div class="SelectedItem ChoiceBlock_item" v-for="item in selected">
                                <span class="SelectedItem_name">{{item.filterName}}:</span>
                                <span class="SelectedItem_value">{{item.itemName}}</span>
                                <span class="SelectedItem_close" @click="uncheckItem(item.itemId)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8.844" height="8.844"><path
                                            d="M8.559 1.663L5.808 4.421 8.529 7.15a.982.982 0 0 1-1.387 1.391L4.421 5.812 1.7 8.541A.983.983 0 0 1 .312 7.15l2.721-2.729L.282 1.663A.982.982 0 1 1 1.669.272L4.421 3.03 7.172.272a.982.982 0 1 1 1.387 1.391z"
                                            fill="#d7d7d6" fill-rule="evenodd"></path></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="JobList_items">
                    <div v-for="vacancy in vacancies" class="Job JobList_item"
                         :class="[vacancy.is_urgently ? 'Job-burning':'', vacancy.is_individual_coordination ? 'Job-quote':'']">

                        <a href="javascript:;" class="CopyIcon Job_copyIcon" @click="copyText(vacancy.translated_content)">
                            <img src="/img/copy.png" alt="Copy">
                        </a>
                        <h3 class="Job_title">{{vacancy.translated_title}}</h3>

                        <div style="background: #cf0000; color: #fff;  font-size: 18px; font-weight: bold; padding: 10px 5px; margin-bottom: 10px"
                             v-if="vacancy.status === 2">
                            НАБІР НЕ ЗДІЙСНЮЄТЬСЯ!
                        </div>

                        <div class="Job_text">
                            <div class="Popup_changes" v-if="vacancy.changes">{{vacancy.changes}}</div>
                            <br>
                            <div class="Job_textInner" v-html="vacancy.translated_content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <notifications/>
        <modals-container/>
        <modal name="vacancyPopup" :width="1200" :height="'auto'" :scrollable="true">

            <div class="container">
                <div class="Popup_header">
                    <h2 class="Popup_title">{{vacancy.translated_title}}</h2>

                    <div class="Popup_closedStatus" v-if="vacancy.status === 2">
                        Набір закритий.
                    </div>
                </div>

                <div class="Popup_body">
                    <div class="WhiteBlock VacancyInfo Popup_vacancyInfo">
                        <div class="VacancyInfo_header">
                            <div class="Popup_changes" v-if="vacancy.changes">{{vacancy.changes}}</div>
                        </div>
                        <div class="VacancyInfo_text" v-html="vacancy.translated_content"></div>
                    </div>
                </div>

                <div class="Popup_footer">
                    <button type="button" @click="$modal.hide('vacancyPopup')" class="btn btn-success">Закрити вікно
                    </button>
                </div>
            </div>

        </modal>
    </div>
</template>

<script>


    export default {
        data() {
            return {
                vacancies: {},
                vacancy: {},
                filters: {},
                config: {},
                selected: {},
                selectedLang: 'uk',
                selectedOrder: 'priority',
                selectedFilterItems: [],
                selectedAgeFrom: '',
                selectedAgeTo: '',
                languages: [
                    {
                        label: 'Українська',
                        code: 'uk'
                    },
                    {
                        label: 'Русский',
                        code: 'ru'
                    },
                ],
                orders: [
                    {
                        label: 'Пріоритет',
                        code: 'priority'
                    },
                    {
                        label: 'По датi',
                        code: 'date_desc'
                    },
                ],
            }
        },
        methods: {

            clearFilter() {
                window.location = window.location.href.split("?")[0];
            },

            applyFilter() {
                setTimeout(function () {
                    let form = document.getElementById('FormFilter');
                    let formData = new FormData(form);
                    const params = new URLSearchParams(formData).toString();

                    this.getVacancies(params);

                    for (let [key, value] of formData) {
                        console.log(`${key}: ${value}`)
                    }

                }.bind(this), 500);
            },

            getVacancies(params = null) {
                axios.get('/api/v1/vacancies?' + params, {}).then((response) => {
                    this.vacancies = response.data.vacancies;
                    this.selected = response.data.selected_filters;
                });
            },

            loadFilters() {
                axios.get('/api/v1/filters').then((response) => {
                    this.filters = response.data.filters;

                    if (this.filters) {
                        let selected = [];
                        this.filters.forEach(filter => {

                            filter.items.forEach(item => {
                                if (item.selected_default) {
                                    var list = selected[item.filter_id];

                                    if (list) {
                                        list.push(item.id);
                                    } else {
                                        selected[item.filter_id] = [item.id];
                                    }
                                }
                            });

                        });
                        this.selectedFilterItems = selected;
                    }
                });


            },

            loadFiltersConfig() {
                axios.get('/api/v1/config/filters').then((response) => {
                    this.config = response.data.config;
                });
            },

            showVacancyPopup() {
                let vacancy_id = this.$route.query.vacancy;

                if (vacancy_id) {
                    axios.get('/api/v1/vacancies/' + vacancy_id).then((response) => {
                        this.vacancy = response.data.vacancy;

                        this.$modal.show('vacancyPopup', {})
                    });
                }

            },

            uncheckItem(id) {

                let el = document.getElementById(id);

                if (el.type) {
                    if (el.type === 'checkbox' || el.type === 'radio') {
                        el.checked = false;
                        this.applyFilter();
                    } else if (el.type === 'hidden') {
                        el.value = '';
                        el.dispatchEvent(new Event('input'));
                        this.applyFilter();
                    }
                }
            },

            copyText(text){
                var div = document.createElement("div");
                div.innerHTML = text;
                //return  || div.innerText || "";

                this.$clipboard(div.textContent);

                Vue.notify({
                    type: 'success',
                    title: '',
                    text: 'Скопійовано!'
                });
            },

        },
        mounted: function () {


            if (this.$route.query.vacancy) {
                this.showVacancyPopup()
            }

            this.loadFiltersConfig();
            this.loadFilters();
            this.applyFilter();


            //setTimeout(() => this.applyFilter(), 1000);


            //console.log(this.$route.query.lang)
        },
        watch: {}
    }
</script>
