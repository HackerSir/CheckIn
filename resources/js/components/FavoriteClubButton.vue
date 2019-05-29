<template>
    <button class="btn btn-success" @click="handler"><i :class="[iconClass]" class="fa-fw mr-2"></i>收藏社團</button>
</template>

<script>
    export default {
        props: {
            favorited: {
                default: false
            },
            clubId: {
                required: true,
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
                    this.isFavorited = true;
                    toastr['success']('已新增至收藏社團');
                    this.loading = false;
                });
            },
            removeFavoriteClub: function () {
                let removeFavoriteClubAPIUrl = Laravel.baseUrl + '/api/remove-favorite-club/' + this.clubId;
                axios.post(removeFavoriteClubAPIUrl).then(response => {
                    this.isFavorited = false;
                    toastr['success']('已自收藏社團移除');
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>
