<template>
    <div class="card">
        <div class="card-body d-flex flex-column">
            <div class="d-inline-flex flex-column flex-sm-row" style="min-height: 160px">
                <div class="flex-shrink-0 p-0 mr-2 text-center">
                    <img v-if="club.image" :src="club.image" alt="社團圖片" class="img-fluid"
                         style="width: 160px; height: 160px">
                    <img v-else v-holder="'img=160x160?random=yes&auto=yes&text=沒有圖片'"
                         alt="社團圖片" class="img-fluid holder d-none d-sm-block"
                         src="" style="width: 160px; height: 160px">
                </div>
                <div class="d-flex flex-column flex-grow-1" style="min-height: 160px">
                    <h3 class="card-title">
                        <a :href="club_url" class="align-middle">{{ club.name }}</a>
                        <span v-if="club.tag.name"
                              :style="{'background-color':club.tag.color, 'font-size': '20px'}"
                              class='badge badge-secondary align-middle'>
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
                <a v-if="club.booth" :href="map_url" class="btn btn-outline-primary mx-sm-1 my-1 my-md-0"
                   target="_blank">
                    <i class="fas fa-map-marked-alt"></i> 地圖
                </a>
                <favorite-club-button v-if="$userId" :club-id="club.id"
                                      :club-name="club.name" :favorited="favorited"
                                      btn-class="btn btn-outline-success"
                                      btn-text="收藏"
                                      class="mx-sm-1 my-1 my-md-0"
                ></favorite-club-button>
            </div>
        </div>
    </div>
</template>

<script>
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
