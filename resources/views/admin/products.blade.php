@extends('admin.layout')

@section('title', '产品管理')

@section('head-assets')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('nav-sidebar')
    @component('admin.componentSidebar', ['navActive' => 'products'])
    @endcomponent
@endsection

@section('body-content')
          <h1 class="page-header">产品管理</h1>

          <h2 class="sub-header">产品列表</h2>
          <a href="/admin/products/form">新增产品</a>
          <nav class="navbar navbar-default">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul id="search-bar-template" style="display:none">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span data-selected="selected" data-xid="">--请选择--</span>
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu" data-type="dropdown-items">
                        <li><a href="#" data-xid="abc">name</a></li>
                      </ul>
                    </li>
                  </ul>

                  <ul id="search-bar" class="nav navbar-nav">
                  </ul>

                  <form id="search-form" class="navbar-form navbar-left" method="get" action="/admin/products">
                    <input type="hidden" name="brandId" />
                    <input type="hidden" name="categoryId" />
                    <button id="search-button" type="button" class="btn btn-default">查询</button>
                  </form>
                </div>
              </div>
          </nav>
          <div class="table-responsive">
            <!-- 列表 -->
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>品牌</th>
                  <th>类别</th>
                  <th>产品</th>
                  <th>产品说明</th>
                  <th>产品图片</th>
                  <th>产品状态</th>
                  <th>管理</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($products as $product)
                <tr>
                  <td>{{ object_get($brands->where('id', $product->brandId)->first(), 'name') }}</td>
                  <td>{{ object_get($categories->where('id', $categories->where('id', $product->categoryId)->first()->parentId)->first(), 'name') }} -> {{ object_get($categories->where('id', $product->categoryId)->first(), 'name') }}</td>
                  <td>{{ $product->name }}</td>
                  <td>{{ $product->briefDesc }}</td>
                  <td><img src="{{ $product->thumbnailUrl }}" width="60" height="60" /></td>
                  <td>{{ $product->statusDesc }}</td>
                  <td>
                    <a href="/admin/products/form?productId={{ $product->id }}">编辑</a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div>
          @component('admin.componentPagination', ['page' => $page, 'totalPages' => $totalPages])
          @endcomponent
            <form id="delForm" method="post">
                <input type="hidden" name="_method" value="delete" />
                {{ csrf_field() }}
            </form>
          </div>
@endsection

@section('body-assets')
<script type="application/javascript">
class DropdownWidget {
    /**
     * @param title dropdown title
     */
    constructor(name, id, data) {
        this._name = name;
        this._id = id;
        this._data = data;
        this._segment = null;
        this._selectedId = null;
    }

    show() {
        this._buildSegment();
        this._segment.appendTo('#search-bar');
        return this;
    }

    dom() {
        return this._segment;
    }

    remove() {
        this._segment.remove();
        return this;
    }

    getSelectedId() {
        return this._selectedId;
    }

    _buildSegment() {
        this._segment = $('#search-bar-template > li')
            .clone()
            .attr('data-name', this._name);
        var selected = this._segment.find('[data-selected="selected"]');
        var itemsContainer = this._segment.find('[data-type="dropdown-items"]');
        var itemTemplate = itemsContainer.find('li').first().clone();
        itemsContainer.empty();
        self = this;
        $.each(this._data, function (index, item) {
            var id = item[0];
            var name = item[1];
            itemTemplate
                .clone()
                .find('a').attr('data-xid', id).text(name)
                .end()
                .on('click', function () {
                    self._selectedId = id;
                    selected.attr('data-xid', id).text(name);                    
                })
                .appendTo(itemsContainer);

            if (self._id === id) {
                self._selectedId = id;
                selected.attr('data-xid', id).text(name);
            }
        });
    }
};

$(function () {
    var brandId = @if($brandId) '{{ $brandId }}' @else null @endif;
@if($categoryId && $categories->where('id', $categoryId)->first())    
    @if($categories->where('id', $categoryId)->first()->parentId)
    var topCategoryId = '{{ $categories->where('id', $categoryId)->first()->parentId }}';
    var subCategoryId = '{{ $categories->where('id', $categoryId)->first()->id }}';
    @else
    var topCategoryId = '{{ $categories->where('id', $categoryId)->first()->id }}';
    var subCategoryId = null;
    @endif
@else
    var topCategoryId = null;
    var subCategoryId = null;
@endif

    var brands = [
        [
            null, '--请选择--'
        ] @if($brands->count()) , @endif
@foreach ($brands as $brand)
        [ 
            '{{ $brand->id }}', '[{{ $brand->nameCapital }}] - {{ $brand->name }}'
        ] @if( ! $loop->last) , @endif
@endforeach
    ];

    var topCategories = [
        [
            null, '--请选择--'
        ] @if($brands->count()) , @endif
@foreach ($categories->where('level', 1) as $category)
        [
            '{{ $category->id }}', '{{ $category->name }}'
        ] @if( ! $loop->last) , @endif
@endforeach
    ];

    var subCategories = {
@foreach ($categories->where('level', 1) as $topCategory)
        '{{ $topCategory->id }}': [
            [
                null, '--请选择--'
            ] @if($brands->count()) , @endif
    @foreach ($categories->where('parentId', $topCategory->id) as $category)
            [
                '{{ $category->id }}', '{{ $category->name }}'
            ] @if( ! $loop->last) , @endif
    @endforeach
        ] @if( ! $loop->last) , @endif
@endforeach
    };

    var brandsDropdown = new DropdownWidget('brands', brandId, brands);
    var topCategoryDropdown = new DropdownWidget('top-categories', topCategoryId, topCategories);
    var subCategoryDropdown = null;
    brandsDropdown.show();
    topCategoryDropdown.show();
    if (topCategoryId || subCategoryId) {
        subCategoryDropdown = new DropdownWidget('sub-categories', subCategoryId, subCategories[topCategoryId]);
        subCategoryDropdown.show();
    }
    topCategoryDropdown.dom().find('[data-type="dropdown-items"] > li').on('click', function () {
        var parentId = $(this).find('a').attr('data-xid');
        if (parentId in subCategories) {
            if (subCategoryDropdown != null) {
                subCategoryDropdown.remove();
                subCategoryDropdown = null;
            }
            subCategoryDropdown = new DropdownWidget('sub-categories', null, subCategories[parentId]); 
            subCategoryDropdown.show();
        } else {
            if (subCategoryDropdown !== null) {
                subCategoryDropdown.remove();
                subCategoryDropdown = null;
            } 
        }
    });

    $('#search-button').on('click', function () {
        var brandId = $('li[data-name="brands"] span[data-selected="selected"]').attr('data-xid');
        var topCategoryId = $('li[data-name="top-categories"] span[data-selected="selected"]').attr('data-xid');
        var subCategoryId = $('li[data-name="sub-categories"] span[data-selected="selected"]').attr('data-xid');

        $('#search-form input[name="brandId"]').val(brandId);
        if (subCategoryDropdown && subCategoryId) {
            $('#search-form input[name="categoryId"]').val(subCategoryId);
        } else if (topCategoryId) {
            $('#search-form input[name="categoryId"]').val(topCategoryId);
        } else {
            $('#search-form input[name="categoryId"]').val(null);
        }

        $('#search-form').submit();
    });
});
</script>
@endsection
