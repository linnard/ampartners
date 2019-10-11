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
            <form class="ReceiptForm Receipt_form" data-id="7">
                <div class="ReceiptForm_column ReceiptForm_column-fio">
                    <div class="ReceiptForm_itemGroup">
                        <div class="ReceiptForm_item">
                            <label class="FormLabel ReceiptForm_label">Прізвище (англ.)</label>
                            <input class="FormText ReceiptForm_text" :class="errLastname" type="text" v-model="client.lastname"
                                   @change="inputChanged" name="lastname">
                        </div>
                        <div class="ReceiptForm_item">
                            <label class="FormLabel ReceiptForm_label">Ім’я (англ.)</label>
                            <input class="FormText ReceiptForm_text" :class="errFirstname" type="text" v-model="client.firstname"
                                   @change="inputChanged" name="firstname">
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
                                <select class="Select Select-receiptForm" v-model="client.properties[0].type_id"
                                        @change="updateProps">
                                    <option value="0">Не вибрано</option>
                                    <option v-for="type in property_types" :value="type.id">
                                        {{type.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Деталі зв’язку</label>
                                <input class="FormText ReceiptForm_text" type="text" v-model="client.properties[0].value"
                                       @change="updateProps">
                            </div>
                        </div>
                        <div class="ReceiptForm_itemGroup ReceiptForm_itemGroup-communicationTypes">
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Додатковий тип зв’язку</label>
                                <select class="Select Select-receiptForm" v-model="client.properties[1].type_id"
                                        @change="updateProps">
                                    <option value="0">Не вибрано</option>
                                    <option v-for="type in property_types" :value="type.id">
                                        {{type.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="ReceiptForm_item">
                                <label class="FormLabel ReceiptForm_label">Деталі зв’язку</label>
                                <input class="FormText ReceiptForm_text" type="text" v-model="client.properties[1].value"
                                       @change="updateProps">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ReceiptForm_column ReceiptForm_column-vacancyInfo">
                    <div class="ReceiptForm_itemGroup ReceiptForm_itemGroup-paymentType" style="display: block;">
                        <div class="ReceiptForm_item" style="margin-right: 0">
                            <label class="FormLabel ReceiptForm_label">Вакансія</label>
                            <select name="vacancy_id" class="Select Select-receiptForm" @change="inputChanged">
                                <option value="my" selected>Свій варіант</option>
                                <option v-for="vacancy in vacancies" :value="vacancy.id"
                                        :selected="(client.vacancy_id === vacancy.id)">{{vacancy.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="ReceiptForm_item">
                        <label class="FormLabel ReceiptForm_label">Замітка</label>
                        <textarea class="FormTextarea" name="note" @change="inputChanged">{{client.note}}</textarea>
                    </div>

                </div>
                <div class="ReceiptForm_column ReceiptForm_column-buttons">
                    <button class="BtnOutline BtnOutline-transfer ReceiptForm_confirmBtn">Підтвердити бронь</button>

                </div>
            </form>
        </div>

    </div>
</template>

<script>

    import Documents from '../modals/Documents'

    export default {
        props: ['client', 'property_types', 'vacancies'],
        components: {Documents},
        data() {
            return {
                errFirstname: '',
                errLastname: '',
            }
        },
        methods: {
            updateProps(){
                this.client.properties.forEach(function(property) {
                    axios.put('/api/v1/properties/' + property.id, {
                        type_id: property.type_id,
                        value: property.value,
                    }).then((response) => {
                        //this.clients.unshift(response.data.client);
                    });
                });
            },

            showDocuments(){
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
                    //this.clients.unshift(response.data.client);
                })

            }
        },
        mounted() {

        },
        watch: {
            'client.firstname': function (val) {
                var valid = /^[a-zA-Z]+$/.test(val);
                this.errFirstname = '';

                if (!valid){
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Ім’я повино містити лише латинські літери!'
                    });

                    this.errFirstname = 'invalid'
                }
            },
            'client.lastname': function (val) {
                var valid = /^[a-zA-Z]+$/.test(val);
                this.errLastname = '';

                if (!valid){
                    Vue.notify({
                        type: 'error',
                        title: 'Помилка',
                        text: 'Прізвище повино містити лише латинські літери!'
                    });

                    this.errLastname = 'invalid'
                }
            }

        }
    }
</script>

<style>
    input.invalid{
        border-color: #e3342f;
    }
</style>
