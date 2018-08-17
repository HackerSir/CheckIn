<template>
    <div class="card">
        <div class="card-body">
            <div class="row" style="min-height: 139px">
                <div class="col-4" style="padding: 0">
                    <div class="text-center">
                        <img :src="club.image" class="img-fluid" v-if="club.image">
                        <img v-holder="'img=160x160?random=yes&auto=yes&text=沒有圖片'" class="img-fluid holder" v-else>
                    </div>
                </div>
                <div class="col-8">
                    <h3 class="card-title">{{ club.name }}
                        <span class='badge badge-secondary align-middle'
                              :style="{'background-color':club.tag.color, 'font-size': '20px'}"
                              v-if="club.tag.name">
                            {{ club.tag.name }}
                        </span>
                    </h3>
                    <p class="card-text text-justify">{{ club.excerpt }}</p>
                    <a :href="club_url" class="card-link">了解更多</a>
                    <a :href="map_url" class="btn btn-outline-primary float-right" target="_blank" title="地圖" v-if="club.booth">
                        <i class="fas fa-map-marked-alt"></i>
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
