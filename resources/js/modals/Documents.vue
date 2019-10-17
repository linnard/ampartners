<template>
    <div class="container-fluid p-5">
        <div class="text-center">
            <a class="btn btn-success" target="_blank" :href="'/api/v1/clients/'+client.id+'/files'" v-if="client.media.length">Скачати все <i class="fas fa-download"></i>
            </a>
        </div>

        <div class="files-container">

            <div class="file-col" v-for="(file, index) in client.media">

                <a :href="file.url" target="_blank" class="d-block mb-4 h-100">
                    <img :src="file.url" v-if="['image/jpeg', 'image/png'].includes(file.mime_type)">

                    <img src="/img/file-icon.png" v-if="!['image/jpeg', 'image/png'].includes(file.mime_type)">
                </a>

                <button style="position:absolute; bottom:5px; left: 5px" class="btn btn-danger" @click="remove(file.id, index)"  v-if="(['booking_confirmation_rejected','creating'].includes(client.status))"><i
                        class="fas fa-trash"></i></button>
                <a style="position:absolute; bottom:5px; right: 5px" class="btn btn-success" target="_blank" :href="'/api/v1/files/'+file.id"><i
                        class="fas fa-download"></i></a>

            </div>
        </div>

        <file-upload :key="client.id"
                     :accept='uploader.accept'
                     :url='uploader.url'
                     :headers="uploader.headers"
                     :btn-label="uploader.label"
                     :btn-uploading-label="uploader.uploadingLabel"
                     :additional-data="uploader.data"
                     @change="onFileChange"></file-upload>
    </div>
</template>

<script>
    export default {
        props: {
            client: {},
        },
        data() {
            let label = ['ticket_expected', 'ticket_confirmation_rejected'].includes(this.client.status) ? 'Квиток' : 'Документ';
            return {
                fileTypeLabel: label,
                uploader: {
                    url: '/api/v1/files',
                    accept: '.jpg,.png,.pdf',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    label: 'Завантажити ' + label,
                    uploadingLabel: 'Завантаження',
                    data: {
                        client_id: this.client.id
                    }
                }
            };
        },
        methods: {
            onFileChange(file) {
                this.client.media.push(file.media);

                if (file.media.collection_name == 'tickets') {
                    this.client.ticket_uploaded = 1
                }

                Vue.notify({
                    type: 'success',
                    title: 'Завантажено',
                    text: this.fileTypeLabel + ' завантажено!'
                });
            },

            remove(id, index) {
                axios.delete('/api/v1/files/' + id).then((response) => {
                    this.client.media.splice(index, 1);
                })
            },

        },
        mounted() {

        }
    }
</script>

<style>
    .files-container {
        display: flex;
    }

    .files-container .file-col {
        display: inline-block;
        width: 350px;
        height: 200px;
        position: relative;
        border: 1px solid gray;
        padding: 10px;
        margin: 10px;
        overflow: hidden;
    }

    .files-container .file-col img {
        /* width: 330px;*/
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
