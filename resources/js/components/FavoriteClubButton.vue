<template>
    <button :class="[btnClass]" @click="handler"><i :class="[iconClass]" class="fa-fw mr-2"></i>{{ btnText }}</button>
</template>

<script>
    import Vuex from 'vuex'
    import VuexPersist from 'vuex-persist'

    Vue.use(Vuex);
    const vuexPersist = new VuexPersist({
        key: 'checkin/club',
        storage: localStorage
    });
    const store = new Vuex.Store({
        plugins: [vuexPersist.plugin],
        state: {
            clubs: [],
        },
        mutations: {
            addFavoriteClub(state, clubId) {
                let idx = state.clubs.findIndex((element) => element.id === clubId);
                state.clubs[idx].isFavorite = true;
            },
            removeFavoriteClub(state, clubId) {
                let idx = state.clubs.findIndex((element) => element.id === clubId);
                state.clubs[idx].isFavorite = false;
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
        created() {
            //FIXME: 在 ClubCards 中，上面的 data 部分無法順利初始化，因此500ms之後再次嘗試進行
            _.delay(() => {
                this.isFavorited = this.favorited;
            }, 500)
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
                    //觸發事件
                    this.$emit('favorite-button-clicked', 'add', this.clubId);
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
                    //觸發事件
                    this.$emit('favorite-button-clicked', 'remove', this.clubId);
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
