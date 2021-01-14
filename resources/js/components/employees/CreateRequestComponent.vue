<template>
    <div class="create-request-container">
        <h4>New Request</h4>
        <div class="row form-create">
            <form @submit.prevent="onSubmit" class="col-md-5">
                <div class="form-group">
                    <label for="content">Nội dung (Lý do xin nghỉ)</label>
                    <textarea name="content" v-model="contentRequest" id="content" rows="6" class="form-control" :class="{'error-input': $v.contentRequest.$error }" style="resize: vertical"></textarea>
                    <span v-if="!$v.contentRequest.required && $v.contentRequest.$dirty" class="text-danger error">Content is required!</span>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="start-at">Start at</label>
                        <datetime format="YYYY-MM-DD H:i" v-model="startAt" type="text" :class="{ 'error-input': $v.startAt.$error }" :disabledDates="disabledDates" id="start-at" name="start_at"></datetime>
                        <span v-if="!$v.startAt.required && $v.startAt.$dirty" class="text-danger error">Start At is required!</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end-at">End at</label>
                        <datetime format="YYYY-MM-DD H:i" v-model="endAt" type="text" :class="{ 'error-input': $v.endAt.$error }" :disabledDates="disabledDates" id="end-at" name="end_at"></datetime>
                        <span v-if="!$v.endAt.required && $v.endAt.$dirty" class="text-danger error">End At is required!</span>
                    </div>
                </div>
                <input type="hidden" name="employee_id" :value="$attrs.employeeid">
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { required, alphaNum } from 'vuelidate/lib/validators'
import datetime from 'vuejs-datetimepicker'

export default {
    name: "CreateRequestComponent",
    data: () => ({
        contentRequest: '',
        startAt: '',
        endAt: '',
        disabledDates: {
            to: new Date(Date.now() - 8640000)
        }
    }),
    validations: {
        contentRequest: {
            required
        },
        startAt: {
            required
        },
        endAt: {
            required
        }
    },
    methods: {
        onSubmit() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                console.log(`Content: ${this.contentRequest}, Start at: ${this.startAt}, End at: ${this.endAt}`)
            } else {
                $('body div.wrapper').before('<div class="loader loader-border is-active" data-text="Creating a new request..." data-blink></div>');
                const uri = `http://localhost:9999/api/employee/requests/create`;
                this.axios.post(uri, {
                    content: this.contentRequest,
                    startAt: this.startAt,
                    endAt: this.endAt,
                    employee: this.$attrs.employee,
                    employeeOfDepartment: this.$attrs.employeeofdepartment,
                    manager: this.$attrs.manager
                }).then(response => {
                    $('body').remove('div.loader')
                    window.location = `http://localhost:9999/employee/requests`
                });
            }
        }
    },
    components: {
        datetime
    }
}
</script>

<style scoped>
.valid__observer, .valid__provider {
    width: 100%;
}
.error-input {
    border: 1px solid #c30000;
}
.error {
    font-weight: 700;
}
</style>
