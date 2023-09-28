<style>

</style>
<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th @click="sortBy('username')" :class="{ 'sorted-asc': sortKey === 'username' && sortOrder === 'asc', 'sorted-desc': sortKey === 'username' && sortOrder === 'desc' }">Username</th>
                <th>Content</th>
                <th>Preview</th>
                <th @click="sortBy('email')" :class="{ 'sorted-asc': sortKey === 'email' && sortOrder === 'asc', 'sorted-desc': sortKey === 'email' && sortOrder === 'desc' }">E-mail</th>
                <th @click="sortBy('created_at')" :class="{ 'sorted-asc': sortKey === 'created_at' && sortOrder === 'asc', 'sorted-desc': sortKey === 'created_at' && sortOrder === 'desc' }">Created_at</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="comment in sortedComments" :key="comment.id">
                <td>{{ comment.username }}</td>
                <td v-html="comment.text"></td>
                <td>
                    <!-- Render different elements based on the file type -->
                    <div v-if="isImage(comment.file)">
                        <a :href="comment.file_url" data-lightbox="image-1" data-title="My caption">
                            <img :src="comment.file_url" alt="Image Preview">
                        </a>
                    </div>
                    <div v-else-if="isTextFile(comment.file)">
                        <!-- Display a link to download the text file -->
                        <a :href="comment.file_url" download>Download Text File</a>
                    </div>
                </td>
                <td>{{ comment.email }}</td>
                <td>{{ formatDate(comment.created_at) }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
    disableScrolling: true,
    fitImagesInViewport: false
})
export default {

    data() {
        return {
            username: "",
            email: "",
            text: "",
            comments: [],
            sortKey: "created_at",
            sortOrder: "desc",
        };
    },
    computed: {
        sortedComments() {
            return this.comments.sort((a, b) => {
                const modifier = this.sortOrder === "desc" ? -1 : 1;
                return modifier * (a[this.sortKey] - b[this.sortKey]);
            });
        },
    },
    methods: {

        isImage(fileUrl) {
            console.log('File URL:', fileUrl);
            if (!fileUrl) return false; // Check if fileUrl is undefined or empty
            const imageExtensions = ['.jpg', '.jpeg', '.gif', '.png'];
            const ext = this.getFileExtension(fileUrl);
            return imageExtensions.includes(ext);
        },
        isTextFile(fileUrl) {
            if (!fileUrl) return false; // Check if fileUrl is undefined or empty
            const textExtensions = ['.txt'];
            const ext = this.getFileExtension(fileUrl);
            return textExtensions.includes(ext);
        },

        getFileExtension(fileUrl) {
            const parts = fileUrl.split('.');
            if (parts.length > 1) {
                return '.' + parts[parts.length - 1].toLowerCase();
            }
            return '';
        },
        fetchComments() {
            // Запрос списка комментариев с сервера
            axios.get("/api/comments")
                .then(response => {
                    console.log(response)
                    this.comments = response.data.data;
                    console.log(this.comments)
                })
                .catch(error => {
                    console.error(error);
                });
        },
        sortBy(key) {
            // Изменение параметров сортировки
            this.sortKey = key;
            this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
        },
        formatDate(date) {
            return new Date(date).toLocaleString(); // Adjust date formatting as needed
        },
    },

    mounted() {
        // Загрузка комментариев при загрузке компонента
        this.fetchComments();
    },
};

</script>
