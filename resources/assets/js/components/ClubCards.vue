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
                this.clubs = [
                    {
                        id: 1,
                        name: 'name',
                        image: 'https://i.imgur.com/jlrCn72b.jpg',
                        tag: {
                            name: 'tag name',
                            color: 'red'
                        },
                        excerpt: 'excerpt'
                    }, {
                        id: 2,
                        name: 'name2',
                        image: '',
                        tag: {
                            name: 'tag2',
                            color: 'blue'
                        },
                        excerpt: 'test test test'
                    },
                ];
            },
        }
    }
</script>
