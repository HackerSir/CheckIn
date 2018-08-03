<template>
    <div class="card" style="min-height: 50vh">
        <div class="card-body">
            <form @submit.prevent="sendMessage">
                <div class="input-group">
                    <input type="text" class="form-control" id="message" autocomplete="off" v-model="message">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </div>
                </div>
            </form>
            <ul class="list-group">
                <li class="list-group-item" v-for="msg in messages">{{ msg.user }}：{{ msg.message }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "BroadcastTest",
        data () {
            return {
                message: '',
                messages: []
            }
        },
        methods: {
            sendMessage: function () {

            }
        }
    }
</script>

<style scoped>

</style>
