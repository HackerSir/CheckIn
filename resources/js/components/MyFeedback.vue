<template>
    <div class="card mb-1">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row">
                <h4 class="card-title">給 <a :href="club_url" v-html="feedback.club.display_name"></a> 的回饋資料</h4>
                <div class="ml-md-auto">
                    <a :href="feedback_edit_url" class="btn btn-primary">
                        <i aria-hidden="true" class="fa fa-edit"></i> 編輯
                    </a>
                </div>
            </div>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.phone">{{ feedback.phone }}</p>
                    <p v-else class="text-muted">（未填寫）</p>
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.email">{{ feedback.email }}</p>
                    <p v-else class="text-muted">（未填寫）</p>
                </dd>

                <dt class="col-md-2">Facebook</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.email">{{ feedback.facebook }}</p>
                    <p v-else class="text-muted">（未填寫）</p>
                </dd>

                <dt class="col-md-2">LINE ID</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.line">{{ feedback.line }}</p>
                    <p v-else class="text-muted">（未填寫）</p>
                </dd>

                <dt class="col-md-2">給社團的意見</dt>
                <dd class="col-md-10">
                    <p v-if="feedback.message">{{ feedback.message }}</p>
                    <p v-else class="text-muted">（未填寫）</p>
                </dd>

                <dt v-if="feedback.custom_question" class="col-md-2">社團提問</dt>
                <dd v-if="feedback.custom_question" class="col-md-10">
                    <span class="badge badge-secondary">提問</span>
                    {{ feedback.custom_question }}<br/>
                    <span class="badge badge-secondary">回答</span>
                    <span v-if="feedback.answer_of_custom_question">{{ feedback.answer_of_custom_question }}</span>
                    <span v-else class="text-muted">（未填寫）</span>
                </dd>
            </dl>
            <div v-if="feedback.club.extra_info" class="alert alert-info">
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
