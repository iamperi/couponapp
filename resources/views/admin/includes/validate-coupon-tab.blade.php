<div class="card">
    <div class="card-header">
        <label class="card-title">@lang('Validate coupon')</label>
    </div>

    <div class="card-body">
        <div class="flex flex-col justify-center items-center mt-4">
            <label class="text-4xl mb-8">@lang('Enter coupon code')</label>

            <input type="text"
                   id="validate_coupon"
                   class="textbox text-4xl px-8 py-4 text-center uppercase"
                   placeholder="XXXP34FT6"
                   @keyup="$event.target.value = $event.target.value.toUpperCase()"
                   @keyup.enter="validateCoupon()"
                   autofocus
                   maxlength="9"
            >
            <div id="feedback" class="alert hidden mt-6">
                <label></label>
            </div>
            <button class="btn mt-8 px-8 py-4 text-4xl" @click="validateCoupon()">@lang('Verify')</button>
        </div>
    </div>
</div>

@push('js')
<script>
    const couponCodeInput = document.querySelector('#validate_coupon');
    couponCodeInput.focus();

    function validateCoupon(e) {
        const code = couponCodeInput.value;
        axios.post('/admin/coupons/' + code + '/verify')
        .then(response => {
            const status = response.data.status;
            console.log(response.data)
            if(status == 'ok') {
                showFeedback('success', response.data.msg);
            } else {
                showFeedback('error', response.data.msg);
            }
        })
        .catch(error => {
            console.log(error.data)
            document.querySelector('#feedback_msg')
            showFeedback('Ooops... Parece que el código no es válido :(');
        });
    }

    function showFeedback(type, msg) {
        if(type == 'success') {
            successFeedback();
        } else {
            errorFeedback();
        }
        setFeedbackMsg(msg);
        document.querySelector('#feedback').style.display = 'block';
    }

    function successFeedback() {
        document.querySelector('#feedback').classList.remove('alert-error');
        document.querySelector('#feedback').classList.add('alert-success');
    }

    function errorFeedback() {
        document.querySelector('#feedback').classList.remove('alert-success');
        document.querySelector('#feedback').classList.add('alert-error');
    }

    function setFeedbackMsg(msg) {
        document.querySelector('#feedback label').innerHTML = msg;
    }
</script>
@endpush
