<style>

</style>
<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th @click="sortBy('username')"
                    :class="{ 'sorted-asc': sortKey === 'username' && sortOrder === 'asc', 'sorted-desc': sortKey === 'username' && sortOrder === 'desc' }">
                    Username
                </th>
                <th>Content</th>
                <th>Preview</th>
                <th @click="sortBy('email')"
                    :class="{ 'sorted-asc': sortKey === 'email' && sortOrder === 'asc', 'sorted-desc': sortKey === 'email' && sortOrder === 'desc' }">
                    E-mail
                </th>
                <th @click="sortBy('created_at')"
                    :class="{ 'sorted-asc': sortKey === 'created_at' && sortOrder === 'asc', 'sorted-desc': sortKey === 'created_at' && sortOrder === 'desc' }">
                    Created_at
                </th>
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
        <div class="mt-3 d-flex justify-content-center">
            <paginate
                :page-count="Math.ceil(totalItems / perPage)"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :prev-class="'page-prev'"
                :next-class="'page-next'"
            >
            </paginate>
        </div>
    </div>
</template>


<script>
import Paginate from 'vuejs-paginate-next';

lightbox.option({
    resizeDuration: 400,
    wrapAround: true,
    disableScrolling: true,
    fitImagesInViewport: false
})

export default {
    components: {
        paginate: Paginate,
    },
    data() {
        return {
            username: "",
            email: "",
            text: "",
            comments: [],
            sortKey: 'created_at',
            sortOrder: "desc",
            currentPage: 1,
            perPage: 25, // Set the number of items per page as needed
            totalItems: 0, // Initialize with the total number of items
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
        clickCallback(pageNum) {
            this.currentPage = pageNum;
            this.fetchComments();
        },

        isImage(fileUrl) {
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
            // Calculate the offset based on the current page and perPage
            axios.post("/api/comments", {
                [this.sortKey]: this.sortOrder,
                page: this.currentPage, // Send the current page as a parameter
                per_page: this.perPage, // Send the number of items per page as a parameter
            })
                .then(response => {
                    this.comments = response.data.data;
                    this.totalItems = response.data.total; // Set the total number of items
                })
                .catch(error => {
                    console.error(error);
                });
        },
        sortBy(key) {
            // Изменение параметров сортировки
            this.sortKey = key;
            this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
            this.fetchComments();
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
