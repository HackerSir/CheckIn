<template>
    <div>
        <div class="d-flex flex-column flex-sm-row flex-wrap">
            <div class="mt-1">
                根據類型過濾：
                <select id="type_select" v-model="selectedClubType" class="custom-select" style="width: inherit"
                        @change="onSelectChange">
                    <option :value="null">- 顯示全部 -</option>
                    <option v-for="(name, id) in clubTypes" :value="id">{{ name }}</option>
                </select>
                <button aria-controls="collapseExample" aria-expanded="false" class="btn btn-secondary"
                        data-target="#clubTypeDescription" data-toggle="collapse" type="button">
                    <i class="fas fa-question"></i>
                </button>
                <button class="btn btn-success" type="button" @click="updateRandomSeed">
                    <i class="fas fa-sync mr-2"></i>隨機排列
                </button>
            </div>
            <div class="ml-sm-auto mt-1 d-inline-flex align-items-center">
                <p class="text-nowrap mb-0 mr-1"><span v-html="searchIndicator"></span> 搜尋</p>
                <input v-model="searchKeyword" class="form-control" type="text" @input="onKeywordChange">
            </div>
        </div>
        <div id="clubTypeDescription" class="collapse">
            <div class="card card-body">
                <ul>
                    <li><strong>學藝性</strong>：活動內容多較靜態，可再細分為藝文、學術、宗教、技藝性等，並於校內舉行各種學術性與藝術性的展覽以及研究。</li>
                    <li><strong>體能性</strong>：活動類型為動態，皆為喜愛運動的同學組成各式社團，有球類、武術、田徑等類型，推廣校內運動風氣。</li>
                    <li><strong>服務性</strong>：活動類型多為參與社會服務活動。</li>
                    <li><strong>康樂性</strong>：活動內容較為動態，可再分為音樂、舞蹈、歌唱、樂器、研習技能，並常於校內外活動獲邀表演。</li>
                    <li><strong>聯誼性</strong>：由全國各公、私立高中畢業校友所組成，重視會員間感情的聯誼與支持，並常於校內舉辦大型活動，風格活潑多元。</li>
                    <li><strong>自治性</strong>：為系學會，是由各系組成的社團，規劃系上各項活動、研習與交流，聯繫系上同學間之情感。</li>
                </ul>
            </div>
        </div>
        <div class="row mt-1">
            <div v-for="club in clubs" class="col-12 col-lg-6 mt-1">
                <club-card :club="club"
                           :favorited="club.isFavorite"
                ></club-card>
            </div>
        </div>
        <infinite-loading ref="infiniteLoading" :identifier="identifier" @infinite="infiniteHandler">
            <div slot="no-results">
                <div class="alert alert-danger">
                    <i aria-hidden="true" class="fa fa-exclamation-triangle"></i>
                    <span v-if="selectedClubType">在「{{ clubTypes[selectedClubType] }}」類型中</span>找不到相關社團
                </div>
            </div>
            <span slot="no-more">
                沒有更多社團了 ヽ(ﾟ∀ﾟ*)ノ
            </span>
            <span slot="spinner">
                <i aria-hidden="true" class="fa fa-spinner fa-pulse fa-fw fa-3x mt-3"></i>
            </span>
        </infinite-loading>
    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'

const vuexPersist = new VuexPersist({
    key: 'checkin/club',
    storage: localStorage
});
const store = new Vuex.Store({
    plugins: [vuexPersist.plugin],
    state: {
        selectedClubType: null,
        searchKeyword: '',
        clubs: [],
        clubCachedAt: null,
        favoriteButtonLastTriggeredAt: +new Date(),
        fetchFinish: false,
        cacheForFavorite: false,
        randomSeed: null
    },
    mutations: {
        setSelectedClubType(state, selectedClubType) {
            state.selectedClubType = selectedClubType
        },
        setSearchKeyword(state, searchKeyword) {
            state.searchKeyword = searchKeyword
        },
        setClubs(state, clubs) {
            state.clubs = clubs
        },
        setFetchFinish(state, fetchFinish) {
            state.fetchFinish = fetchFinish
        },
        setCacheForFavorite(state, cacheForFavorite) {
            state.cacheForFavorite = cacheForFavorite
        },
        setClubCachedAt(state, clubCachedAt) {
            state.clubCachedAt = clubCachedAt;
        },
        setRandomSeed(state, randomSeed) {
            state.randomSeed = randomSeed
        }
    }
});

