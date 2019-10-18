<template>
    <div class="wrap-parent-client">

        <div class="colors_group"></div>
        <div class="group_controll">
            <div class="Receipt_basicInfoItem Receipt_basicInfoItem-id" style="border-bottom: 0">ID {{client.id}}</div>
        </div>
        <div class="Receipt Receipts_item" data-id="">
            <div class="Receipt_basicInfo">
                <div class="Receipt_basicInfoGroup">
                    <div class="Receipt_basicInfoItem Receipt_basicInfoItem-recipient Receipt_basicInfoItem-noBorder">
                        {{client.user.firstname}} {{client.user.lastname}}
                    </div>
                    <div class="Receipt_basicInfoItem Receipt_basicInfoItem-created">{{client.updated_at}}</div>
                </div>
                <div class="Receipt_basicInfoItem" style="padding-left: 30px;">{{client.company.name}}</div>
            </div>
            <div class="ReceiptForm Receipt_form">
                <div class="ReceiptForm_column ReceiptForm_column-fio">
                    <div class="ReceiptForm_itemGroup">
                        <div class="ReceiptForm_item">
                            <label class="FormLabel ReceiptForm_label">Прізвище (англ.)</label>
                            <input class="FormText ReceiptForm_text" :class="{'invalid':err.lastname}" type="text"
                                   v-model="client.lastname"
                                   @change="inputChanged" :disabled="(!editable)" name="lastname">
                        </div>
                        <div class="ReceiptForm_item">
                            <label class="FormLabel ReceiptForm_label">Ім’я (англ.)</label>
                            <input class="FormText ReceiptForm_text" :class="{'invalid':err.firstname}" type="text"
                                   v-model="client.firstname"
                                   @change="inputChanged" :disabled="(!editable)" name="firstname">
                        </div>
                    </div>

                    <div class="ReceiptForm_docsNumber">
                        <a class="ActionLink ModalTrigger-2" href="javascript:void(0);" @click="showDocuments">
                            <svg class="SvgIco" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 18.64">
                                <g data-name="Слой 2">
                                    <path class="SvgIco_path"
                                          d="M3.37 4.07V.58a.57.57 0 0 1 1.13 0v3.49A1.77 1.77 0 0 0 6 6a1.77 1.77 0 0 0 1.47-1.93V1.13h-.92v2.93a.57.57 0 0 1-1.13 0V.56A.56.56 0 0 1 6 0h2a.54.54 0 0 1 .4.17.52.52 0 0 1 .2.39v3.51A2.86 2.86 0 0 1 6 7.13a2.86 2.86 0 0 1-2.63-3.06zm.51 6.64h4.21a.56.56 0 1 0 0-1.12H3.88a.56.56 0 1 0 0 1.12zm1 1.09a.56.56 0 0 0-.56.56.57.57 0 0 0 .56.57h2.17a.57.57 0 0 0 .56-.57.56.56 0 0 0-.56-.56zM12 15.05V2.4a.57.57 0 0 0-.56-.57H9.9a.57.57 0 0 0-.57.57.56.56 0 0 0 .57.6h.94v11.48H1.13V3h1a.56.56 0 0 0 .56-.56.57.57 0 0 0-.56-.57H.56A.57.57 0 0 0 0 2.4v12.65a.56.56 0 0 0 .56.56h10.85a.56.56 0 0 0 .59-.56zM14.44 4h-1.07a.57.57 0 0 0 0 1.13h.5v12.38H3.25v-.69a.57.57 0 0 0-.57-.56.56.56 0 0 0-.56.56v1.26a.56.56 0 0 0 .56.56h11.76a.56.56 0 0 0 .56-.56V4.52a.56.56 0 0 0-.56-.52z"
                                          fill="#81be1f" data-name="Capa 1"></path>
                                </g>
                            </svg>

                            Документи
                        </a>
                        <span class="doc_count">{{client.media.length}}</span>
                    </div>
                </div>
                <div class="ReceiptForm_column ReceiptForm_column-contacts">
                    <div class="ReceiptForm_itemGroups">
                        <div class="ReceiptForm_itemGroup ReceiptForm_itemGroup-communicationTypes">
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Основний тип зв’язку</label>
                                <select class="Select Select-receiptForm" :disabled="(!editable)"
                                        v-model="client.properties[0].type_id"
                                        @change="updateProps" :class="{'invalid':err.propType}"
                                        @focus="err.propType = false">
                                    <option value="0" disabled selected>Не вибрано</option>
                                    <option v-for="type in property_types" :value="type.id">
                                        {{type.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Деталі зв’язку</label>
                                <input class="FormText ReceiptForm_text" type="text"
                                       v-model="client.properties[0].value"
                                       @change="updateProps" :disabled="(!editable)" @focus="err.propVal = false"
                                       :class="{'invalid':err.propVal}">
                            </div>
                        </div>
                        <div class="ReceiptForm_itemGroup ReceiptForm_itemGroup-communicationTypes">
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Додатковий тип зв’язку</label>
                                <select class="Select Select-receiptForm" :disabled="(!editable)"
                                        v-model="client.properties[1].type_id"
                                        @change="updateProps">
                                    <option value="0" disabled selected>Не вибрано</option>
                                    <option v-for="type in property_types" :value="type.id">
                                        {{type.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Деталі зв’язку</label>
                                <input class="FormText ReceiptForm_text" :disabled="(!editable)" type="text"
                                       v-model="client.properties[1].value"
                                       @change="updateProps">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ReceiptForm_column ReceiptForm_column-vacancyInfo">
                    <div class="ReceiptForm_itemGroup ReceiptForm_itemGroup-paymentType" style="display: block;">
                        <div class="ReceiptForm_item" style="margin-right: 0">
                            <label class="FormLabel ReceiptForm_label">Вакансія</label>
                            <select name="vacancy_id" class="Select Select-receiptForm" :disabled="(!editable)"
                                    :class="{'invalid':err.vacancy}" @focus="err.vacancy = false"
                                    v-model="client.vacancy_id" @change="inputChanged">
                                <option value="0" disabled selected>Не вибрано</option>
                                <option v-for="vacancy in vacancies" :value="vacancy.id">{{vacancy.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="ReceiptForm_item">
                        <label class="FormLabel ReceiptForm_label">Замітка</label>
                        <textarea class="FormTextarea" :disabled="(!editable)" name="note" @change="inputChanged">{{client.note}}</textarea>
                    </div>

                </div>


                <div class="ReceiptForm_column ReceiptForm_column-additionalForm"
                     v-if="(['creating', 'booking_confirmation_rejected'].includes(client.status))">
                    <button @click="book" class="BtnOutline BtnOutline-transfer ReceiptForm_transfer">Забронювати
                    </button>
                </div>

                <div class="ReceiptForm_column ReceiptForm_column-statusBlock"
                     v-else-if="(['booking_confirmation_expected'].includes(client.status))">
                    <div class="StatusBlock">
                        <svg class="SvgIco StatusBlock_icon" viewBox="0 0 64 64" xml:space="preserve"
                             xmlns="http://www.w3.org/2000/svg"><g id="Icon-Clock" transform="translate(378 428)"><path class="SvgIco_path" d="M-346.1-373.1c-12.6 0-22.9-10.3-22.9-22.9 0-12.6 10.3-22.9 22.9-22.9 12.6 0 22.9 10.3 22.9 22.9.1 12.6-10.2 22.9-22.9 22.9zm0-43.4c-11.3 0-20.4 9.2-20.4 20.4s9.2 20.4 20.4 20.4 20.4-9.2 20.4-20.4-9.1-20.4-20.4-20.4z" id="Fill-131"></path><path
                                class="SvgIco_path" id="Fill-132"
                                d="M-338.9-384.3l-8.5-8.5v-15.5h2.7v14.4l7.7 7.7-1.9 1.9"></path></g></svg>
                        <div class="StatusBlock_text">Контакт очікує <br>підтвердження бронювання</div>
                    </div>
                </div>

                <div class="ReceiptForm_column ReceiptForm_column-statusBlock"
                     v-else-if="(['ticket_expected', 'ticket_confirmation_rejected'].includes(client.status) && !client.ticket_uploaded)">
                    <div class="StatusBlock StatusBlock-uploadTicketPhoto">
                        <svg class="SvgIco StatusBlock_icon" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <g class="SvgIco_stroke" clip-rule="evenodd" fill-rule="evenodd"
                               image-rendering="optimizeQuality" shape-rendering="geometricPrecision"
                               text-rendering="geometricPrecision" stroke="#000">
                                <path class="fil0 str0" fill="none" stroke-width="2.000064" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M1.626 13.307L33.22 4.433l11.006 39.185-31.594 8.873z"></path>
                                <path class="fil0 str0" fill="none" stroke-width="2.000064" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M41.543 15.696l20.831 3.936-7.776 39.935-30.143-5.856"></path>
                                <path class="fil0 str0" fill="none" stroke-width="2.00016" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9.768 42.383l6.816-9.023 7.007 2.784 5.76-11.04L40.68 30.96"></path>
                                <path class="fil0 str1"
                                      d="M19.175 22.896c1.056-.288 2.112.288 2.4 1.344.288 1.056-.288 2.112-1.344 2.4-1.056.288-2.112-.288-2.4-1.344-.288-1.056.288-2.112 1.344-2.4zM11.208 48.24l32.063-9.024"
                                      fill="none" stroke-width="2.00016"></path>
                                <path class="fil0 str0" fill="none" stroke-width="2.00016" stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M36.839 50.255l14.207 2.976M42.79 22.32l14.208 2.976"></path>
                            </g>
                        </svg>
                        <h4 class="StatusBlock_title">{{client.latest_log.comment}}</h4>
                        <div class="StatusBlock_text">Для отримання маршрутного листа та даних для зв'язку з
                            координатором - завантажте фото квитка на автобус або поїзд
                        </div>
                    </div>
                </div>


                <div class="ReceiptForm_column ReceiptForm_column-statusBlock  ReceiptForm_column-transparent"
                     v-else-if="(['ticket_expected', 'ticket_confirmation_rejected'].includes(client.status) && client.ticket_uploaded)">
                    <div class="StatusBlock StatusBlock-ticketLoaded">
                        <button @click="ticketUploaded" class="BtnOutline BtnOutline-transfer StatusBlock_btn">Квиток
                            завантажено
                        </button>
                        <div class="StatusBlock_text">{{client.latest_log.comment}}</div>
                    </div>
                </div>

                <div class="ReceiptForm_column ReceiptForm_column-statusBlock"
                     v-else-if="(['ticket_confirmation_expected'].includes(client.status))">
                    <div class="StatusBlock">
                        <svg class="SvgIco StatusBlock_icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path class="SvgIco_path"
                                  d="M16 31C7.729 31 1 24.271 1 16c0-3.646 1.323-7.16 3.727-9.895a.502.502 0 01.706-.045.502.502 0 01.046.706A13.972 13.972 0 002 16c0 7.72 6.28 14 14 14s14-6.28 14-14S23.72 2 16 2c-2.504 0-4.96.668-7.103 1.933a.5.5 0 11-.507-.862A14.979 14.979 0 0116 1c8.271 0 15 6.729 15 15s-6.729 15-15 15z"
                                  fill="#263238"></path>
                            <path class="SvgIco_path"
                                  d="M16 28.5C9.107 28.5 3.5 22.893 3.5 16S9.107 3.5 16 3.5 28.5 9.107 28.5 16 22.893 28.5 16 28.5zm0-24C9.659 4.5 4.5 9.659 4.5 16S9.659 27.5 16 27.5 27.5 22.341 27.5 16 22.341 4.5 16 4.5z"
                                  fill="#263238"></path>
                            <path class="SvgIco_path"
                                  d="M20.75 8.27c-.13 0-.26-.05-.351-.14-.1-.1-.149-.23-.149-.36s.05-.26.149-.35c.19-.19.521-.19.7 0 .101.09.15.22.15.35s-.049.26-.149.35a.47.47 0 01-.35.15zM11.25 24.729c-.13 0-.26-.06-.351-.149a.503.503 0 01-.149-.351c0-.13.05-.26.14-.359.19-.181.53-.181.71 0 .101.1.15.229.15.359 0 .12-.05.25-.141.351a.548.548 0 01-.359.149zM24.229 11.75a.496.496 0 01-.5-.5c0-.13.051-.26.141-.351a.506.506 0 01.859.351c0 .13-.05.26-.149.35-.09.1-.221.15-.351.15zM7.77 21.25c-.13 0-.25-.05-.35-.141a.535.535 0 01-.15-.359c0-.13.05-.25.141-.351a.518.518 0 01.72 0c.09.091.14.221.14.351s-.05.26-.14.35a.495.495 0 01-.361.15zM25.5 16.5c-.13 0-.26-.05-.351-.15-.099-.09-.149-.22-.149-.35s.05-.26.149-.351a.513.513 0 01.7-.01.508.508 0 01.01.711.504.504 0 01-.359.15zM6.5 16.5c-.13 0-.26-.05-.351-.15C6.05 16.26 6 16.13 6 16s.05-.26.149-.351a.513.513 0 01.7-.01.508.508 0 01.01.711.504.504 0 01-.359.15z"
                                  fill="#263238"></path>
                            <g>
                                <path class="SvgIco_path"
                                      d="M24.229 21.25c-.13 0-.26-.05-.359-.141-.09-.1-.141-.229-.141-.359s.051-.26.141-.351a.506.506 0 01.859.351c0 .13-.05.26-.149.35-.09.1-.221.15-.351.15zM7.77 11.75c-.13 0-.25-.05-.35-.141a.535.535 0 01-.15-.359c0-.13.05-.25.141-.351a.518.518 0 01.72 0c.09.091.14.221.14.351s-.05.26-.14.35a.513.513 0 01-.361.15z"
                                      fill="#263238"></path>
                            </g>
                            <g>
                                <path class="SvgIco_path"
                                      d="M20.75 24.729c-.13 0-.26-.05-.351-.14-.1-.11-.149-.23-.149-.36s.05-.26.14-.359c.2-.19.521-.181.71 0 .101.1.15.229.15.359 0 .12-.05.25-.141.351a.502.502 0 01-.359.149zM11.25 8.27c-.13 0-.26-.05-.351-.149-.099-.091-.149-.222-.149-.351s.05-.26.149-.35a.51.51 0 01.7-.01c.101.1.15.229.15.359s-.049.261-.149.351c-.1.1-.22.15-.35.15z"
                                      fill="#263238"></path>
                            </g>
                            <g>
                                <path class="SvgIco_path"
                                      d="M16 26c-.13 0-.25-.05-.351-.141-.099-.109-.149-.229-.149-.359s.05-.26.14-.351a.506.506 0 01.71 0c.1.091.15.221.15.351s-.05.26-.15.35A.47.47 0 0116 26zM16 7c-.13 0-.25-.05-.351-.141a.507.507 0 01-.009-.71.506.506 0 01.71 0A.496.496 0 0116 7z"
                                      fill="#263238"></path>
                            </g>
                            <g fill="#263238">
                                <path class="SvgIco_path"
                                      d="M22.364 9.636a.5.5 0 00-.707 0l-5.413 5.413a.975.975 0 01.707.707l5.413-5.413a.499.499 0 000-.707zM15.756 15.049l-6.12-6.12a.5.5 0 00-.707.707l6.12 6.12a.975.975 0 01.707-.707z"></path>
                                <path class="SvgIco_path"
                                      d="M16 17.5c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5zm0-2c-.275 0-.5.225-.5.5s.225.5.5.5.5-.225.5-.5-.225-.5-.5-.5z"></path>
                            </g>
                            <g>
                                <path class="SvgIco_path"
                                      d="M7.5 4.5c0 .275-.225.5-.5.5a.501.501 0 01-.5-.5c0-.275.225-.5.5-.5s.5.225.5.5z"
                                      fill="#263238"></path>
                            </g>
                        </svg>
                        <div class="StatusBlock_text">Квиток завантажено. <br>Очікується підтвердження від адміністрації
                        </div>
                    </div>
                </div>

                <div class="ReceiptForm_column ReceiptForm_column-statusBlock ReceiptForm_column-statusBlockCompleted"
                     v-else-if="(['completed'].includes(client.status))">
                    <div class="StatusBlock StatusBlock-completed">
                        <div class="StatusBlock_titleIcon">
                            <svg class="SvgIco StatusBlock_icon StatusBlock_icon-titleIcon" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path class="SvgIco_path"
                                      d="M12 0C5.373 0 0 5.373 0 12c0 6.628 5.373 12 12 12s12-5.372 12-12c0-6.627-5.373-12-12-12zm7.754 9.561l-8.607 8.607a.448.448 0 01-.637 0l-1.272-1.285c-.175-.176-.462-.464-.636-.642l-2.96-3.112a.47.47 0 01-.133-.327c0-.115.046-.227.133-.314l1.297-1.169a.447.447 0 01.636 0l2.936 2.995a.447.447 0 00.637 0l6.699-6.681a.447.447 0 01.636 0l1.272 1.285a.458.458 0 01-.001.643z"></path>
                            </svg>
                            <h4 class="StatusBlock_title StatusBlock_title-titleIcon">Бронювання завершено!</h4>
                        </div>
                        <div class="StatusBlock_text">{{client.latest_log.comment}}</div>
                    </div>
                </div>

            </div>
        </div>

        <notifications/>
    </div>
</template>

<script>

    import Documents from '../modals/Documents'
    import BookingConfirmation from '../modals/BookingConfirmation'
    import TicketConfirmation from '../modals/TicketConfirmation'

    export default {
        props: {
            client: {},
            property_types: {},
            vacancies: {}
        },
        components: {Documents, BookingConfirmation, TicketConfirmation},
        data() {
            return {
                err: {
                    firstname: false,
                    lastname: false,
                    propType: false,
                    propVal: false,
                    vacancy: false,
                },
                editable: ['creating', 'booking_confirmation_rejected'].includes(this.client.status)
            }
        },
        methods: {
            updateProps() {

                this.client.properties.forEach(function (property) {
                    axios.put('/api/v1/properties/' + property.id, {
                        type_id: property.type_id,
                        value: property.value,
                    }).then((response) => {

                    });
                });
            },

            showDocuments() {
                this.$modal.show(Documents, {
                    client: this.client,
                }, {
                    scrollable: true,
                    height: 'auto',
                    width: 1200
                })
            },

            inputChanged(event) {

                if (event.target.classList.contains('invalid')) {
                    return;
                }

                axios.patch('/api/v1/clients/' + this.client.id, {
                    [event.target.name]: event.target.value
                }).then((response) => {

                    if (['firstname', 'lastname'].includes(event.target.name)){
                        this.client.media = response.data.client.media
                    }

                })

            },

            book() {
                var errors = [];
                if (!this.client.media.length) {
                    errors.push('Необхідно завантажити хоча б один документ.');
                }

                if (!this.client.firstname || !this.validFirstname(this.client.firstname)) {
                    this.err.firstname = true;
                    errors.push('Поле Ім’я обов’язково для заповнення та повино містити лише латинські літери.');
                }

                if (!this.client.lastname || !this.validLastname(this.client.lastname)) {
                    this.err.lastname = true;
                    errors.push('Поле Прізвище обов’язково для заповнення та повино містити лише латинські літери.');
                }

                if (this.client.properties[0].type_id == 0) {
                    this.err.propType = true;
                    errors.push('Виберіть основний тип зв’язку.');
                }

                if (!this.client.properties[0].value) {
                    this.err.propVal = true;
                    errors.push('Вкажіть деталі зв’язку.');
                }

                if (!this.client.vacancy_id) {
                    this.err.vacancy = true;
                    errors.push('Виберіть вакансію.');
                }

                if (errors.length) {
                    errors.forEach(function (message) {
                        Vue.notify({
                            type: 'error',
                            title: 'Помилка',
                            text: message
                        });
                    });

                    return;
                }

                this.$modal.show(BookingConfirmation, {
                    client: this.client,
                }, {
                    height: 350,
                    width: 600
                });

            },

            ticketUploaded() {

                this.$modal.show(TicketConfirmation, {
                    client: this.client,
                }, {
                    height: 350,
                    width: 650
                });

            },

            validFirstname(val) {
                var valid = /^[a-zA-Z]+$/.test(val);
                this.err.firstname = false;
                return valid;
            },

            validLastname(val) {
                var valid = /^[a-zA-Z]+$/.test(val);
                this.err.lastname = false;
                return valid;
            }
        },
        watch: {
            'client.status': function (val) {
                this.editable = ['creating', 'booking_confirmation_rejected'].includes(val);
            },
            'client.firstname': function (val) {
                if (!this.validFirstname(val)) {
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Ім’я повино містити лише латинські літери!'
                    });

                    this.err.firstname = true;
                }
            },
            'client.lastname': function (val) {
                if (!this.validLastname(val)) {
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Прізвище повино містити лише латинські літери!'
                    });

                    this.err.lastname = true
                }
            }

        }
    }
</script>

<style>
    select.invalid,
    input.invalid {
        border-color: #e3342f;
    }
</style>
