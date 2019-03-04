@extends('admin.layout')

@section('title', '用户评论')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'userComments'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">用户留言</h1>

          <h2 class="sub-header">留言列表</h2>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>用户姓名</th>
                  <th>用户电话</th>
                  <th>用户邮箱</th>
                  <th>留言时间</th>
                  <th>留言内容</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($comments as $comment)
                <tr>
                  <td>{{ $comment->name }}</td>
                  <td>
                    @if($comment->phone)
                        {{ $comment->phone }}
                    @else
                        -
                    @endif
                  </td>
                  <td>
                    @if($comment->email)
                        {{ $comment->email }}
                    @else
                        -
                    @endif
                  </td>
                  <td>{{ $comment->createdAt->format('Y-m-d H:i:s') }}</td>
                  <td>{{ $comment->comment }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent
@endsection
