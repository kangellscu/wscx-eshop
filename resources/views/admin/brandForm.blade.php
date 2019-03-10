@extends('admin.layout')

@section('title', '产品管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('body-content')

    @component('admin.componentAlert')
    @endcomponent

<h1 class="page-header">
    @if ($brand)
        编辑品牌
    @else
        新增品牌
    @endif
</h1>
<form class="form-horizontal" method="post">

    <div class="form-group">
        <label for="brand-name-capital" class="col-sm-2 control-label">首字母</label>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-capital">@if ($brand) {{ $brand->nameCapital }} @else 'A' @endif</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            @foreach (range('A', 'Z') as $capital)
            <li><a class="capital-item" href="#">{{ $capital }}</a></li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="nameCapital" value="@if ($brand) {{ $brand->nameCapital }} @endif" />
    </div>
    <div class="form-group">
        <label for="brand-name" class="col-sm-2 control-label">品牌名字</label>
        <div class="col-sm-4 input-group">
            <input type="text" class="form-control" id="brand-name" name="name" value="@if ($brand) {{ $brand->name }} @endif" />
        </div>
    </div>
    <div class="form-group">
        <label for="brand-story" class="col-sm-2 control-label">品牌故事</label>
        <div class="col-sm-4 input-group">
            <textarea class="form-control" id="brand-story" name="story">
            @if ($brand) {{ object_get($brand, 'story', '') }} @endif
            </textarea> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">logo</label>
        <div class="col-sm-10 input-group">
            @if ($brand)
            <img src="{{ $brand->logoUrl }}" width="60" height="60" />
            @endif
            <input type="file" name="logo" class="form-content-file" accept="image/*" />
        </div>
    </div>
    {{ csrf_field() }}
    {{ method_field('post') }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          @if ($brand)
            <button class="btn btn-primary action-button" type="button"
                data-action="/admin/products/brands/{{ $brand->id }}"
                data-method="post"
                data-action-name="edit">编辑</button>
            <button class="btn btn-danger action-button" type="button"
                data-action="/admin/products/brands/{{ $brand->id }}"
                data-method="delete"
                data-action-name="delete">删除</button>
          @else
            <button class="btn btn-primary action-button" type="button"
                data-action="/admin/products/brands"
                data-method="put"
                data-action-name="add"->新增</button>
          @endif
            <a href="{{ URL::previous() }}" class="btn btn-primary" type="button">返回</a>
        </div>
    </div>
</form>

@endsection

@section('body-assets')
<script type="application/javascript">
$('.action-button').on('click', function () {
    $('form').attr('action', $(this).data('action'));
    $('form input[name="_method"]').val($(this).data('method'));
    if ($(this).data('action-name') == 'delete') {
        if ( ! confirm('确定要删除么')) {
            return;
        }
    }

    $('form').submit();
});
$('.capital-item').on('click', function () {
    var capital = $(this).text().trim();
    $('#selected-capital').text(capital);
    $('form input[name="nameCapital"]').val(capital);
});
</script>
@endsection
