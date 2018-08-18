<template>
    <div class="card" style="min-height: 50vh">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-end mb-2">
                <i :class="getConnectStatusIconClass"></i><span class="ml-1">{{ getConnectStatusText }}</span>
            </div>
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
    let connectStatusText = {
        'connect': '已連線',
        'disconnect': '連線中斷',
        'reconnecting': '連線中',
    };

    let connectStatusIconClass = {
        'connect': 'fas fa-check-circle text-success',
        'disconnect': 'fas fa-times-circle text-danger',
        'reconnecting': 'fas fa-spinner fa-pulse',
    };

    export default {
        name: "BroadcastTest",
        data() {
            return {
                connectStatus: '',
                message: '',
                messages: []
            }
        },
        mounted() {
            window.Echo.private('admin.test')
                .listen('AdminTest', (e) => {
                    this.messages.push({
                        user: e.username,
                        message: e.message
                    })
                });
            window.Echo.connector.socket.on('connect', () => {
                this.connectStatus = 'connect';
            });
            window.Echo.connector.socket.on('disconnect', () => {
                this.connectStatus = 'disconnect';
            });
            window.Echo.connector.socket.on('reconnecting', () => {
                this.connectStatus = 'reconnecting';
            });
        },
        computed: {
            getConnectStatusText: function () {
                if (this.connectStatus === '') {
                    return connectStatusText['reconnecting'];
                }
                return connectStatusText[this.connectStatus];
            },
            getConnectStatusIconClass: function () {
                if (this.connectStatus === '') {
                    return connectStatusIconClass['reconnecting'];
                }
                return connectStatusIconClass[this.connectStatus];
            }
        },
        methods: {
            sendMessage: function () {
                axios.post(window.Laravel.api.message, {message: this.message})
                    .then((response) => {
                        if (response.status === 200) {
                            this.message = '';
                        }
                    });
            }
        }
    }
</script>

<style scoped>

</style>
