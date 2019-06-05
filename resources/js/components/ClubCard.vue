<template>
    <div class="card">
        <div class="card-body d-flex flex-column">
            <div class="d-inline-flex flex-column flex-sm-row" style="min-height: 160px">
                <div class="flex-shrink-0 p-0 mr-2 text-center">
                    <img :src="club.image" class="img-fluid" alt="社團圖片" v-if="club.image"
                         style="width: 160px; height: 160px">
                    <img src="" v-holder="'img=160x160?random=yes&auto=yes&text=沒有圖片'"
                         class="img-fluid holder d-none d-sm-block" alt="社團圖片"
                         style="width: 160px; height: 160px" v-else>
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
                </div>
            </div>
            <div class="d-flex justify-content-center flex-column flex-sm-row mt-2">
                <a :href="club_url" class="btn btn-outline-primary mx-sm-1 my-1 my-md-0">
                    <i class="fa fa-search"></i> 了解更多
                </a>
                <a :href="map_url" class="btn btn-outline-primary mx-sm-1 my-1 my-md-0" target="_blank"
                   v-if="club.booth">
                    <i class="fas fa-map-marked-alt"></i> 地圖
                </a>
                <favorite-club-button :club-id="club.id" :club-name="club.name"
                                      btn-class="btn btn-outline-success" btn-text="收藏"
                                      :favorited="favorited"
                                      class="mx-sm-1 my-1 my-md-0"
                                      v-if="$userId"
                ></favorite-club-button>
            </div>
        </div>
    </div>
</template>

<script>
    import VueHolder from 'vue-holderjs';

    Vue.use(VueHolder);

    export default {
        props: [
            'club',
            'favorited'
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
