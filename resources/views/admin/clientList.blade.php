@extends('admin.layout')

@section('title', '软件列表')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('body-content')
          <h1 class="page-header">在线授权信息</h1>

          <h2 class="sub-header">软件列表</h2>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>软件号</th>
                  <th>MAC</th>
                  <th>硬盘码</th>
                  <th>客户名</th>
                  <th>授权截止日</th>
                  <th>状态</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($clients as $client)
                <tr>
                  <td><a href="/admin/clients/{{ $client->id }}">{{ $client->serialNo }}</a></td>
                  <td>
                    @if($client->macAddr)
                        {{ $client->macAddr }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($client->diskSerialNo)
                        {{ $client->diskSerialNo }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($client->clientName)
                        {{ $client->clientName }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($client->authEndDate)
                        {{ $client->authEndDate->format('Y-m-d') }}
                    @else
                        -
                    @endif
                  </td>
                  <td>{{ $client->statusDesc }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent
@endsection
