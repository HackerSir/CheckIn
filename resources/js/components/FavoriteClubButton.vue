<template>
    <button :class="[btnClass]" @click="handler"><i :class="[iconClass]" class="fa-fw mr-2"></i>{{ btnText }}</button>
</template>

<script>
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
                    this.isFavorited = true;
                    toastr['success']('已收藏「' + this.clubName + '」');
                    this.loading = false;
                    this.$emit('favorite-button-clicked', 'add', this.clubId);
                });
            },
            removeFavoriteClub: function () {
                let removeFavoriteClubAPIUrl = Laravel.baseUrl + '/api/remove-favorite-club/' + this.clubId;
                axios.post(removeFavoriteClubAPIUrl).then(response => {
                    this.isFavorited = false;
                    toastr['success']('已取消收藏「' + this.clubName + '」');
                    this.loading = false;
                    this.$emit('favorite-button-clicked', 'remove', this.clubId);
                });
            }
        }
    }
</script>

<style scoped>

</style>
