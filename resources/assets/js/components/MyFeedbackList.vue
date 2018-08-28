<template>
    <div>
        <my-feedback :feedback="feedbackItem" v-for="(feedbackItem, index) in feedback" :key="index"></my-feedback>
        <infinite-loading @infinite="infiniteHandler" ref="infiniteLoading">
            <div slot="no-results">
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 尚未填寫任何回饋資料
                </div>
            </div>
            <span slot="no-more"></span>
            <span slot="spinner">
                <i class="fa fa-spinner fa-pulse fa-fw fa-3x mt-3" aria-hidden="true"></i>
            </span>
        </infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import MyFeedback from "./MyFeedback";

    export default {
        data: function () {
            return {
                feedback: [],
                itemPerPage: 10
            }
        },
        methods: {
            infiniteHandler($state) {
                setTimeout(() => {
                    let nextPage = Math.ceil(this.feedback.length / this.itemPerPage) + 1;
                    //社團清單
                    let my_feedback_list_url = Laravel.baseUrl + '/api/my-feedback-list?page=' + nextPage;
                    axios.post(my_feedback_list_url).then(response => {
                        let responseBody = response.data;
                        let feedbackData = responseBody.data;
                        if (feedbackData.length) {
                            this.feedback = this.feedback.concat(feedbackData);
                            $state.loaded();
                            if (responseBody.current_page >= responseBody.last_page) {
                                //沒下一頁
                                $state.complete();
                            }
                        } else {
                            //該頁無內容，表示已完成
                            $state.complete();
                        }
                    });
                }, 200);
            }
        },
        components: {
            MyFeedback,
            InfiniteLoading,
        }
    }
</script>
