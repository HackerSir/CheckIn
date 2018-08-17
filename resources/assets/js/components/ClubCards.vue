<template>
    <div>
        <div class="d-sm-flex">
            <div>
                類型
                <select id="type_select" class="custom-select" v-model="selectedClubType" @change="onSelectChange"
                        style="width: inherit">
                    <option :value="null">全部</option>
                    <option :value="id" v-for="(name, id) in clubTypes">{{ name }}</option>
                </select>
                <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#clubTypeDescription" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-question"></i>
                </button>
            </div>
            <div class="ml-auto mt-1 form-inline">
                <span v-html="searchIndicator"></span> 搜尋
                <input type="text" class="form-control" v-model="searchKeyword" @input="onKeywordChange">
            </div>
        </div>
        <div class="collapse" id="clubTypeDescription">
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
            <div class="col-12 col-lg-6 mt-1" v-for="club in clubs">
                <club-card :club="club"></club-card>
            </div>
            <div class="col-12 mt-1" v-if="(selectedClubType || searchKeyword) && clubs.length == 0">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <blockquote class="blockquote">
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
        data: function () {
            return {
                selectedClubType: null,
                searchKeyword: '',
                clubTypes: [],
                clubs: [],
                isTypingKeyword: false,
                isFetching: false
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
            }, 1000)
        }
    }
</script>
