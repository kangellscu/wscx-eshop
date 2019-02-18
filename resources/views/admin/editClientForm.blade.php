@extends('admin.layout')

@section('title', '软件详情')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('body-content')

    @component('admin.componentAlert')
    @endcomponent

<h1 class="page-header">软件信息</h1>
<form class="form-horizontal" method="post" action="/admin/clients/{{ $client->id }}">
    <div class="form-group">
        <label for="serialno" class="col-sm-2 control-label">软件号</label>
        <div class="col-sm-10">
            <p class="form-control-static">{{ $client->serialNo }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="macaddr" class="col-sm-2 control-label">MAC</label>
        <div class="col-sm-10">
            <p class="form-control-static">{{ object_get($client, 'macAddr', '-') }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="disk-serialno" class="col-sm-2 control-label">硬盘码</label>
        <div class="col-sm-10">
            <p class="form-control-static">{{ object_get($client, 'diskSerialNo', '-') }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="disk-serialno" class="col-sm-2 control-label">授权截止时间</label>
        <div class="col-sm-10">
            <p class="form-control-static">
    @if ($client->authEndDate)
                {{ $client->authEndDate->format('Y-m-d') }}
    @else
                -
    @endif
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="disk-serialno" class="col-sm-2 control-label">状态</label>
        <div class="col-sm-10">
            <p class="form-control-static">{{ $client->statusDesc }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="client-name" class="col-sm-2 control-label">客户名</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="client-name" name="clientName" value="{{ object_get($client, 'clientName', '') }}" />
        </div>
    </div>
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">确定</button>
            <a href="/admin/clients" class="btn btn-primary" type="button">取消</a>
        </div>
    </div>
</form>

{{-- Auth form --}}
<h1 class="page-header">软件授权</h1>
<form class="form-horizontal" method="post" action="/admin/clients/{{ $client->id }}/authorization">
    <div class="form-group">
        <label for="dtp_input2" class="col-sm-2 control-label">授权截止日期</label>
        <div class="input-group date form_date col-sm-3" data-date="" data-date-format="dd MM yyyy" data-link-field="auth-enddate" data-link-format="yyyy-mm-dd">
            <input type="text" class="form-control" id="auth-deadline" readonly/>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
        <input type="hidden" id="auth-enddate" name="authEndDate" value="" />
    </div>
    <div class="form-group">
        <label for="auth-comment" class="col-sm-2 control-label">备注</label>
        <div class="col-sm-4 input-group">
            <textarea class="form-control" id="auth-comment" name="comment"></textarea> 
        </div>
    </div>
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">确认</button>
        </div>
    </div>
</form>

{{-- Auth history --}}
<h1 class="page-header">授权历史</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>授权时间</th>
          <th>授权截止日</th>
          <th>备注</th>
        </tr>
      </thead>
      <tbody> 
    @foreach ($histories->histories as $authItem)
        <tr>
          <th>{{ $authItem->createdAt->format('Y-m-d H:i:s') }}</th>
          <th>{{ $authItem->authEndDate->format('Y-m-d') }}</th>
          <th>{{ $authItem->comment ?: '-' }}</th>
        </tr>
    @endforeach
      </tbody>
    </table>
</div>
@component('admin.componentPagination', ['page' => $page, 'totalPages' => $histories->totalPages])
@endcomponent
@endsection

@section('body-assets')
<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="application/javascript">
    $('.form_date').datetimepicker({
        format: "yyyy-mm-dd",
        language: "zh-CN",
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
</script>
@endsection
