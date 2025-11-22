@extends("admin.layout")

@section("content")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <div class="col pb-3">
                        <a href="" class="text-decoration-none">
                            <button type="button" class="btn btn-outline-info px-5 radius-30">View Product List</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-xl-12 mx-auto">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="card border-top border-0 border-4 border-info">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="card-title d-flex align-items-center">
                                <div>
                                </div>
                                <h5 class="mb-0 text-info">Add Product</h5>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" id="inputEnterYourName" value="{{ $data->name }}" placeholder="Enter Product Name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Slug</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="slug" id="inputEnterYourName" value="{{ $data->slug }}" placeholder="Enter Product Slug">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="image" id="inputEnterYourName" value="" placeholder="Enter Product Image">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Item Code</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="item_code" id="inputEnterYourName" value="{{ $data->item_code }}" placeholder="Enter Product Item Code">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Keywords</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="keywords" id="inputEnterYourName" value="{{ $data->keywords }}" placeholder="Enter Product Keywords">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Category</label>
                                <div class="col-sm-9">
                                    <select name="category_id" class="form-control" id="category">
                                        <option value="" class="">Select Category</option>
                                        @foreach ($category as $catList)
                                           <option value="{{ $catList->id }}" class="">{{ $catList->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                    <label for="attribute_id" class="col-sm-3 col-form-label">Attribute:</label>
                                    <div class="col-sm-9">
                                        <span class="multiAttr">

                                        </span>
                                    </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Brand</label>
                                <div class="col-sm-9">
                                    <select name="brand_id" class="form-control" id="">
                                        <option value="" class="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                           <option value="{{ $brand->id }}" class="">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Tax</label>
                                <div class="col-sm-9">
                                    <select name="tax_id" class="form-control" id="">
                                        <option value="" class="">Select Tax</option>
                                        @foreach ($tax as $taxList)
                                           <option value="{{ $taxList->id }}" class="">{{ $taxList->text }}%</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Attributes</label>
                                <div class="col-sm-4">
                                    <button type="button" id="addAttribute" class="btn btn-info w-100">Add Attribute</button>
                                </div>
                                <div class="" id="addAttributeContent">
                                    <div class="attribute-item mt-4">
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="d-flex justify-content-end mb-2">
                                                    <button type="button" class="btn btn-danger btn-sm removeAttribute">
                                                        Remove Attribute</button>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-3 mb-3">
                                                        <select name="color[]" class="form-control" id="">
                                                            @foreach ($color as $colorList)
                                                               <option value="{{ $colorList->id }}" style="background-color:{{ $colorList->value }};color: #fff;" class="box_color">{{ $colorList->color }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <select name="size[]" class="form-control" id="">
                                                            @foreach ($size as $sizeList)
                                                               <option value="{{ $sizeList->id }}" class="box_color">{{ $sizeList->size }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="sku[]" class="form-control" placeholder="Enter SKU" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="mrp[]" class="form-control" placeholder="Enter MRP" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="price[]" class="form-control" placeholder="Enter Price" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="length[]" class="form-control" placeholder="Enter Length" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="breadth[]" class="form-control" placeholder="Enter Breadth" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="height[]" class="form-control" placeholder="Enter Height" id="" />
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <input type="text" name="weight[]" class="form-control" placeholder="Enter Weight" id="" />
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Images</label>
                                                        <div class="col-sm-9">
                                                            <div class="mb-3">
                                                                <button type="button" class="btn btn-info add-image">Add Image</button>
                                                            </div>
                                                            <div class="row add-image-multiple-input">
                                                                <div class="col-sm-6 mb-3 image-input-wrapper">
                                                                    <div class="d-flex align-items-center">
                                                                        <input type="file" name="attr_image[]" class="form-control" placeholder="Enter Product Image">
                                                                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-image-input"><i class='bx bx-trash'></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea id="desc" name="mytextarea">{{ $data->description }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-info px-5">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')

@php
    $colorOptions = $color->map(function ($c) {
        return [
            'id'    => $c->id,
            'value' => $c->value,
            'label' => $c->color,
        ];
    });

    $sizeOptions = $size->map(function ($s) {
        return [
            'id'    => $s->id,
            'label' => $s->size,
        ];
    });
@endphp

<script>

    // Handle Add Attribute button click
    $(document).on('click', '#addAttribute', function () {

        const colors = @json($colorOptions);
        const sizes  = @json($sizeOptions);

        const colorSelect = colors.map(c =>
            `<option value="${c.id}" style="background-color:${c.value};color:#fff">${c.label}</option>`
        ).join('');

        const sizeSelect = sizes.map(s =>
            `<option value="${s.id}">${s.label}</option>`
        ).join('');

        const html = `
            <div class="attribute-item mt-4">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn btn-danger btn-sm removeAttribute">
                                                        Remove Attribute</button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3 mb-3">
                                <select name="color[]" class="form-control">
                                    ${colorSelect}
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <select name="size[]" class="form-control">
                                    ${sizeSelect}
                                </select>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="sku[]" class="form-control" placeholder="Enter SKU" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="mrp[]" class="form-control" placeholder="Enter MRP" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="price[]" class="form-control" placeholder="Enter Price" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="length[]" class="form-control" placeholder="Enter Length" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="breadth[]" class="form-control" placeholder="Enter Breadth" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="height[]" class="form-control" placeholder="Enter Height" />
                            </div>
                            <div class="col-sm-3 mb-3">
                                <input type="text" name="weight[]" class="form-control" placeholder="Enter Weight" />
                            </div>
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Images</label>
                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-info add-image">Add Image</button>
                                    </div>
                                    <div class="row add-image-multiple-input">
                                        <div class="col-sm-6 mb-3 image-input-wrapper">
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="attr_image[]" class="form-control" placeholder="Enter Product Image">
                                                <button type="button" class="btn btn-danger btn-sm ms-2 remove-image-input"><i class='bx bx-trash'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#addAttributeContent').append(html);
    });

    // Handle Remove Attribute button click
    $(document).on('click', '.removeAttribute', function () {
        $(this).closest('.attribute-item').remove();
    });

    // Handle Add Image button click - append new image input
    $(document).on('click', '.add-image', function () {
        const imageInputHtml = `
            <div class="col-sm-6 mb-3 image-input-wrapper">
                <div class="d-flex align-items-center">
                    <input type="file" name="attr_image[]" class="form-control" placeholder="Enter Product Image">
                    <button type="button" class="btn btn-danger btn-sm ms-2 remove-image-input"><i class='bx bx-trash'></i></button>
                </div>
            </div>
        `;
        // Find the closest parent row that contains the Product Images section, then find the add-image-multiple-input container
        $(this).closest('.row.mb-3').find('.add-image-multiple-input').append(imageInputHtml);
    });

    // Handle Remove Image Input button click
    $(document).on('click', '.remove-image-input', function () {
        $(this).closest('.image-input-wrapper').remove();
    });

    $("#category").on('change', function(e){

        let cat = $("#category").val();

        if(!cat) {
            $(".multiAttr").html('');
            return;
        }

        var html = '<select id="attribute_id" class="form-control" name="attribute_id[]" multiple>';

        var url = "{{ route('product.getAttributes') }}";

       $.ajax({
         url: url,
         data: { cat: cat },
         headers: {
            'X-CSRF-TOKEN' : '{{ csrf_token() }}'
         },
         type: 'POST',
         success: function(result){
            if(result.status == 'Success'){
                // console.log(result);
                if(result.data && result.data.length > 0){

                  jQuery.each(result.data, function(key, val){
                     if(val.values && val.values.length > 0) {
                        jQuery.each(val.values, function(attrKey, attrVal){
                           html += `<option value="${attrVal.id}">${val.attribute ? val.attribute.name : val.name} - ${attrVal.value}</option>`;
                        });
                     }
                  });

                  html += '</select>';

                  $(".multiAttr").html(html);
                  $("#attribute_id").multiSelect();
                  showAlert(result.status, result.message);
                } else {
                  $(".multiAttr").html('<p class="text-muted">No attributes found for this category.</p>');
                  showAlert('info', 'No attributes available for this category');
                }
            } else {
                 console.log(result);
                 alert(result.message || 'An error occurred');
            }
         },
         error: function(xhr){
            console.log(xhr);
            var errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred';
            showAlert('error', errorMsg);
         }
       });

    });

 </script>

@endsection
