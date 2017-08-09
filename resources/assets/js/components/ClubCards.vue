<template>
    <div>
        類型
        <select id="type_select" class="custom-select" v-model="selectedClubType">
            <option value="0">全部</option>
            <option :value="id" v-for="(name, id) in clubTypes">{{ name }}</option>
        </select>
        selected: {{ selectedClubType }}
        <div class="float-sm-right mt-1">
            搜尋
            <input type="text" v-model="searchKeyword">
            searchKeyword: {{ searchKeyword }}
        </div>
        <div class="row mt-1">
            <div class="col-12 col-lg-6 mt-1" v-for="club in clubs">
                <club-card :club="club"></club-card>
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
                selectedClubType: 0,
                searchKeyword: '',
                clubTypes: [],
                clubs: [],
            }
        },
        methods: {
            fetch: function () {
                let self = this;
                let club_type_list_url = Laravel.baseUrl + '/api/club-type-list';
                axios.post(club_type_list_url).then(function (response) {
                    self.clubTypes = response.data;
                });
                let club_list_url = Laravel.baseUrl + '/api/club-list';
                axios.post(club_list_url).then(function (response) {
                    self.clubs = response.data;
                });
            },
        }
    }
</script>
