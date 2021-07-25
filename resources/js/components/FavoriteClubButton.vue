<template>
    <button :class="[btnClass]" @click="handler" :disabled="this.loading"><i :class="[iconClass]" class="fa-fw mr-2"></i>{{ btnText }}</button>
</template>

<script>
    import Vuex from 'vuex'
    import VuexPersist from 'vuex-persist'

    const vuexPersist = new VuexPersist({
        key: 'checkin/club',
        storage: localStorage
    });
    const store = new Vuex.Store({
        plugins: [vuexPersist.plugin],
        state: {
            clubs: [],
            favoriteButtonLastTriggeredAt: +new Date()
        },
        mutations: {
            addFavoriteClub(state, clubId) {
                //嘗試從緩存資料找到該社團
                let idx = state.clubs.findIndex((element) => element.id === clubId);
                if (idx !== -1) {
                    //若有緩存資料，則更新緩存資料的收藏狀態
                    state.clubs[idx].isFavorite = true;
                }
            },
            removeFavoriteClub(state, clubId) {
                //嘗試從緩存資料找到該社團
                let idx = state.clubs.findIndex((element) => element.id === clubId);
                if (idx !== -1) {
                    //若有緩存資料，則更新緩存資料的收藏狀態
                    state.clubs[idx].isFavorite = false;
                }
            },
            renewFavoriteButtonLastTriggeredAt(state) {
                state.favoriteButtonLastTriggeredAt = +new Date()
            }
        }
    });

    export default {
        props: {
            favorited: {
                default: false
            },
            clubId: {
                required: true,
            },
            clubName: {
                type: String,
                required: true
            },
            btnClass: {
                type: String,
                default: 'btn btn-success'
            },
            btnText: {
                type: String,
                default: '收藏社團'
            }
        },
        data: function () {
            return {
                loading: false,
                isFavorited: this.favorited
            }
        },
        computed: {
            iconClass: function () {
                if (this.loading) {
                    return 'fas fa-spinner fa-pulse';
                }
                return this.isFavorited ? 'fas fa-star' : 'far fa-star'
            }
        },
        methods: {
            handler: function () {
                this.loading = true;
                if (!this.isFavorited) {
                    this.addFavoriteClub()
                } else {
                    this.removeFavoriteClub()
                }
            },
            addFavoriteClub: function () {
                let addFavoriteClubAPIUrl = Laravel.baseUrl + '/api/add-favorite-club/' + this.clubId;
                axios.post(addFavoriteClubAPIUrl).then(response => {
                    //更新暫存資料
                    store.commit('addFavoriteClub', this.clubId);
                    store.commit('renewFavoriteButtonLastTriggeredAt');
                    this.isFavorited = true;
                    toastr['success']('已收藏「' + this.clubName + '」');
                    this.loading = false;
                });
            },
            removeFavoriteClub: function () {
                let removeFavoriteClubAPIUrl = Laravel.baseUrl + '/api/remove-favorite-club/' + this.clubId;
                axios.post(removeFavoriteClubAPIUrl).then(response => {
                    //更新暫存資料
                    store.commit('removeFavoriteClub', this.clubId);
                    store.commit('renewFavoriteButtonLastTriggeredAt');
                    this.isFavorited = false;
                    toastr['success']('已取消收藏「' + this.clubName + '」');
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>
