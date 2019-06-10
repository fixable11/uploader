<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%;"  ></div>
                    </div>
                    <form action="" enctype="multipart/form-data">
                        <label for="file_upload" class="mt-3 btn btn-sm btn-success">
                            Upload file
                        </label>
                        <input @change="changed($event)"
                               style="display: none;"
                               type="file"
                               name="document"
                               id="file_upload"
                               accept=".xlsx, .xls, .csv"
                        >
                    </form>
                    <div class="notification">
                        <div class="alert" :class="alertClass" role="alert" v-html="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {

        data() {
            return {
                formData: new FormData(),
                progressBar: '',
                message: '',
                alertClass: '',
            };
        },

        methods: {
            changed(e) {
                let progressBar = this.$el.querySelector('.progress-bar');

                let config = {
                    onUploadProgress(progressEvent) {
                        let percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total);
                        progressBar.style.width = percentCompleted + '%';
                        progressBar.innerHTML = percentCompleted + '%';
                    },

                };
                this.formData.append('document', e.target.files[0]);

                axios.post('api/upload', this.formData, config)
                    .then((res) => {
                        this.alertClass = 'alert-success';
                        this.message = res.data || 'Success';
                    })
                    .catch((err) => {
                        this.alertClass = 'alert-danger';
                        console.dir(err);
                        this.message = err.response.data.message;
                    });
            }
        }

    }
</script>

<style scoped>

</style>