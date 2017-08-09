<template>
    <div class="row mt-1">
        <div class="col-12 col-lg-6 mt-1" v-for="club in clubs">
            <club-card :club="club"></club-card>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$nextTick(function () {
                this.fetch();
            });
        },
        data: function () {
            return {
                clubs: [],
            }
        },
        methods: {
            fetch: function () {
                let self = this;
                let api_url = Laravel.baseUrl + '/api/club-list';
                axios.post(api_url).then(function (response) {
                    self.clubs = response.data;
                });
            },
        }
    }
</script>
