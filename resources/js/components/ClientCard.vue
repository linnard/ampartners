<template>
    <div class="wrap-parent-client" v-if="(visible_statuses.includes(client.status))">

        <div class="colors_group"></div>
        <div class="group_controll">
            <div class="Receipt_basicInfoItem Receipt_basicInfoItem-id" style="border-bottom: 0">ID {{client.id}}</div>
        </div>
        <div class="Receipt Receipts_item" @click="removeHighlight">
            <div class="Receipt_basicInfo">
                <div class="Receipt_basicInfoGroup">
                    <div class="Receipt_basicInfoItem Receipt_basicInfoItem-recipient Receipt_basicInfoItem-noBorder">
                        {{client.user.firstname}} {{client.user.lastname}}
                    </div>
                    <div class="Receipt_basicInfoItem Receipt_basicInfoItem-created">{{client.updated_at}}</div>
                </div>
                <div class="Receipt_basicInfoItem" style="padding-left: 30px;">{{client.company.name}}</div>
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="profile-user-info">
                        <div class="profile-info-row">
                            <div class="profile-info-name">
                                <h3 class="h3 blue ml-5">
                                    <span>{{client.firstname}} {{client.lastname}}</span>
                                </h3>
                            </div>
                            <div class="profile-info-value">
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
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Основний тип зв’язку</div>
                            <div class="profile-info-value">
                                <span>{{client.properties[0].value}}</span>
                                <span v-for="type in property_types">
                                        <span v-if="type.id == client.properties[0].type_id">({{type.name}})</span>
                                    </span>

                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Додатковий тип зв’язку</div>
                            <div class="profile-info-value">
                                <span>{{client.properties[1].value}}</span>
                                <span v-for="type in property_types">
                                        <span v-if="type.id == client.properties[1].type_id">({{type.name}})</span>
                                    </span>

                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Вакансія</div>
                            <div class="profile-info-value">
                                <select name="vacancy_id" v-model="client.vacancy_id" @change="inputChanged">
                                    <option value="0">Не вибрано</option>
                                    <option v-for="vacancy in vacancies" :value="vacancy.id">{{vacancy.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name">Замітка</div>
                            <div class="profile-info-value">
                                {{client.note}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>



            <div class="ReceiptForm_column ReceiptForm_column-statusBlock" :class="{'ReceiptForm_column-statusBlockCompleted':client.status == 'completed'}" style="margin-top:0">
                <div class="StatusBlock">
                    <div class="StatusBlock_title">
                        <h4 class="StatusBlock_title StatusBlock_title">{{client.status_description}}</h4>
                    </div>

                    <div v-if="(['booking_confirmation_expected'].includes(client.status))">
                        <button @click="confirmBook" class="BtnOutline BtnOutline-transfer ReceiptForm_confirmBtn">Підтвердити бронь</button>
                        <button @click="rejectBook" class="BtnOutline BtnOutline-transfer BtnOutline-red">Повернути клієнта</button>
                    </div>

                    <div v-else-if="(['ticket_confirmation_expected'].includes(client.status) && client.complete_at === null)">
                        <button @click="confirmTicket" class="BtnOutline BtnOutline-transfer ReceiptForm_confirmBtn">Підтвердити квиток</button>
                        <button @click="rejectTicket" class="BtnOutline BtnOutline-transfer BtnOutline-red">Повернути клієнта</button>
                    </div>
                </div>
            </div>

        </div>

        <notifications/>
    </div>
</template>

<script>

    import Documents from '../modals/Documents'
    import BookingConfirmationAdmin from '../modals/BookingConfirmationAdmin'
    import TicketConfirmationAdmin from '../modals/TicketConfirmationAdmin'
    import BookingReject from '../modals/BookingReject'
    import TicketReject from '../modals/TicketReject'

    export default {
        props: {
            client: {},
            property_types: {},
            vacancies: {},
            visible_statuses: {}
        },
        components: {
            Documents,
            BookingConfirmationAdmin,
            TicketConfirmationAdmin,
            BookingReject,
            TicketReject
        },
        data() {
            return {  }
        },
        methods: {

            removeHighlight(){
                if (this.client.is_updated){
                    axios.patch('/api/v1/clients/' + this.client.id, {
                        is_updated: 0
                    }).then((response) => {
                        this.client.is_updated = 0;
                        this.$emit('update_counts');
                    })
                }
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
                axios.patch('/api/v1/clients/' + this.client.id, {
                    [event.target.name]: event.target.value
                }).then((response) => {})
            },

            confirmBook() {
                this.$modal.show(BookingConfirmationAdmin, {
                    client: this.client,
                }, {
                    height: 500,
                    width: 600
                });
            },

            rejectBook() {
                this.$modal.show(BookingReject, {
                    client: this.client,
                }, {
                    height: 500,
                    width: 600
                });
            },

            confirmTicket() {
                this.$modal.show(TicketConfirmationAdmin, {
                    client: this.client,
                }, {
                    height: 500,
                    width: 600
                });
            },

            rejectTicket() {
                this.$modal.show(TicketReject, {
                    client: this.client,
                }, {
                    height: 500,
                    width: 600
                });
            },

        },
    }
</script>

<style>
    .blue {
        color: #478FCA !important
    }

    .profile-user-info {
        display: table;
        width: 98%;
        width: calc(100% - 24px);
        margin: 0 auto;
    }

    .profile-info-row {
        display: table-row;
    }

    .profile-info-row:first-child .profile-info-name, .profile-info-row:first-child .profile-info-value {
        border-top: none;
    }

    .profile-info-name {
        text-align: right;
        padding: 6px 10px 6px 4px;
        font-weight: 400;
        color: #667E99;
        background-color: transparent;
        width: 260px;
        vertical-align: middle;
    }

    .profile-info-name, .profile-info-value {
        display: table-cell;
        border-top: 1px dotted #D5E4F1;
    }

    .profile-info-row:first-child .profile-info-name, .profile-info-row:first-child .profile-info-value {
        border-top: none;
    }

    .profile-info-value {
        padding: 6px 4px 6px 6px;
    }
</style>
