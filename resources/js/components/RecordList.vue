<template>
    <div>
        <ul class="list-group">
            <li class="list-group-item" v-if="loading">
                <i class="fas fa-spinner fa-pulse mr-2"></i>讀取中……
            </li>
            <template v-else>
                <li class="list-group-item d-flex flex-column flex-md-row" v-for="record in records">
                    <div>
                        <h4 class="mb-1"><a :href="club_url(record.club_id)">{{ record.club }}</a>
                            <span v-html="record.club_type_tag"></span>
                            <span class='badge badge-secondary' v-if="!record.is_counted">不列入集點</span>
                        </h4>
                        <p>
                            <span :title="$moment(record.created_at).format('YYYY-MM-DD HH:mm:ss')"
                                  data-toggle="tooltip" data-placement="right">
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
            </template>
        </ul>
        <!--  Alert Modal -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal"
                    @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-if="showAlertModal" id="alertModal" tabindex="-1"
                 role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true" ref="modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="alertModalLabel">訊息</h5>
                            <button type="button" class="close" @click="onModalClosed" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="alertMessage">
                                於「{{ modalPayload.club_name }}」打卡成功
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="onModalClosed">確認</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!-- Confirm Modal -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal"
                    @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-if="showConfirmModal" id="confirmModal" tabindex="-1"
                 role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true" ref="modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">訊息</h5>
                            <button type="button" class="close" @click="onModalClosed" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="confirmMessage">
                                於「{{ modalPayload.club_name }}」打卡成功<br/>
                                是否願意留下回饋資料？
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="onModalClosed">稍後再說
                            </button>
                            <button type="button" class="btn btn-primary" id="confirmButton" @click="onModalConfirmed">
                                前往填寫
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <div class="modal-backdrop fade d-none" ref="backdrop"></div>
    </div>
</template>

<script>
    require('../bootstrap-echo-vue');

    export default {
        data: function () {
            return {
                loading: true,
                records: [],
                showModal: false,
                modalPayload: {
                    ask_for_feedback: true,
                    club_name: '',
                    feedback_url: ''
                },
            }
        },
        created() {
            this.fetch();
        },
        mounted() {
            // Listen for the 'CheckInSuccess' event in the 'student.NID' private channel
            this.$echo.private('student.' + window.Laravel.student).listen('CheckInSuccess', (payload) => {
                if (payload.diff >= 60) {
                    console.log('Skip "CheckInSuccess" broadcast:', payload.club_name);
                    return;
                }
                console.log(payload);
                this.modalPayload = payload;
                //顯示 modal
                this.showModal = true;
            });
        },
        computed: {
            showAlertModal() {
                return this.showModal && !this.modalPayload.ask_for_feedback
            },
            showConfirmModal() {
                return this.showModal && this.modalPayload.ask_for_feedback
            }
        },
        methods: {
            fetch() {
                this.loading = true;
                let my_record_list_url = Laravel.baseUrl + '/api/my-record-list';
                axios.post(my_record_list_url).then(response => {
                    this.records = response.data;
                    this.$nextTick(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                    this.loading = false;
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
            },
            onModalClosed() {
                this.showModal = false;
                //刷新打卡紀錄
                this.fetch();
            },
            onModalConfirmed() {
                if (this.modalPayload && this.modalPayload.feedback_url) {
                    window.location.href = this.modalPayload.feedback_url;
                }
            },
            startTransitionModal() {
                this.$refs.backdrop.classList.toggle("d-block");
                this.$refs.modal && this.$refs.modal.classList.toggle("d-block");
            },
            endTransitionModal() {
                this.$refs.backdrop.classList.toggle("show");
                this.$refs.modal && this.$refs.modal.classList.toggle("show");
            }
        }
    }
</script>
