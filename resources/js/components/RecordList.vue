<template>
    <div>
        <ul class="list-group">
            <li v-if="loading" class="list-group-item">
                <i class="fas fa-spinner fa-pulse mr-2"></i>讀取中……
            </li>
            <template v-else>
                <li v-for="record in records" class="list-group-item d-flex flex-column flex-md-row">
                    <div>
                        <h4 class="mb-1"><a :href="club_url(record.club_id)">{{ record.club }}</a>
                            <span v-html="record.club_type_tag"></span>
                            <span v-if="!record.is_counted" class='badge badge-secondary'>不列入集點</span>
                        </h4>
                        <div class="text-muted d-flex flex-wrap">
                            <div :title="$moment(record.created_at).format('YYYY-MM-DD HH:mm:ss')"
                                 class="d-inline-block mr-2" data-placement="right" data-toggle="tooltip">
                                <i class="fas fa-clock"></i>
                                {{ $moment(record.created_at).fromNow() }}
                            </div>
                            <div v-if="record.booth || record.booth_zone" class="d-inline-block">
                                <i class="fas fa-store"></i>
                                <span v-if="record.booth_zone" class="badge badge-secondary">{{
                                        record.booth_zone
                                    }}</span>
                                {{ record.booth }}
                            </div>
                        </div>
                    </div>
                    <div class="ml-md-auto align-self-center">
                        <a v-if="record.feedback_id !== null" :href="feedback_show_url(record.feedback_id)"
                           class="btn btn-success">
                            <i class="fa fa-search"></i> 檢視回饋資料
                        </a>
                        <a v-else :href="feedback_edit_url(record.club_id)" class="btn btn-primary">
                            <i class="fa fa-edit"></i> 按我完成集點
                        </a>
                    </div>
                </li>
                <li v-if="records.length === 0" class="list-group-item">
                    尚無打卡紀錄，快去打卡吧
                </li>
            </template>
        </ul>
        <!--  Alert Modal -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal"
                    @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div v-if="showAlertModal" id="alertModal" ref="modal" aria-hidden="true"
                 aria-labelledby="alertModalLabel" class="modal fade" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="alertModalLabel" class="modal-title">打卡成功</h5>
                            <button aria-label="Close" class="close" type="button" @click="onModalClosed">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="alertMessage">
                                於「{{ modalPayload.club_name }}」打卡成功
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" @click="onModalClosed">確認</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!-- Confirm Modal -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal"
                    @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div v-if="showConfirmModal" id="confirmModal" ref="modal" aria-hidden="true"
                 aria-labelledby="confirmModalLabel" class="modal fade" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <span id="confirmMessage">
                                即將於「{{ modalPayload.club_name }}」打卡<br/>
                                請填寫以下項目以完成打卡
                            </span>
                            <hr>
                            <div class="d-flex flex-column align-items-center">
                                <h4>加入社團意願</h4>
                                <div class="btn-group btn-group-toggle">
                                    <label :class="{ 'active': joinClubIntention === 2 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinClubIntention" :value="2" name="join_club_intention"
                                               required
                                               type="radio"> 參加
                                    </label>
                                    <label :class="{ 'active': joinClubIntention === 1 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinClubIntention" :value="1" name="join_club_intention"
                                               required
                                               type="radio"> 考慮中
                                    </label>
                                    <label :class="{ 'active': joinClubIntention === 0 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinClubIntention" :value="0" name="join_club_intention"
                                               required
                                               type="radio"> 不參加
                                    </label>
                                </div>
                                <h4>參與迎新茶會意願</h4>
                                <template v-if="modalPayload.tea_party.exists">
                                    <span>
                                        <i class="fas fa-clock mr-2"></i>{{
                                            $moment(modalPayload.tea_party.start_at).format('YYYY-MM-DD HH:mm')
                                        }}
                                    </span>
                                    <span>
                                        <i class="fas fa-map-marked-alt mr-2"></i>{{ modalPayload.tea_party.location }}
                                    </span>
                                </template>
                                <div class="btn-group btn-group-toggle">
                                    <label :class="{ 'active': joinTeaPartyIntention === 2 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinTeaPartyIntention" :value="2"
                                               name="join_tea_party_intention" required
                                               type="radio"> 參加
                                    </label>
                                    <label :class="{ 'active': joinTeaPartyIntention === 1 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinTeaPartyIntention" :value="1"
                                               name="join_tea_party_intention" required
                                               type="radio"> 考慮中
                                    </label>
                                    <label :class="{ 'active': joinTeaPartyIntention === 0 }"
                                           class="btn btn-outline-secondary">
                                        <input v-model="joinTeaPartyIntention" :value="0"
                                               name="join_tea_party_intention" required
                                               type="radio"> 不參加
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!--                            <button type="button" class="btn btn-secondary" @click="onModalClosed">稍後再說-->
                            <!--                            </button>-->
                            <button id="confirmButton" :disabled="!confirmButtonEnabled" class="btn btn-primary"
                                    type="button"
                                    @click="onModalConfirmed">
                                繼續
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <div ref="backdrop" class="modal-backdrop fade d-none"></div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            loading: true,
            records: [],
            showModal: false,
            modalPayload: {
                club_id: 0,
                club_name: '',
                ask_for_feedback: true,
                feedback_url: '',
                tea_party: {
                    exists: false,
                    start_at: '',
                    location: ''
                },
            },
            joinClubIntention: -1,
            joinTeaPartyIntention: -1,
            submitting: false
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
            this.modalPayload = payload;
            //重置選項
            this.joinClubIntention = -1;
            this.joinTeaPartyIntention = -1;
            this.submitting = false;
            //顯示 modal
            this.showModal = true;
        }).listen('CheckInAlert', (payload) => {
            if (payload.diff >= 60) {
                console.log('Skip "CheckInAlert" broadcast:', payload.message);
                return;
            }
            alert(payload.message);
        });
    },
    computed: {
        showAlertModal() {
            return this.showModal && !this.modalPayload.ask_for_feedback
        },
        showConfirmModal() {
            return this.showModal && this.modalPayload.ask_for_feedback
        },
        confirmButtonEnabled() {
            if (this.submitting) {
                return false;
            }
            return this.joinClubIntention >= 0 && this.joinTeaPartyIntention >= 0;
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
            this.submitting = true;
            //兩題都選擇不參加
            if (this.joinClubIntention === 0 && this.joinTeaPartyIntention === 0) {
                //記錄回饋資料
                let store_feedback_url = Laravel.baseUrl + '/api/store-feedback/' + this.modalPayload.club_id;
                axios.post(store_feedback_url, {
                    'join_club_intention': 0,
                    'join_tea_party_intention': 0
                }).then(response => {
                    let success = response.data.success;
                    if (success) {
                        toastr["success"]('參與意願已記錄');
                    } else {
                        toastr["error"]('發生錯誤，請嘗試自行點擊打卡紀錄中的填寫回饋資料');
                    }
                    this.submitting = false;
                    this.showModal = false;
                    //刷新打卡紀錄
                    this.fetch();
                });
                return;
            }
            //若兩題有一題選擇參加或考慮中
            //進行跳轉（含參加意願選項）
            let params = new URLSearchParams({
                join_club_intention: this.joinClubIntention,
                join_tea_party_intention: this.joinTeaPartyIntention
            });
            window.location.href = this.modalPayload.feedback_url + '?' + params;
        },
        startTransitionModal() {
            this.$refs.backdrop.classList.toggle("d-block");
            this.$refs.modal && this.$refs.modal.classList.toggle("d-block");
            $("body").toggleClass("modal-open");
        },
        endTransitionModal() {
            this.$refs.backdrop.classList.toggle("show");
            this.$refs.modal && this.$refs.modal.classList.toggle("show");
        }
    }
}
</script>
