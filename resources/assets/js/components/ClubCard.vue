<template>
    <div class="card">
        <div class="card-body d-inline-flex flex-column flex-sm-row" style="min-height: 160px">
            <div class="flex-shrink-0 p-0 mr-2 text-center">
                <img :src="club.image" class="img-fluid" v-if="club.image">
                <img v-holder="'img=160x160?random=yes&auto=yes&text=沒有圖片'" class="img-fluid holder d-none d-sm-block"
                     v-else>
            </div>
            <div class="d-flex flex-column flex-grow-1" style="min-height: 160px">
                <h3 class="card-title">
                    <a :href="club_url" class="align-middle">{{ club.name }}</a>
                    <span class='badge badge-secondary align-middle'
                          :style="{'background-color':club.tag.color, 'font-size': '20px'}"
                          v-if="club.tag.name">
                        {{ club.tag.name }}
                    </span>
                </h3>
                <p class="card-text text-justify">{{ club.excerpt }}</p>
                <div class="mt-auto">
                    <a :href="club_url" class="btn btn-outline-primary">
                        <i class="fa fa-search"></i> 了解更多
                    </a>
                    <a :href="map_url" class="btn btn-outline-primary float-right" target="_blank" v-if="club.booth">
                        <i class="fas fa-map-marked-alt"></i> 地圖
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueHolder from 'vue-holderjs';

    Vue.use(VueHolder);

    export default {
        props: [
            'club'
        ],
        computed: {
            club_url: function () {
                return Laravel.baseUrl + '/clubs/' + this.club.id;
            },
            map_url: function () {
                if (this.club.booth == null) {
                    return '';
                }
                return 'https://maps.google.com/?q=' + this.club.booth.latitude + ',' + this.club.booth.longitude;
            }
        }
    }
</script>
