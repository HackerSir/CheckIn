<template>
    <div class="card mb-1">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row">
                <h4 class="card-title">給 <a :href="club_url" v-html="feedback.club.display_name"></a> 的回饋資料</h4>
                <div class="ml-md-auto">
                    <a :href="feedback_edit_url" class="btn btn-primary">
                        <i class="fa fa-edit" aria-hidden="true"></i> 編輯
                    </a>
                </div>
            </div>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.phone">{{ feedback.phone }}</p>
                    <p class="text-muted" v-else>（未填寫）</p>
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.email">{{ feedback.email }}</p>
                    <p class="text-muted" v-else>（未填寫）</p>
                </dd>

                <dt class="col-md-2">Facebook</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.email">{{ feedback.facebook }}</p>
                    <p class="text-muted" v-else>（未填寫）</p>
                </dd>

                <dt class="col-md-2">LINE ID</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.email">{{ feedback.line }}</p>
                    <p class="text-muted" v-else>（未填寫）</p>
                </dd>

                <dt class="col-md-2">給社團的意見</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.message">{{ feedback.message }}</p>
                    <p class="text-muted" v-else>（未填寫）</p>
                </dd>
            </dl>
            <div class="alert alert-info" v-if="feedback.club.extra_info">
                <h5 class="text-center">此社團提供給填寫者的額外資訊</h5>
                <div v-html="feedback.club.extra_info"></div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'feedback'
        ],
        computed: {
            club_url: function () {
                return Laravel.baseUrl + '/clubs/' + this.feedback.club.id;
            },
            feedback_edit_url: function () {
                return Laravel.baseUrl + '/feedback/create/' + this.feedback.club.id;
            }
        }
    }
</script>
