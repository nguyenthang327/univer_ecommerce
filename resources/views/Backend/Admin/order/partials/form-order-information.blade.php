<form method="POST" enctype="multipart/form-data" action="{{ $action }}">
    @if(isset($method))
        @method($method)
    @endif
    @csrf
    <div class="row">
        <div class="col-xl-9 theia-content">
            <div class="card mb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="">{{trans('language.customer_id')}}</label>
                                <input type="text" class="form-control" disabled
                                       value="{{isset($order->customer_id) ? $order->customer_id : '' }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{trans('language.customer_account_name')}}</label>
                                <input type="text" class="form-control" disabled
                                       value="{{isset($order->customer_account_name) ? $order->customer_account_name : '' }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{trans('language.consignee_name')}}</label>
                                <input type="text" class="form-control" disabled
                                       value="{{isset($order->full_name) ? $order->full_name : '' }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">{{trans('language.consignee_phone')}}</label>
                                <input type="text" class="form-control" disabled
                                       value="{{isset($order->phone) ? $order->phone : '' }}" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">{{trans('language.address')}}</label>
                                <textarea disabled style="width:100%">{{isset($order->full_address) ? $order->full_address : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">{{ trans('language.payment_method') }}</label>
                                <input type="text" class="form-control" disabled
                                       value="{{isset($order->payment_method) ? trans('language.order.payment_method')[$order->payment_method] : '' }}" >
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">{{ trans('language.status') }} <span class="text-red"></span></label>
                                <select class="select2-base " name="status"  style="width: 100%" required>
                                    @php
                                        $chooseStatus = old('status') ? old('status') : (isset($order->status)?$order->status:'');
                                    @endphp
                                    @if($order->payment_method == \App\Models\Order::PAYMENT_CASH)
                                        @foreach (\App\Models\Order::STATUS_GROUP_0 as $value)
                                            <option value="{{ $value }}" {{ ($value == $chooseStatus )?'selected':'' }}>{{trans('language.order.status')[$value]}}</option>
                                        @endforeach
                                    @else
                                        @foreach (\App\Models\Order::STATUS_GROUP_1 as $value)
                                            <option value="{{ $value }}" {{ ($value == $chooseStatus )?'selected':'' }}>{{trans('language.order.status')[$value]}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @include('backend.admin.order.partials.table-list-item', ['order' => $order])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 theia-sidebar">
            <div class="card">
                <div class="card-body align-items-start flex-wrap">
                    <button type="submit" class="btn btn-primary mr-2 my-1"><i class="far fa-save"></i> {{trans('language.save')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>