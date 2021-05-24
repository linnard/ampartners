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

                    <a href="javascript:;" class="CopyIcon Job_copyIcon" @click="copyText(vacancy.translated_content, $event)">
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
                    <!-- <div class="Message Job_message">
                        Винагорода 100 zl за кандидата, за відпрацьований місяць
                    </div> -->
                    <div class="Job_textInner" v-html="vacancy.translated_content"></div>
                    <div class="JobReservation Job_reservation">
                        <a href="javascript:;" class="BtnGreen BtnGreen-fullJob BtnGreen-fullJobDescription JobReservation_btn">
                            <span class="BtnGreen_text BtnGreen_text-large">
                            Безкоштовно</span><span class="BtnGreen_text">забронювати вакансію</span>
                        </a>
                        <div class="JobReservation_detailed JobReservation_detailed-noBorder JobReservation_detailed-textCenter">
                            <button type="button" class="JobReservation_closeBtn"></button>
                            <div class="JobReservation_text JobReservation_text-large">
                                <strong>Для безкоштовного бронювання вакансії</strong> зв'яжіться з нами зручним для вас способом:
                            </div>
                            <a href="javascript:;" class="BtnGreen BtnGreen-callOrder JobReservation_callOrderBtn JobReservation_callOrderBtn-largeIndent">
                                <span class="BtnGreen_text">Замовити дзвінок</span>
                            </a>
                            <div class="Messengers Messengers-jobReservation JobReservation_messengers">
                                <ul class="Messengers_list">
                                    <li class="Messengers_item">
                                        <a href="viber://chat?number=+380974303916" class="MessengerBtn MessengerBtn-small MessengerBtn-vbOutline hidden-xxs">
                                            <span class="MessengerBtn_icon">
                                                <svg class="SvgIco" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.99 30.01"><g data-name="Слой 2"><path class="SvgIco_path" d="M28.34 7.21A10 10 0 0 0 21.58.68 37.62 37.62 0 0 0 7.44.67 10 10 0 0 0 .66 7.18a27.55 27.55 0 0 0 0 11.92A10 10 0 0 0 7 25.57v3.16a1.27 1.27 0 0 0 2.19.88l3.19-3.32c.7 0 1.39.06 2.08.06a38.19 38.19 0 0 0 7.06-.67 10 10 0 0 0 6.75-6.5 27.86 27.86 0 0 0 .07-11.97zm-2.53 11.35a7.58 7.58 0 0 1-4.76 4.57 35.15 35.15 0 0 1-7.51.6.16.16 0 0 0-.13.06l-2.34 2.4-2.48 2.55a.29.29 0 0 1-.5-.2V23.3a.17.17 0 0 0-.15-.17 7.58 7.58 0 0 1-4.76-4.57 25.08 25.08 0 0 1 0-10.77 7.56 7.56 0 0 1 4.76-4.57 34.82 34.82 0 0 1 13.11 0 7.56 7.56 0 0 1 4.76 4.57 25.08 25.08 0 0 1 0 10.77zm-6.2-1.85c-.42-.31-.85-.61-1.29-.88a1.13 1.13 0 0 0-1.37.06c-.42.34-.61 1-1.21 1.06a1.94 1.94 0 0 1-1-.24A6.77 6.77 0 0 1 11 12.5a.86.86 0 0 1 .06-.75 1.3 1.3 0 0 1 .3-.32c.12-.1.25-.21.39-.31a1.22 1.22 0 0 0 .34-1.64 15.76 15.76 0 0 0-1.82-2.55 1 1 0 0 0-1.18-.28 4.39 4.39 0 0 0-1.5 1.11A1.88 1.88 0 0 0 7 9.62c.3.73.59 1.47.94 2.18A18.53 18.53 0 0 0 10.7 16a18.7 18.7 0 0 0 7.1 4.76c.26.11.54.17.83.26a4.12 4.12 0 0 0 .75-.24 4.06 4.06 0 0 0 1.73-1.91 1 1 0 0 0-.28-1.2 13.43 13.43 0 0 0-1.22-.96zm-5.11-11zm0 0h-.2a.42.42 0 0 0-.42.48c0 .32.38.33.63.36.4 0 .8.06 1.19.13a6.28 6.28 0 0 1 5.05 5.24c.06.5.09 1 .13 1.5 0 .25.14.49.42.49a.43.43 0 0 0 .4-.5c-.05-.6-.09-1.21-.19-1.8a7.14 7.14 0 0 0-7.01-5.88zM19 12.6a1 1 0 0 0 0 .34.4.4 0 0 0 .75 0 1.39 1.39 0 0 0 0-.24v-.61-.22a4.64 4.64 0 0 0-2.53-3.61 5.38 5.38 0 0 0-2.3-.6.37.37 0 0 0-.42.37.38.38 0 0 0 .37.43l.6.08a4.61 4.61 0 0 1 1.32.41 4.05 4.05 0 0 1 1.67 1.56A4.42 4.42 0 0 1 19 12.6zm-1-.32a1 1 0 0 0 0-.34 2.41 2.41 0 0 0-2.5-2.41.44.44 0 0 0-.45.34.41.41 0 0 0 .33.47c.21.05.44 0 .65.09a1.77 1.77 0 0 1 .48.23 1.61 1.61 0 0 1 .58.92 5 5 0 0 1 .08.56.43.43 0 0 0 .46.42c-.07 0-.16 0 0 0a.34.34 0 0 0 .37-.28z" fill="#fff" data-name="Слой 1"></path></g></svg>
                                            </span>
                                            <span class="MessengerBtn_textWrap">
                                                <span class="MessengerBtn_text MessengerBtn_text-small">Написати у</span>
                                                <span class="MessengerBtn_text">Viber</span>
                                            </span>
                                        </a>
                                        <a href="viber://add?number=380974303916" class="MessengerBtn MessengerBtn-small MessengerBtn-vbOutline hidden-xxsPlus">
                                            <span class="MessengerBtn_icon">
                                                <svg class="SvgIco" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.99 30.01"><g data-name="Слой 2"><path class="SvgIco_path" d="M28.34 7.21A10 10 0 0 0 21.58.68 37.62 37.62 0 0 0 7.44.67 10 10 0 0 0 .66 7.18a27.55 27.55 0 0 0 0 11.92A10 10 0 0 0 7 25.57v3.16a1.27 1.27 0 0 0 2.19.88l3.19-3.32c.7 0 1.39.06 2.08.06a38.19 38.19 0 0 0 7.06-.67 10 10 0 0 0 6.75-6.5 27.86 27.86 0 0 0 .07-11.97zm-2.53 11.35a7.58 7.58 0 0 1-4.76 4.57 35.15 35.15 0 0 1-7.51.6.16.16 0 0 0-.13.06l-2.34 2.4-2.48 2.55a.29.29 0 0 1-.5-.2V23.3a.17.17 0 0 0-.15-.17 7.58 7.58 0 0 1-4.76-4.57 25.08 25.08 0 0 1 0-10.77 7.56 7.56 0 0 1 4.76-4.57 34.82 34.82 0 0 1 13.11 0 7.56 7.56 0 0 1 4.76 4.57 25.08 25.08 0 0 1 0 10.77zm-6.2-1.85c-.42-.31-.85-.61-1.29-.88a1.13 1.13 0 0 0-1.37.06c-.42.34-.61 1-1.21 1.06a1.94 1.94 0 0 1-1-.24A6.77 6.77 0 0 1 11 12.5a.86.86 0 0 1 .06-.75 1.3 1.3 0 0 1 .3-.32c.12-.1.25-.21.39-.31a1.22 1.22 0 0 0 .34-1.64 15.76 15.76 0 0 0-1.82-2.55 1 1 0 0 0-1.18-.28 4.39 4.39 0 0 0-1.5 1.11A1.88 1.88 0 0 0 7 9.62c.3.73.59 1.47.94 2.18A18.53 18.53 0 0 0 10.7 16a18.7 18.7 0 0 0 7.1 4.76c.26.11.54.17.83.26a4.12 4.12 0 0 0 .75-.24 4.06 4.06 0 0 0 1.73-1.91 1 1 0 0 0-.28-1.2 13.43 13.43 0 0 0-1.22-.96zm-5.11-11zm0 0h-.2a.42.42 0 0 0-.42.48c0 .32.38.33.63.36.4 0 .8.06 1.19.13a6.28 6.28 0 0 1 5.05 5.24c.06.5.09 1 .13 1.5 0 .25.14.49.42.49a.43.43 0 0 0 .4-.5c-.05-.6-.09-1.21-.19-1.8a7.14 7.14 0 0 0-7.01-5.88zM19 12.6a1 1 0 0 0 0 .34.4.4 0 0 0 .75 0 1.39 1.39 0 0 0 0-.24v-.61-.22a4.64 4.64 0 0 0-2.53-3.61 5.38 5.38 0 0 0-2.3-.6.37.37 0 0 0-.42.37.38.38 0 0 0 .37.43l.6.08a4.61 4.61 0 0 1 1.32.41 4.05 4.05 0 0 1 1.67 1.56A4.42 4.42 0 0 1 19 12.6zm-1-.32a1 1 0 0 0 0-.34 2.41 2.41 0 0 0-2.5-2.41.44.44 0 0 0-.45.34.41.41 0 0 0 .33.47c.21.05.44 0 .65.09a1.77 1.77 0 0 1 .48.23 1.61 1.61 0 0 1 .58.92 5 5 0 0 1 .08.56.43.43 0 0 0 .46.42c-.07 0-.16 0 0 0a.34.34 0 0 0 .37-.28z" fill="#fff" data-name="Слой 1"></path></g></svg>
                                            </span>
                                            <span class="MessengerBtn_textWrap">
                                                <span class="MessengerBtn_text MessengerBtn_text-small">Написати у</span>
                                                <span class="MessengerBtn_text">Viber</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="Messengers_item">
                                        <a href="tg://resolve?domain=ampartners" class="MessengerBtn MessengerBtn-telegram MessengerBtn-small MessengerBtn-tgOutline">
                                            <span class="MessengerBtn_icon">
                                                <svg class="SvgIco" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.99 25.03"><g data-name="Слой 2"><path class="SvgIco_path" d="M28.07.1L.64 10.69a1 1 0 0 0 .08 1.87l7 2 2.6 8.18a1.2 1.2 0 0 0 2 .47l3.6-3.64L23 24.75a1.48 1.48 0 0 0 2.32-.88L30 1.69A1.4 1.4 0 0 0 28.07.1zM24.63 5L11.89 16.18a.68.68 0 0 0-.23.43l-.49 4.32a.13.13 0 0 1-.26 0l-2-6.44a.68.68 0 0 1 .3-.78l15-9.25a.33.33 0 0 1 .42.54z" fill="#fff" data-name="Слой 1"></path></g></svg>
                                            </span>
                                            <span class="MessengerBtn_textWrap">
                                                <span class="MessengerBtn_text MessengerBtn_text-small">Написати у</span>
                                                <span class="MessengerBtn_text">Telegram</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="Phones Phones-inline Job_phones">
                                <ul class="Phones_list">
                                    <li class="Phones_item">
                                        <a href="tel:+380972313469" class="Phone Phone-ua">+380972313469</a>
                                    </li>
                                    <li class="Phones_item">
                                        <a href="tel:+48732082227" class="Phone Phone-pl">+48732082227</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
            copyInputText(targetElem) {
                targetElem.select();
                targetElem.setSelectionRange(0, 99999);

                document.execCommand("copy");
            },

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

            copyText(text, event) {
                // var div = document.createElement("div");
                // div.innerHTML = text;
                //return  || div.innerText || "";

                // this.$clipboard(div.textContent);

                // Vue.notify({
                //     type: 'success',
                //     title: '',
                //     text: 'Скопійовано!'
                // });

                let copyIcon = event.target.closest('.CopyIcon');

                if (!copyIcon) return;

                let job = copyIcon.closest('.Job');

                if (job) {
                    let copyTextarea = document.createElement('textarea');
                    copyTextarea.value = job.querySelector('.Job_textInner').textContent;
                    copyIcon.append(copyTextarea);
                    this.copyInputText(copyTextarea);
                    copyTextarea.remove();
                }

                let tooltip = copyIcon.querySelector('.Tooltip');

                if (!tooltip) {
                    tooltip = document.createElement('div');
                    tooltip.className = 'Tooltip Tooltip-vacancy';
                    tooltip.textContent = 'Скопійовано!';
                    copyIcon.append(tooltip);
                }

                setTimeout(() => {
                    tooltip.remove();
                }, 2000);
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
