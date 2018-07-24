<template>
    <div class="card">
        <div class="card-block">
            <div class="row" style="min-height: 139px">
                <div class="col-4" style="padding: 0">
                    <div class="text-center">
                        <img :src="club.image" class="img-fluid" v-if="club.image">
                        <img src="" data-src="holder.js/160x160?random=yes&auto=yes&text=沒有圖片" class="img-fluid holder"
                             v-else>
                    </div>
                </div>
                <div class="col-8">
                    <h3 class="card-title">{{ club.name }}
                        <span class='badge badge-default align-middle'
                              :style="{'background-color':club.tag.color, 'font-size': '20px'}"
                              v-if="club.tag.name">
                            {{ club.tag.name }}
                        </span>
                    </h3>
                    <p class="card-text text-justify">{{ club.excerpt }}</p>
                    <a :href="club_url" class="card-link">了解更多</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'club'
        ],
        computed: {
            club_url: function () {
                return Laravel.baseUrl + '/clubs/' + this.club.id;
            }
        }
    }
</script>
