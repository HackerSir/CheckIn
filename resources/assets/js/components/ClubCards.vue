<template>
    <div class="row mt-1">
        <div class="col-12 col-lg-6 mt-1" v-for="club in clubs">
            <div class="card">
                <div class="card-block">
                    <div class="row" style="min-height: 139px">
                        <div class="col-4" style="padding: 0">
                            <div class="text-center">
                                <img :src="club.image" class="img-fluid" v-if="club.image" />
                                <img data-src="holder.js/160x160?random=yes&auto=yes&text=沒有圖片" class="img-fluid" v-else />
                            </div>
                        </div>
                        <div class="col-8">
                            <h3 class="card-title">{{ club.name }}
                                <span class='badge badge-default align-middle' :style="{'background-color':club.tag.color, 'font-size': '20px'}">{{ club.tag.name }}</span>
                                </h3>
                            <p class="card-text text-justify">{{ club.excerpt }}</p>
                            <a href="#" class="card-link">了解更多</a>
                        </div>
                    </div>
                </div>
            </div>
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
                        name: 'name',
                        image: 'https://i.imgur.com/jlrCn72b.jpg',
                        tag: {
                            name: 'tag name',
                            color: 'red'
                        },
                        excerpt: 'excerpt'
                    }, {
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
