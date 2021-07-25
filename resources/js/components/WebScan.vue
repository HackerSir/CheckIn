<template>
    <div>
        <div :class="['alert', alertClass]" v-if="alertMessage">
            <ul class="my-0" style="padding-inline-start: 0">
                <li v-if="alertStudentName">學生：{{ alertStudentName }}</li>
                <li>{{ alertMessage }}</li>
            </ul>
        </div>
        <p>{{ message }}</p>
        <qrcode-stream @init="onInit" @decode="onDecode"></qrcode-stream>
        <!-- Confirm Modal -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal"
                    @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-if="showModal" id="confirmModal" tabindex="-1"
                 role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true" ref="modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">掃描條碼</h5>
                        </div>
                        <div class="modal-body text-center">
                            <p class="code" style="font-size: 3rem">{{ code }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="btnJustScan">僅掃描</button>
                            <button type="button" class="btn btn-primary" id="confirmButton" @click="btnScanAndView">
                                掃瞄並檢視
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
    export default {
        name: "WebScan",
        data() {
            return {
                code: 'XXXXXXXX',
                message: '啟動中...',
                showModal: false,
                alertLevel: 'info',
                alertStudentName: null,
                alertMessage: null
            }
        },
        mounted() {
            this.message = '等待掃描...';
        },
        computed: {
            alertClass() {
                return 'alert-' + this.alertLevel;
            }
        },
        methods: {
            async onInit(promise) {
                // show loading indicator

                try {
                    await promise

                    // successfully initialized
                } catch (error) {
                    let errorMessage = '發生錯誤： ';
                    if (error.name === 'NotAllowedError') {
                        // user denied camera access permisson
                        errorMessage += '無法取得權限';
                    } else if (error.name === 'NotFoundError') {
                        // no suitable camera device installed
                        errorMessage += '無法啟動相機鏡頭';
                    } else if (error.name === 'NotSupportedError') {
                        // page is not served over HTTPS (or localhost)
                        errorMessage += '非安全連線';
                    } else if (error.name === 'NotReadableError') {
                        // maybe camera is already in use
                        errorMessage += '相機鏡頭正被其他軟體佔用';
                    } else if (error.name === 'OverconstrainedError') {
                        // did you requested the front camera although there is none?
                        errorMessage += 'did you requested the front camera although there is none?';
                    } else if (error.name === 'StreamApiNotSupportedError') {
                        // browser seems to be lacking features
                        errorMessage += '瀏覽器不支援此功能'
                    }
                    this.message = errorMessage;
                } finally {
                    // hide loading indicator
                }
            },
            onDecode(decodedString) {
                this.message = '掃描結果： ' + decodedString;
                // 檢查是否為條碼
                let scanPattern = new UrlPattern(/\/qr\/(.*)$/, ['code']);
                let scanMatch = scanPattern.match(decodedString);
                if (scanMatch == null || scanMatch.code == null) {
                    // 非條碼
                    return;
                }
                this.code = scanMatch.code;
                // 顯示提示視窗
                this.showModal = true;
            },
            startTransitionModal() {
                this.$refs.backdrop.classList.toggle("d-block");
                this.$refs.modal && this.$refs.modal.classList.toggle("d-block");
                $("body").toggleClass("modal-open");
            },
            endTransitionModal() {
                this.$refs.backdrop.classList.toggle("show");
                this.$refs.modal && this.$refs.modal.classList.toggle("show");
            },
            btnJustScan() {
                // 僅掃描
                this.showModal = false;
                // 掃描流程
                let web_scan_api_url = Laravel.baseUrl + '/scan-api/' + this.code;
                axios.post(web_scan_api_url).then(response => {
                    let data = response.data;
                    this.alertLevel = data.level;
                    this.alertStudentName = data.student_name;
                    this.alertMessage = data.message;
                });
            },
            btnScanAndView() {
                // 掃描並檢視（直接跳轉至原掃描畫面）
                this.showModal = false;
                window.location.href = window.Laravel.baseUrl + '/qr/' + this.code + '?from=web-scan';
            }
        }
    }
</script>

<style scoped>

</style>
