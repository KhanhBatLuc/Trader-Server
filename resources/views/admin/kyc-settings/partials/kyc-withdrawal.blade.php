<div class="user-management pt-4">
    <div class="row">
        <div class="col-12">
            <div class="profile-info-form">
                <form action="{{route('kycWithdrawalSetting')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mt-20">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label>{{ __('KYC enable for Withdrawal') }}</label>
                                    @php
                                        $kyc_withdrawal_status = settings('kyc_withdrawal_setting_status');
                                        $kyc_withdrawal_setting_list = json_decode(settings('kyc_withdrawal_setting_list'));
                                    @endphp
                                    <select name="kyc_withdrawal_setting_status" id="" class="selectpicker" title="{{ __('select option') }}" data-live-search="true" data-width="100%" data-style="btn-info" data-actions-box="true" data-selected-text-format="count > 4">
                                            <option value="1" {{isset($kyc_withdrawal_status)?$kyc_withdrawal_status=='1'?'selected':'':''}} >{{__('Yes')}}</option>
                                            <option value="0" {{isset($kyc_withdrawal_status)?$kyc_withdrawal_status=='0'?'selected':'':''}}>{{__('No')}}</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label>{{ __('KYC list') }} </label>
                                    <select name="kyc_withdrawal_setting_list[]" id="" class="selectpicker" title="{{ __('KYC list') }}" data-live-search="true" data-width="100%" data-style="btn-info" data-actions-box="true" data-selected-text-format="count > 4" multiple>
                                        @if($kyc_active_list)
                                            @foreach($kyc_active_list as $kyc)
                                                <option value="{{ $kyc->id }}" {{isset($kyc_withdrawal_setting_list)?(in_array($kyc->id,$kyc_withdrawal_setting_list)?'selected':''):''}} >{{ $kyc->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-6">
                                    <button type="submit" class="button-primary theme-btn">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>