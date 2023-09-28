<template>

    <nav class="main-header navbar navbar-expand navbar-black navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">

            <li class="nav-link d-sm-inline-block btn btn-outline-primary" style="margin-right: 10px">
                <router-link :to="{name: 'index'}" class="text-secondary font-weight-bold">Home</router-link>
            </li>
            <li class="nav-link d-sm-inline-block btn btn-outline-warning">
                <router-link :to="{name: 'create'}" class="text-secondary font-weight-bold">Create</router-link>
            </li>

        </ul>

        <!-- Right navbar links -->
    </nav>

    <!-- Your template code here -->
    <div class="col-12">
        <router-view></router-view>
    </div>

</template>

<script>
export default {
    // Your component options here
}
</script>

<style scoped>
/* Your component styles here */
</style>
