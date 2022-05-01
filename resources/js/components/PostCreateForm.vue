<template>
    <form id="post-form" method="POST" action="/i" @submit="sendPost">
        <h1 class="mb-4 font-bold">Create a post</h1>
        <label for="title" class="block text-sm text-gray-900"
            >Post title</label
        >
        <div class="mb-4 relative rounded shadow-sm">
            <input
                type="text"
                name="title"
                id="title"
                class="
                    focus:ring-indigo-500 focus:border-indigo-500
                    block
                    w-full
                    pl-7
                    pr-12
                    sm:text-sm
                    border-gray-300
                    rounded
                "
                placeholder="Metamorphosis"
                v-model="title"
            />
        </div>
        <label for="description" class="block text-sm text-gray-900"
            >Post Text</label
        >
        <div class="mb-4 relative rounded shadow-sm">
            <textarea
                name="description"
                id="description"
                cols="30"
                class="
                    focus:ring-indigo-500 focus:border-indigo-500
                    block
                    w-full
                    pl-7
                    pr-12
                    sm:text-sm
                    border-gray-300
                    rounded
                "
                v-model="description"
                rows="5"
                placeholder="One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin."
            ></textarea>
        </div>
        <label for="description" class="block text-sm text-gray-900"
            >Post Image</label
        >
        <div class="mb-4 relative">
            <input
                type="file"
                @change="handleFileUpload($event)"
                class="rounded"
            />
        </div>
        <div class="relative rounded shadow-sm">
            <button
                type="submit"
                class="
                    py-2
                    px-3
                    bg-indigo-500
                    text-white text-sm
                    font-semibold
                    rounded-md
                    shadow
                    focus:outline-none
                    w-full
                "
            >
                Send
            </button>
        </div>
        <div class="response mt-4" v-bind:class="{ active: response }">
            {{ response }}
        </div>
    </form>
</template>

<script>
import shared from '../shared'

export default {
    data: () => ({
        title: "",
        description: "",
        file: "",
        response: "",
    }),
    methods: {
        sendPost(e) {
            e.preventDefault();

            const _this = this;

            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("file", this.file);

            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/api/posts", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        if (response.data.status === "error") {
                            console.log(response);
                        } else {
                            _this.response = response.data.message;
                            console.log(response.data);
                        }
                    })
                    .catch((error) => {
                        shared.consoleError(error);
                    });
            });
        },
        handleFileUpload(e) {
            this.file = e.target.files[0];
        },
    },
};
</script>
