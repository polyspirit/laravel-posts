<template>
    <div class="posts-list">
        <posts-list
            v-for="(post, i) of posts"
            v-bind:key="i"
            v-bind:post="post"
        ></posts-list>
    </div>
</template>

<script>
import shared from '../shared'

export default {
    data: () => ({
        posts: [],
    }),
    mounted() {
        this.$nextTick(function () {
            axios.get("/sanctum/csrf-cookie").then((response) => {

                axios
                    .get("/api/posts")
                    .then((response) => {
                        if (response.data.status === "error") {
                            console.log(response);
                        } else {
                            this.posts = response.data.data;
                        }
                    })
                    .catch((error) => {
                        shared.consoleError(error);
                    });

            });
        });
    },
    methods: {

    }
}
</script>