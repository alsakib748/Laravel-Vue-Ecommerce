@extends('admin.layout')

@section('content')
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
                            <a href="{{ route('product.index') }}" class="text-decoration-none">
                                <button type="button" class="btn btn-outline-info px-5 radius-30">View Product
                                    List</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <form id="formSubmit" action="{{ url('admin/updateProduct') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card border-top border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="card-title d-flex align-items-center">
                                        <div>
                                        </div>
                                        <h5 class="mb-0 text-info">{{ $data->id ? 'Edit Product' : 'Add Product' }}</h5>
                                    </div>
                                    <hr>
                                    <input type="hidden" name="id" value="{{ $data->id ?? 0 }}">
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name"
                                                id="inputEnterYourName" value="{{ $data->name }}"
                                                placeholder="Enter Product Name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Slug</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="slug"
                                                id="inputEnterYourName" value="{{ $data->slug }}"
                                                placeholder="Enter Product Slug">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product
                                            Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="image"
                                                id="inputEnterYourName" placeholder="Enter Product Image">
                                            @if ($data->id && $data->image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($data->image) }}" alt="Current Image"
                                                        style="width: 150px; height: 150px; object-fit: cover;"
                                                        class="img-thumbnail">
                                                    <p class="text-muted small mt-1">Current Image</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Item Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="item_code"
                                                id="inputEnterYourName" value="{{ $data->item_code }}"
                                                placeholder="Enter Product Item Code">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Keywords</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="keywords"
                                                id="inputEnterYourName" value="{{ $data->keywords }}"
                                                placeholder="Enter Product Keywords">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <select name="category_id" class="form-control" id="category">
                                                <option value="" class="">Select Category</option>
                                                @foreach ($category as $catList)
                                                    <option value="{{ $catList->id }}"
                                                        {{ $data->category_id == $catList->id ? 'selected' : '' }}>
                                                        {{ $catList->name }}</option>
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
                                                    <option value="{{ $brand->id }}"
                                                        {{ $data->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
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
                                                    <option value="{{ $taxList->id }}"
                                                        {{ $data->tax_id == $taxList->id ? 'selected' : '' }}>
                                                        {{ $taxList->text }}%</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">Product
                                            Attributes</label>
                                        <div class="col-sm-4">
                                            <button type="button" id="addAttribute" class="btn btn-info w-100">Add
                                                Attribute</button>
                                        </div>
                                        <div class="" id="addAttributeContent">
                                            @if ($product_attr->count() > 0)
                                                @foreach ($product_attr as $index => $attr)
                                                    <div class="attribute-item mt-4"
                                                        data-attr-index="{{ $index }}">
                                                        <div class="row">
                                                            <div class="col-sm-3"></div>
                                                            <div class="col-sm-9">
                                                                <div class="d-flex justify-content-end mb-2">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm removeAttribute">
                                                                        Remove Attribute</button>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-3 mb-3">
                                                                        <select name="color[]" class="form-control">
                                                                            @foreach ($color as $colorList)
                                                                                <option value="{{ $colorList->id }}"
                                                                                    {{ $attr->color_id == $colorList->id ? 'selected' : '' }}
                                                                                    style="background-color:{{ $colorList->value }};color: #fff;"
                                                                                    class="box_color">
                                                                                    {{ $colorList->color }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <select name="size[]" class="form-control">
                                                                            @foreach ($size as $sizeList)
                                                                                <option value="{{ $sizeList->id }}"
                                                                                    {{ $attr->size_id == $sizeList->id ? 'selected' : '' }}
                                                                                    class="box_color">
                                                                                    {{ $sizeList->size }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="sku[]"
                                                                            class="form-control" placeholder="Enter SKU"
                                                                            value="{{ $attr->sku }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="mrp[]"
                                                                            class="form-control" placeholder="Enter MRP"
                                                                            value="{{ $attr->mrp }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="price[]"
                                                                            class="form-control" placeholder="Enter Price"
                                                                            value="{{ $attr->price }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="length[]"
                                                                            class="form-control"
                                                                            placeholder="Enter Length"
                                                                            value="{{ $attr->length }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="breadth[]"
                                                                            class="form-control"
                                                                            placeholder="Enter Breadth"
                                                                            value="{{ $attr->breadth }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="height[]"
                                                                            class="form-control"
                                                                            placeholder="Enter Height"
                                                                            value="{{ $attr->height }}" />
                                                                    </div>
                                                                    <div class="col-sm-3 mb-3">
                                                                        <input type="text" name="weight[]"
                                                                            class="form-control"
                                                                            placeholder="Enter Weight"
                                                                            value="{{ $attr->weight }}" />
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                            class="col-sm-3 col-form-label">Product
                                                                            Images</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="mb-3">
                                                                                <button type="button"
                                                                                    class="btn btn-info add-image">Add
                                                                                    Image</button>
                                                                            </div>
                                                                            @if (isset($product_attr_images[$attr->id]) && $product_attr_images[$attr->id]->count() > 0)
                                                                                <div class="mb-3">
                                                                                    <p class="text-muted small">Existing
                                                                                        Images:</p>
                                                                                    <div class="d-flex flex-wrap gap-2 existing-images-container"
                                                                                        data-attr-id="{{ $attr->id }}">
                                                                                        @foreach ($product_attr_images[$attr->id] as $img)
                                                                                            <div class="position-relative existing-image-item"
                                                                                                style="width: 100px;"
                                                                                                data-image-id="{{ $img->id }}">
                                                                                                <img src="{{ asset($img->image) }}"
                                                                                                    alt="Existing Image"
                                                                                                    style="width: 100px; height: 100px; object-fit: cover;"
                                                                                                    class="img-thumbnail">
                                                                                                <button type="button"
                                                                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing-image"
                                                                                                    style="width: 24px; height: 24px; padding: 2px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                                                                    <i class='bx bx-trash'
                                                                                                        style="font-size: 12px;"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                            <input type="hidden"
                                                                                                name="keep_image[]"
                                                                                                class="keep-image-input"
                                                                                                value="{{ $img->id }}">
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            <div class="row add-image-multiple-input">
                                                                                <div
                                                                                    class="col-sm-12 mb-3 image-input-wrapper">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <input type="file"
                                                                                            name="attr_image[{{ $index }}][]"
                                                                                            class="form-control"
                                                                                            placeholder="Enter Product Image">
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-sm ms-2 remove-image-input"><i
                                                                                                class='bx bx-trash'></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="attribute-item mt-4" data-attr-index="0">
                                                    <div class="row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <div class="d-flex justify-content-end mb-2">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm removeAttribute">
                                                                    Remove Attribute</button>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-sm-3 mb-3">
                                                                    <select name="color[]" class="form-control">
                                                                        @foreach ($color as $colorList)
                                                                            <option value="{{ $colorList->id }}"
                                                                                style="background-color:{{ $colorList->value }};color: #fff;"
                                                                                class="box_color">{{ $colorList->color }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <select name="size[]" class="form-control">
                                                                        @foreach ($size as $sizeList)
                                                                            <option value="{{ $sizeList->id }}"
                                                                                class="box_color">{{ $sizeList->size }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="sku[]"
                                                                        class="form-control" placeholder="Enter SKU" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="mrp[]"
                                                                        class="form-control" placeholder="Enter MRP" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="price[]"
                                                                        class="form-control" placeholder="Enter Price" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="length[]"
                                                                        class="form-control" placeholder="Enter Length" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="breadth[]"
                                                                        class="form-control"
                                                                        placeholder="Enter Breadth" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="height[]"
                                                                        class="form-control" placeholder="Enter Height" />
                                                                </div>
                                                                <div class="col-sm-3 mb-3">
                                                                    <input type="text" name="weight[]"
                                                                        class="form-control" placeholder="Enter Weight" />
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                        class="col-sm-3 col-form-label">Product
                                                                        Images</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="mb-3">
                                                                            <button type="button"
                                                                                class="btn btn-info add-image">Add
                                                                                Image</button>
                                                                        </div>
                                                                        <div class="row add-image-multiple-input">
                                                                            <div
                                                                                class="col-sm-12 mb-3 image-input-wrapper">
                                                                                <div class="d-flex align-items-center">
                                                                                    <input type="file"
                                                                                        name="attr_image[0][]"
                                                                                        class="form-control"
                                                                                        placeholder="Enter Product Image">
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm ms-2 remove-image-input"><i
                                                                                            class='bx bx-trash'></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="inputPhoneNo2" class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea id="desc" name="description" class="form-control" rows="5"
                                                placeholder="Enter product description">{{ $data->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit"
                                                class="btn btn-info px-5">{{ $data->id ? 'Update Product' : 'Add Product' }}</button>
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
                'id' => $c->id,
                'value' => $c->value,
                'label' => $c->color,
            ];
        });

        $sizeOptions = $size->map(function ($s) {
            return [
                'id' => $s->id,
                'label' => $s->size,
            ];
        });

        $selectedAttributes = isset($product_attributes) ? $product_attributes : [];
    @endphp

    <script>
        // Track attribute index for proper image association
        let attributeIndex = 0;
        const selectedAttributes = @json($selectedAttributes);

        // Initialize attribute index based on existing attributes
        $(document).ready(function() {
            attributeIndex = $('.attribute-item').length;

            // If category is already selected, load attributes
            const categoryId = $("#category").val();
            if (categoryId && selectedAttributes.length > 0) {
                loadCategoryAttributes(categoryId, selectedAttributes);
            }
        });

        // Handle Add Attribute button click
        $(document).on('click', '#addAttribute', function() {

            const colors = @json($colorOptions);
            const sizes = @json($sizeOptions);

            const colorSelect = colors.map(c =>
                `<option value="${c.id}" style="background-color:${c.value};color:#fff">${c.label}</option>`
            ).join('');

            const sizeSelect = sizes.map(s =>
                `<option value="${s.id}">${s.label}</option>`
            ).join('');

            const currentIndex = attributeIndex;
            attributeIndex++;

            const html = `
            <div class="attribute-item mt-4" data-attr-index="${currentIndex}">
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
                                        <div class="col-sm-12 mb-3 image-input-wrapper">
                                            <div class="d-flex align-items-center">
                                                <input type="file" name="attr_image[${currentIndex}][]" class="form-control" placeholder="Enter Product Image">
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
        $(document).on('click', '.removeAttribute', function() {
            $(this).closest('.attribute-item').remove();
        });

        // Handle Add Image button click - append new image input
        $(document).on('click', '.add-image', function() {
            // Get the attribute index from the parent attribute-item
            const attrItem = $(this).closest('.attribute-item');
            const attrIndex = attrItem.length > 0 ? attrItem.data('attr-index') : 0;

            const imageInputHtml = `
            <div class="col-sm-12 mb-3 image-input-wrapper">
                <div class="d-flex align-items-center">
                    <input type="file" name="attr_image[${attrIndex}][]" class="form-control" placeholder="Enter Product Image">
                    <button type="button" class="btn btn-danger btn-sm ms-2 remove-image-input"><i class='bx bx-trash'></i></button>
                </div>
            </div>
        `;
            // Find the closest parent row that contains the Product Images section, then find the add-image-multiple-input container
            $(this).closest('.row.mb-3').find('.add-image-multiple-input').append(imageInputHtml);
        });

        // Handle Remove Image Input button click
        $(document).on('click', '.remove-image-input', function() {
            $(this).closest('.image-input-wrapper').remove();
        });

        // Handle Remove Existing Image button click
        $(document).on('click', '.remove-existing-image', function(e) {

            e.preventDefault();
            const imageItem = $(this).closest('.existing-image-item');
            const imageId = imageItem.data('image-id');

            // Remove the image display
            imageItem.remove();

            // Remove or disable the keep_image input
            $(`.keep-image-input[value="${imageId}"]`).remove();

            // Add the image id to the deleted images list
            if ($('#deleted-images').length === 0) {
                $('#formSubmit').append('<input type="hidden" id="deleted-images" name="deleted_images" value="">');
            }

            const deletedImages = $('#deleted-images').val();
            const imageIds = deletedImages ? deletedImages.split(',') : [];
            if (!imageIds.includes(imageId.toString())) {
                imageIds.push(imageId);
            }
            $('#deleted-images').val(imageIds.join(','));
        });

        function loadCategoryAttributes(cat, preSelected = []) {
            if (!cat) {
                $(".multiAttr").html('');
                return;
            }

            var html = '<select id="attribute_id" class="form-control" name="attribute_id[]" multiple>';

            var url = "{{ route('product.getAttributes') }}";

            $.ajax({
                url: url,
                data: {
                    cat: cat
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'POST',
                success: function(result) {
                    if (result.status == 'Success') {
                        if (result.data && result.data.length > 0) {

                            jQuery.each(result.data, function(key, val) {
                                if (val.values && val.values.length > 0) {
                                    jQuery.each(val.values, function(attrKey, attrVal) {
                                        const isSelected = preSelected.includes(attrVal.id) ?
                                            'selected' : '';
                                        html +=
                                            `<option value="${attrVal.id}" ${isSelected}>${val.attribute ? val.attribute.name : val.name} - ${attrVal.value}</option>`;
                                    });
                                }
                            });

                            html += '</select>';

                            $(".multiAttr").html(html);
                            $("#attribute_id").multiSelect();
                            if (preSelected.length > 0) {
                                // Refresh multiSelect to show selected values
                                $("#attribute_id").multiSelect('refresh');
                            }
                            if (typeof showAlert !== 'undefined') {
                                showAlert(result.status, result.message);
                            }
                        } else {
                            $(".multiAttr").html(
                                '<p class="text-muted">No attributes found for this category.</p>');
                            if (typeof showAlert !== 'undefined') {
                                showAlert('info', 'No attributes available for this category');
                            }
                        }
                    } else {
                        console.log(result);
                        alert(result.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    var errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message :
                        'An error occurred';
                    if (typeof showAlert !== 'undefined') {
                        showAlert('error', errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                }
            });
        }

        $("#category").on('change', function(e) {
            const cat = $(this).val();
            loadCategoryAttributes(cat, []);
        });
    </script>
@endsection
