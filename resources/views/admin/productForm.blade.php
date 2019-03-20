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
<form id="product-form" class="form-horizontal" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="brand-name-capital" class="col-sm-2 control-label">品牌</label>
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-brand">@if ($product) [{{ $brands->where('id', $product->brandId)->first()->nameCapital }}]-{{ $brands->where('id', $product->brandId)->first()->name }} @else [{{ $brands->first()->nameCapital }}]-{{ $brands->first()->name }} @endif</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            @foreach ($brands as $brand)
            <li><a class="brand-item" data-id="{{ $brand->id }}" href="#">[{{ $brand->nameCapital }}]-{{ $brand->name }}</a></li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="brandId" value="@if ($product) {{ $brands->where('id', $product->brandId)->first()->id }} @else {{ $brands->first()->id }} @endif" />
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
        <label for="product-status" class="col-sm-2 control-label">状态</label>
        <div class="btn-group">
          <button id="product-status" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selected-status">@if ($product) {{ $product->statusDesc }} @else 已下架 @endif</span> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            @foreach ($productStatusMap as $status => $desc)
            <li><a class="status-item" data-status="{{ $status }}" href="#">{{ $desc }}</a></li>
            @endforeach
          </ul>
        </div>
        <input type="hidden" name="status" value="@if ($product) {{ $product->status }} @else -1 @endif" />
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">图片</label>
        <div class="col-sm-10 input-group">
            @if ($product)
            <img src="{{ $product->thumbnailUrl }}" width="100" height="100" />
            @endif
            <input type="file" name="thumbnail" class="form-content-file" accept="image/*" />
            <p />
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传产品图片规格为 102 * 93</p>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">说明书</label>
        <div class="col-sm-10 input-group">
            @if ($product && $product->docSpecificationUrl)
            <a href="{{ $product->docSpecificationUrl }}" target="_blank">说明书</a>
            @endif
            <input type="file" name="docSpecification" class="form-content-file" />
            <p />
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传文档为pdf, 大小限制为2M</p>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">文档</label>
        <div class="col-sm-10 input-group">
            @if ($product && $product->docUrl)
            <a href="{{ $product->docUrl }}" target="_blank">文档</a>
            @endif
            <input type="file" name="doc" class="form-content-file" />
            <p />
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传文档为pdf, 大小限制为2M</p>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">品牌介绍</label>
        <div class="col-sm-10 input-group">
            @if ($product && $product->docInstructionUrl)
            <a href="{{ $product->docInstructionUrl }}" target="_blank">品牌介绍</a>
            @endif
            <input type="file" name="docInstruction" class="form-content-file" />
            <p />
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传文档为pdf, 大小限制为2M</p>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">其它文档</label>
        <div class="col-sm-10 input-group">
            @if ($product && $product->docOtherUrl)
            <a href="{{ $product->docOtherUrl }}" target="_blank">其它文档</a>
            @endif
            <input type="file" name="docOther" class="form-content-file" />
            <p />
            <div class="alert alert-info col-sm-4">
                <p>Tips: 上传文档为pdf, 大小限制为2M</p>
            </div>
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
            <a href="/admin/products" class="btn btn-primary" type="button">返回</a>
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
@foreach ($categories->where('parentId', null) as $category)
        "{{ $category->id }}": [
    @foreach ($categories->where('parentId', $category->id) as $sub)
            {
                "id": "{{ $sub->id }}",
                "name": "{{ $sub->name }}"
            } @if ( ! $loop->last) , @endif
    @endforeach
        ] @if ( ! $loop->last) , @endif
@endforeach
    };

function init(selectedCategoryId, selectedSubCategoryId) {
    var selectedCategoryId = renderTopCategory(topCategories, selectedCategoryId);
    renderSubCategory(selectedCategoryId, categories, selectedSubCategoryId);
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
    $('#product-form input[name="categoryId"]').val(selectedCategory['id']);
}

$(document).ready(function () {
    @if ($product)
    init('{{ $categories->where('id', $product->categoryId)->first()->parentId }}', '{{ $product->categoryId }}');
    @else
    init(); 
    @endif
    $('.brand-item').on('click', function () {
        $('#selected-brand').text($(this).text().trim());
        $('#product-form input[name="brandId"]').val($(this).data('id'));
    });
    $('button.action-button').on('click', function () {
        $('#product-form').attr('action', $(this).data('action'));
        $('#product-form input[name="_method"]').val($(this).data('method'));
        if ($(this).data('action-name') === 'delete') {
            if ( ! confirm('确定要删除么')) {
                return;
            }
        }
        $('#product-form').submit();
    });
    $('.status-item').on('click', function () {
        $('#selected-status').text($(this).text().trim());
        $('#product-form input[name="status"]').val($(this).data('status'));
    });
});

</script>
@endsection
