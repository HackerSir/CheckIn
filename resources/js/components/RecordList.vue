<template>
    <ul class="list-group">
        <li class="list-group-item d-flex flex-column flex-md-row" v-for="record in records">
            <div>
                <h4 class="mb-1"><a :href="club_url(record.club_id)">{{ record.club }}</a>
                    <span v-html="record.club_type_tag"></span>
                    <span class='badge badge-secondary' v-if="!record.is_counted">不列入集點</span>
                </h4>
                <p>
                    <span :title="$moment(record.created_at).format('YYYY-MM-DD HH:mm:ss')" data-toggle="tooltip"
                          data-placement="right">
                        {{ $moment(record.created_at).fromNow() }}
                    </span>
                </p>
            </div>
            <div class="ml-md-auto align-self-center">
                <a :href="feedback_show_url(record.feedback_id)" class="btn btn-success"
                   v-if="record.feedback_id !== null">
                    <i class="fa fa-search"></i> 檢視回饋資料
                </a>
                <a :href="feedback_edit_url(record.club_id)" class="btn btn-primary" v-else>
                    <i class="fa fa-edit"></i> 填寫回饋資料
                </a>
            </div>
        </li>
        <li class="list-group-item" v-if="records.length === 0">
            尚無打卡紀錄，快去打卡吧
        </li>
    </ul>
</template>

<script>
    export default {
        data: function () {
            return {
                records: [],
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                let my_record_list_url = Laravel.baseUrl + '/api/my-record-list';
                axios.post(my_record_list_url).then(response => {
                    this.records = response.data;
                    this.$nextTick(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    })
                });
            },
            club_url: function (club_id) {
                return Laravel.baseUrl + '/clubs/' + club_id;
            },
            feedback_show_url: function (feedback_id) {
                return Laravel.baseUrl + '/feedback/' + feedback_id;
            },
            feedback_edit_url: function (club_id) {
                return Laravel.baseUrl + '/feedback/create/' + club_id;
            }
        }
    }
</script>
