<template>
    <div>
        類型
        <select id="type_select" class="custom-select" v-model="selectedClubType" @change="onSelectChange">
            <option :value="null">全部</option>
            <option :value="id" v-for="(name, id) in clubTypes">{{ name }}</option>
        </select>
        <div class="float-sm-right mt-1">
            <span v-html="searchIndicator"></span> 搜尋
            <input type="text" v-model="searchKeyword" @input="onKeywordChange">
        </div>
        <div class="row mt-1">
            <div class="col-12 col-lg-6 mt-1" v-for="club in clubs">
                <club-card :club="club"></club-card>
            </div>
            <div class="col-12 mt-1" v-if="(selectedClubType || searchKeyword) && clubs.length == 0">
                <div class="card card-inverse card-warning">
                    <div class="card-block">
                        <blockquote class="card-blockquote">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            <span v-if="selectedClubType">在「{{ clubTypes[selectedClubType] }}」類型中</span>找不到相關社團
                        </blockquote>
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
        updated() {
            if (this.requireRenderHolderImages) {
                this.renderHolderImages();
            }
        },
        data: function () {
            return {
                selectedClubType: null,
                searchKeyword: '',
                clubTypes: [],
                clubs: [],
                requireRenderHolderImages: false,
                isTypingKeyword: false,
                isFetching: false
            }
        },
        computed: {
            searchIndicator: function () {
                if (this.isFetching) {
                    return '<i class="fa fa-spinner fa-pulse fa-fw"></i>';
                } else if (this.isTypingKeyword) {
                    return '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>';
                } else {
                    return '<i class="fa fa-search fa-fw" aria-hidden="true"></i>';
                }
            }
        },
        methods: {
            fetch: function () {
                let self = this;
                this.isFetching = true;
                //社團類型
                let club_type_list_url = Laravel.baseUrl + '/api/club-type-list';
                axios.post(club_type_list_url).then(function (response) {
                    self.clubTypes = response.data;
                });
                //社團清單
                let club_list_url = Laravel.baseUrl + '/api/club-list';
                axios.post(club_list_url, {
                    clubType: this.selectedClubType,
                    keyword: this.searchKeyword
                }).then(function (response) {
                    self.clubs = response.data;
                    self.isFetching = false;
                });
            },
            onSelectChange: function () {
                this.fetch();
            },
            onKeywordChange: function () {
                this.isTypingKeyword = true;
                this.delayFetch();
            },
            delayFetch: _.debounce(function () {
                this.isTypingKeyword = false;
                this.fetch();
            }, 1000),
            renderHolderImages: function () {
                let imageElements = $('img.holder:not([src])').get();
                Holder.run({
                    images: imageElements
                });
                this.requireRenderHolderImages = false;
            }
        },
        watch: {
            clubs: function () {
                this.requireRenderHolderImages = true;
            }
        }
    }
</script>
