<template>
    <div class="container-fluid p-5">

        <div class="files-container">
            <div class="file-col" v-for="file in client.media">

                <a :href="file.url" target="_blank" class="d-block mb-4 h-100">
                    <img :src="file.url" v-if="['image/jpeg', 'image/png'].includes(file.mime_type)">

                    <img src="/img/file-icon.png" v-if="!['image/jpeg', 'image/png'].includes(file.mime_type)">
                </a>

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
            return {
                uploader: {
                    url: '/api/v1/files',
                    accept: '.jpg,.png,.pdf',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    label: 'Завантажити документи',
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

                Vue.notify({
                    type: 'success',
                    title: 'Завантажено',
                    text: 'Документ завантажено!'
                });
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
    }

    .files-container .file-col img {
       /* width: 330px;*/
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
