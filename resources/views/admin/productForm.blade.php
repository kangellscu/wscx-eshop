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
    @if ($product)
        编辑产品
    @else
        新增产品
    @endif
</h1>
<form class="form-horizontal" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="brand-name-capital" class="col-sm-2 control-label">品牌</label>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-brand">@if ($product) [{{ $brands->where('id', $product->brandId)->first()->nameCapital }}]-{{ $brands->where('id', $product->brandId)->first()->name }} @else [{{ $brands->first()->nameCapital }}]-{{ $brands->first()->name }} @endif</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            @foreach ($brands as $brand)
            <li><a class="brand-item" href="#">[{{ $brand->nameCapital }}]-{{ $brand->name }}</a></li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="brandId" value="@if ($product) {{ $brands->where('id', $product->brandId)->first()->id }} @else $brands->first()->id @endif" />
    </div>
    <div class="form-group">
        <label for="category-top" class="col-sm-2 control-label">类别</label>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-topcategory">--</span>
            <span class="caret"></span>
          </button>
          <ul id="top-category-list" class="dropdown-menu">
          </ul>
        </div>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-subcategory">--</span>
            <span class="caret"></span>
          </button>
          <ul id="sub-category-list" class="dropdown-menu">
          </ul>
        </div>
        <input type="hidden" name="categoryId" value="" />
    </div>
    <div class="form-group">
        <label for="product-name" class="col-sm-2 control-label">产品名字</label>
        <div class="col-sm-4 input-group">
            <input type="text" class="form-control" id="product-name" name="name" value="@if ($product) {{ $product->name }} @endif" />
        </div>
    </div>
    <div class="form-group">
        <label for="product-brief" class="col-sm-2 control-label">产品说明</label>
        <div class="col-sm-4 input-group">
            <textarea class="form-control" id="product-brief" name="briefDesc">
            @if ($product) {{ object_get($product, 'briefDesc', '') }} @endif
            </textarea> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">图片</label>
        <div class="col-sm-10 input-group">
            @if ($product)
            <img src="{{ $product->thumbnailUrl }}" width="100" height="100" />
            @endif
            <input type="file" name="thumbnail" class="form-content-file" accept="image/*" />
        </div>
    </div>
    {{ csrf_field() }}
    {{ method_field('post') }}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          @if ($product)
            <button class="btn btn-primary action-button" type="button"
                data-action="/admin/products/{{ $product->id }}"
                data-method="post"
                data-action-name="edit">编辑</button>
            <button class="btn btn-danger action-button" type="button"
                data-action="/admin/products/{{ $product->id }}"
                data-method="delete"
                data-action-name="delete">删除</button>
          @else
            <button class="btn btn-primary action-button" type="button"
                data-action="/admin/products"
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

    var topCategories = [
@foreach ($categories->where('parentId', null) as $category)
        {
            "id": "{{ $category->id }}",
            "name": "{{ $category->name }}"
        } @if ( ! $loop->last) , @endif
@endforeach
    ];

    var categories = {
@foreach ($categories as $category)
        "{{ $category->id }}": [
    @foreach ($category->subs as $sub)
            {
                "id": "{{ $sub->id }}",
                "name": "{{ $sub->name }}"
            } @if ( ! $loop->last) , @endif
    @endforeach
        ] @if ( ! $loop->last) , @endif
@endforeach
    };

function init() {
    var selectedCategoryId = renderTopCategory(topCategories);
    renderSubCategory(selectedCategoryId, categories);
}

function renderTopCategory(topCategories, selectedCategoryId) {
    $('#top-category-list').empty();
    var itemHtmlList = [];
    $.each(topCategories, function (i, category) {
        itemHtmlList.push('<li><a class="top-category-item" data-id="' + category['id'] + '" href="#">' + category['name'] + '</a></li>');
    });

    var itemHtmls = itemHtmlList.join('');

    $('#top-category-list').append(itemHtmls);
    $('.top-category-item').on('click', function () {
        var selectedId = $(this).data('id');
        renderTopCategory(topCategories, selectedId);
        renderSubCategory(selectedId, categories);
    });

    var selectedCategory = null;
    $.each(topCategories, function (i, category) {
        if ( ! selectedCategoryId || category['id'] == selectedCategoryId) {
            selectedCategory = category;
            return false;
        }
    });
    $('#selected-topcategory').text(selectedCategory['name']);

    return selectedCategory['id'];
}

function renderSubCategory(topCategoryId, categories, selectedSubCategoryId) {
    $('#sub-category-list').empty();
    var subCategories = categories[topCategoryId];
    var itemHtmlList = [];
    $.each(subCategories, function (i, category) {
        itemHtmlList.push('<li><a class="category-item" data-id="' + category['id'] + '" href="#">' + category['name'] + '</a></li>');
    });

    var itemHtmls = itemHtmlList.join('');

    $('#sub-category-list').append(itemHtmls);
    $('.category-item').on('click', function () {
        var selectedId = $(this).data('id');
        renderSubCategory(topCategoryId, categories, selectedId);
    });

    var selectedCategory = null;
    $.each(subCategories, function (i, category) {
        if ( ! selectedSubCategoryId || category['id'] == selectedSubCategoryId) {
            selectedCategory = category;
            return false;
        }
    });
    $('#selected-subcategory').text(selectedCategory['name']);
}

$(document).ready(function () {
    init();
});



$('.capital-item').on('click', function () {
    var capital = $(this).text().trim();
    $('#selected-capital').text(capital);
    $('form input[name="nameCapital"]').val(capital);
});
</script>
@endsection
