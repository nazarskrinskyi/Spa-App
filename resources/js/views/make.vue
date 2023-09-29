<style>
@import url("/node_modules/vue-client-recaptcha/dist/style.css");
.ql-editor {
    min-height: 200px;
}
</style>

<template>

    <div class="error col-6" v-if="captchaError">{{ captchaError }}</div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-7 col-md-9 col-sm-10">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                    type="text"
                    id="username"
                    autocomplete="on"
                    class="form-control"
                    v-model="username"
                    placeholder="Username..."
                    required
                />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="text"
                    id="email"
                    autocomplete="on"
                    class="form-control"
                    v-model="email"
                    placeholder="Email..."
                    required
                />
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <div id="file" class="card flex justify-content-center">
                    <Toast/>
                    <FileUpload
                        type="file"
                        id="file"
                        class="form-control"
                        ref="fileInput"
                        @change="handleFileUpload"
                        @remove="handleFileRemove"
                        @removeUploadedFile="handleFileRemove"
                        @remove-uploaded-file="handleFileRemove"
                        zmode="basic"
                        url="/api/create"
                        accept="image/*,.txt"
                        @upload="saveFile"
                        :disabled="fileUploadError !== null || isFileInputDisabled"

                    />
                </div>
                <div v-if="fileUploadError" class="text-danger">{{ fileUploadError }}</div>
            </div>

            <div class="mb-3">
                <label for="summernote" class="form-label">Content</label>
                <QuillEditor type="text" theme="snow" id="summernote"
                             class="form-control"
                             v-model="content"
                             ref="quill_content"
                             placeholder="Content..."
                             autocomplete="on" toolbar="#my-toolbar" required>
                    <template #toolbar>
                        <div id="my-toolbar">
                            <!-- Add buttons as you would before -->
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-link"></button>
                            <button class="ql-code"></button>

                            <!-- But you can also add your own -->
                            <button id="custom-button"></button>
                        </div>
                    </template>
                </QuillEditor>
            </div>

            <label for="text" class="form-label">Captcha</label>
            <div class="sample-captcha" style="margin-left: 15px">
                <div class="row">
                    <input type="text"
                           id="captcha"
                           class="w-25 form-control"
                           style="width: 200px;height: 75px"
                           v-model="captcha"
                           required>
                    <vue-client-recaptcha
                        :hideLines="true"
                        :show-capital-case-letters="false"
                        :show-lower-case-letters="false"
                        :show-numbers="true"
                        custom-text-color="black"
                        v-model="captchaText"
                        @getCode="getCaptchaCode"
                        @isValid="checkValidCaptcha"
                    >
                        <template #icon>
                            <button type="button" class="btn btn-outline-danger reload" @click="refreshCaptcha">
                                &#x21bb;
                            </button>
                        </template>
                    </vue-client-recaptcha>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-2" @click.prevent="createComment">Create</button>

        </div>

    </div>
</template>


<script setup>

import {useToast} from "primevue/usetoast";

const toast = useToast();


const onUpload = () => {
    toast.add({severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000});

};

</script>

<script>

import VueClientRecaptcha from "vue-client-recaptcha";

export default {
    components: {VueClientRecaptcha},
    data() {
        return {
            username: "",
            email: "",
            content: '',
            captcha: "",
            file: null,
            selectedFile: null,
            fileUploadError: null, // Add a property for file upload error
            captchaError: null, // Add a property for file upload error
            captchaText: "", // Store the server-generated CAPTCHA text here
            isCaptchaValid: false,
            hasAttemptedCaptcha: false,
            isFileInputDisabled: false,
        };
    },

    methods: {
        getCaptchaCode(value) {
            this.captchaText = value; // Update captchaText directly
            console.log(value)
            console.log(this.captchaText);
        },
        checkValidCaptcha() {
            if (this.captcha === this.captchaText) {
                this.isCaptchaValid = true;
                this.captchaError = null;
                return this.isCaptchaValid;
            } else {
                this.isCaptchaValid = false;
                this.hasAttemptedCaptcha = true;
                return this.isCaptchaValid;
            }
        },
        saveFile() {
            this.file = this.selectedFile;
            this.isFileInputDisabled = this.file !== null; // Set the reactive data property based on the file status
        },

        handleFileUpload() {
            const fileInput = this.$refs.fileInput;
            console.log(fileInput.files)

            if (fileInput.files.length <= 1) {
                const file = fileInput.files[0];

                if (this.isValidFileType(file)) {
                    if (file.type.startsWith('image/')) {
                        console.log('img')
                        // Handle image file
                        this.handleImageFile(file);
                    } else if (file.type === 'text/plain') {
                        // Handle text file
                        console.log('text')
                        this.handleTextFile(file);
                    } else {
                        this.clearFileInput();
                        this.fileUploadError = "Invalid file type.";
                    }
                } else {
                    this.clearFileInput();
                    this.fileUploadError = "Invalid file type or size.";
                }
            } else {
                this.fileUploadError = "You can upload only 1 file";
            }

        },

        isValidFileType(file) {
            const allowedTypes = ["image/jpeg", "image/png", "image/gif", "text/plain"];
            return allowedTypes.includes(file.type);
        },

        isValidFileSize(file) {
            const maxSize = 100 * 1024; // 100 KB
            return file.size <= maxSize;
        },

        handleImageFile(file) {
            // Check image dimensions (width and height)
            const maxWidth = 320;
            const maxHeight = 240;

            const img = new Image();
            img.src = URL.createObjectURL(file);

            img.onload = () => {
                if (img.width <= maxWidth && img.height <= maxHeight) {
                    // Image meets size requirements, no need to resize
                    this.fileUploadError = null;
                    console.log(img)
                    console.log(file)
                    this.selectedFile = file;
                } else {
                    // Resize the image proportionally to fit within the dimensions
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const scaleFactor = Math.min(maxWidth / img.width, maxHeight / img.height);

                    canvas.width = img.width * scaleFactor;
                    canvas.height = img.height * scaleFactor;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob((blob) => {
                        const resizedFile = new File([blob], file.name, {type: file.type});
                        this.fileUploadError = null;
                        console.log('resize')
                        console.log(resizedFile)
                        this.selectedFile = resizedFile;
                    }, file.type);
                }
            };
        },

        handleTextFile(file) {
            if (this.isValidFileSize(file)) {
                // Text file size is valid
                this.fileUploadError = null;
                this.selectedFile = file;
            } else {
                this.clearFileInput();
                this.fileUploadError = "Text file size exceeds 100 KB.";
            }
        },

        clearFileInput() {
            // Reset the file input field
            const fileInput = this.$refs.fileInput;
            fileInput.value = "";
            this.file = null;
        },

        handleFileRemove() {
            this.fileUploadError = null;
            this.file = null;
            this.isFileInputDisabled = false;
        },

        refreshCaptcha() {
            this.captcha = "";
            this.isCaptchaValid = false;
            this.hasAttemptedCaptcha = false;
            this.captchaText = ""; // Clear the CAPTCHA text
        },

        createComment() {
            const formData = new FormData();
            this.content = this.$refs.quill_content.getHTML();
            console.log(this.content)
            formData.append("username", this.username);
            formData.append("email", this.email);
            formData.append("text", this.content);
            formData.append("file", this.file);
            console.log(formData)

            if (this.checkValidCaptcha()) {
                this.axios
                    .post("/api/create", formData)
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                this.captchaError = 'Incorrect captcha verification';
            }
        },
    },

};
</script>

