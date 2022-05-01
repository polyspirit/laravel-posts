<template>
    <div class="post rounded">
        <picture>
            <img v-bind:src="'storage/' + post.image" />
        </picture>
        <div class="title text-lg mb-4 mt-4 font-bold">{{ post.title }}</div>
        <div class="description mb-4">{{ post.description }}</div>
        <a v-bind:href="'#' + post.id" v-on:click="like" class="text-indigo-700"
            >Like Post: </a
        ><span>{{ post.likes.length }} ({{ likedUserNamesStr }})</span>
    </div>
</template>

<script>
import shared from "../shared";

export default {
    data: () => ({
        likedUserNamesStr: ""
    }),
    props: {
        post: Object,
    },
    beforeCreate() {
        this.$nextTick(function () {
            this.refreshLikes();
        });
    },
    methods: {
        like(e) {
            const postId = e.target.hash.replace(/^#/, "");

            axios
                .patch("/api/posts/" + postId, { like: true })
                .then((response) => {
                    if (response.data.status === "error") {
                        console.log(response);
                    } else {
                        this.post.likes = response.data.data.likes;
                        this.refreshLikes();

                        console.log(response.data);
                    }
                })
                .catch((error) => {
                    shared.consoleError(error);
                });
        },
        refreshLikes() {
            this.post.likedUserNamesArray = [];
            for (const like of this.post.likes) {
                this.post.likedUserNamesArray.push(like.user.name);
            }
            this.likedUserNamesStr =
                this.post.likedUserNamesArray.join(", ");
        },
    },
};
</script>