export default {
    props: {
        favoriteOnly: {
            default: false
        }
    },
    created() {
        //TODO: 檢查 cacheForFavorite，確保暫存資料不會被混用，或許有更好的做法
        //若緩存之後，資料仍有更新，則強制更新；若正檢視收藏社團，則亦考慮最後一次使用收藏按鈕的時間點
        if (this.cacheForFavorite !== this.favoriteOnly
            || this.clubLastUpdateAt > this.clubCachedAt
            || (this.favoriteOnly && this.favoriteButtonLastTriggeredAt > this.clubCachedAt)
        ) {
            this.clubs = [];
            this.fetchFinish = false;
            this.identifier++;
        }
        this.$nextTick(function () {
            this.fetchClubTypes();
        });
    },
    data: function () {
        return {
            identifier: +new Date(),
            clubTypes: [],
            // clubs: [],
            isTypingKeyword: false,
            isFetching: false,
            itemPerPage: 20
        }
    },
    computed: {
        searchIndicator: function () {
            if (this.isFetching) {
                return '<i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i>';
            } else if (this.isTypingKeyword) {
                return '<i class="fa fa-pencil-alt fa-fw" aria-hidden="true"></i>';
            } else {
                return '<i class="fa fa-search fa-fw" aria-hidden="true"></i>';
            }
        },
        selectedClubType: {
            get() {
                return store.state.selectedClubType
            },
            set(value) {
                store.commit('setSelectedClubType', value)
            }
        },
        searchKeyword: {
            get() {
                return store.state.searchKeyword
            },
            set(value) {
                store.commit('setSearchKeyword', value)
            }
        },
        clubs: {
            get() {
                return store.state.clubs
            },
            set(value) {
                store.commit('setClubs', value)
            }
        },
        fetchFinish: {
            get() {
                return store.state.fetchFinish
            },
            set(value) {
                store.commit('setFetchFinish', value)
            }
        },
        cacheForFavorite: {
            get() {
                return store.state.cacheForFavorite
            },
            set(value) {
                store.commit('setCacheForFavorite', value)
            }
        },
        clubCachedAt: {
            get() {
                return store.state.clubCachedAt
            },
            set(value) {
                store.commit('setClubCachedAt', value)
            }
        },
        clubLastUpdateAt: {
            get() {
                let clubLastUpdateAtString = $('meta[name="club-last-updated-at"]').attr('content');
                return +new Date(clubLastUpdateAtString);
            }
        },
        favoriteButtonLastTriggeredAt: {
            get() {
                return store.state.favoriteButtonLastTriggeredAt
            }
        },
        randomSeed: {
            get() {
                return store.state.randomSeed
            },
            set(value) {
                store.commit('setRandomSeed', value)
            }
        }
    },
    methods: {
        infiniteHandler($state) {
            if (this.fetchFinish) {
                //若暫存資料已完整，直接結束
                $state.loaded();
                $state.complete();
                this.isFetching = false;
                return;
            }
            setTimeout(() => {
                this.isFetching = true;
                let nextPage = Math.ceil(this.clubs.length / this.itemPerPage) + 1;
                //社團清單
                let club_list_url = Laravel.baseUrl + '/api/club-list?page=' + nextPage;
                if (this.randomSeed) {
                    club_list_url += '&randomSeed=' + this.randomSeed;
                }
                //限定顯示收藏社團
                if (this.favoriteOnly) {
                    club_list_url += '&favorite';
                }
                //TODO: 記錄 cacheForFavorite，確保暫存資料不會被混用，或許有更好的做法
                this.cacheForFavorite = this.favoriteOnly;
                axios.post(club_list_url, {
                    clubType: this.selectedClubType,
                    keyword: this.searchKeyword
                }).then(response => {
                    let responseBody = response.data;
                    let clubsData = responseBody.data;
                    if (clubsData.length) {
                        this.clubs = this.clubs.concat(clubsData);
                        $state.loaded();
                        if (responseBody.current_page >= responseBody.last_page) {
                            //沒下一頁
                            $state.complete();
                            this.fetchFinish = true;
                        }
                    } else {
                        //該頁無內容，表示已完成
                        $state.complete();
                        this.fetchFinish = true;
                    }
                    this.clubCachedAt = +new Date();
                    this.isFetching = false;
                });
            }, 200);
        },
        changeFilter() {
            this.isFetching = true;
            this.fetchFinish = false;
            this.clubs = [];
            this.$nextTick(() => {
                // this.$refs.infiniteLoading.$emit('$InfiniteLoading:reset');
                // Reset InfiniteLoading by change identifier
                this.identifier++;
            });
        },
        fetchClubTypes: function () {
            //社團類型
            let club_type_list_url = Laravel.baseUrl + '/api/club-type-list';
            axios.post(club_type_list_url).then(response => {
                this.clubTypes = response.data;
            });
        },
        onSelectChange: function () {
            this.changeFilter();
        },
        onKeywordChange: function () {
            this.isTypingKeyword = true;
            this.delayFetch();
        },
        updateRandomSeed: function () {
            // 產生新的 Random Seed
            this.randomSeed = _.random(Number.MIN_SAFE_INTEGER, Number.MAX_SAFE_INTEGER)
            // 強制重新載入
            this.clubs = [];
            this.fetchFinish = false;
            this.identifier++;
        },
        delayFetch: _.debounce(function () {
            this.isTypingKeyword = false;
            this.changeFilter();
        }, 1000)
    },
    components: {
        InfiniteLoading,
    }
}
</script>
