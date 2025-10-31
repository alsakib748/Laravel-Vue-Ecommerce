@extends("admin.layout")

@section("content")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Category</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Category
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button"
                        class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <h6 class="mb-0 text-uppercase">Category Table</h6>
        <hr />

        <div class="col pb-3">
            <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="saveData('0','','','')">Add Category</button>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example2" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach ($data as $key => $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list->name }}</td>
                        <td>
                            {{-- <img src="{{ asset($list->image) }}" alt="" class="img-fluid"> --}}
                            <img src="{{ asset($list->image) }}" style="width: 120px;height: 90px;" alt="">
                        </td>
                        <td>{{ $list->value }}</td>
                        <td>
                            <button onclick="saveData('{{ $list->id }}','{{ $list->name }}','{{ $list->slug }}','{{ $list->image }}','{{ $list->parent_category_id }}')" type="button" class="btn btn-outline-success px-4 radius-30" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button>
                            <button onclick="deleteData('{{ $list->id }}','categories')" type="button" class="btn btn-outline-danger px-3 radius-30">Delete</button>
                        </td>
                      </tr>
                    @endforeach
                @endif
                </tbody >
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Category</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

    <form id="formSubmit" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="modal-body">

            <div class="border p-4 rounded">

                {{-- <div class="card-title d-flex align-items-center">
                    <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                    </div>
                    <h5 class="mb-0 text-info">User Registration</h5>
                </div>
                <hr> --}}

                <div class="row mb-3">
                    <label for="text" class="col-sm-3 col-form-label">Category Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="enter_name" placeholder="Enter Category Name">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="text" class="col-sm-3 col-form-label">Slug</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="slug" id="enter_slug" placeholder="Enter Category Slug">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="text" class="col-sm-3 col-form-label">Parent Category Id</label>
                    <div class="col-sm-9">
                        {{-- <input type="text" class="form-control" name="name" id="enter_name" placeholder="Name"> --}}
                        <select name="parent_category_id" id="parent_category_id" class="form-control" id="">
                            <option selected value="">Select Parent Id</option>
                            @if($attributes->isNotEmpty())
                                @foreach ($attributes as $key => $attribute)
                                   <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="enter_image" class="col-sm-3 col-form-label">Image</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="image" id="enter_image" placeholder="Image">
                    </div>
                    <div id="image_key">
                        <img src="" id="imgPreview" height="200px" width="200px" alt="" class="img-fluid">
                    </div>
                </div>

                <input type="hidden" name="id" id="enter_id" />

            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <span id="submitButton">
            <button type="submit" class="btn btn-primary">Save Change</button>
          </span>
        </div>

    </form>

      </div>
    </div>
  </div>

  <script>

      function saveData(id, name,slug,image, parent_category_id){
        $("#enter_id").val(id);
        $("#enter_name").val(name);
        $("#enter_slug").val(slug);
        $("#parent_category_id").val(parent_category_id);
        // $("#enter_image").val(image);

        // console.log($("#enter_image").val(image));

        var key_image;

        if (!image) {
            key_image = "{{ asset('images/upload.png') }}";
        } else {
            key_image = "{{ url('/') }}/" + String(image).replace(/^\/+/, '');
        }

        var html = `<img src="${key_image}" id="imgPreview" height="200px" width="200px" alt="" class="img-fluid">`;
        $('#image_key').html(html);

      }

  </script>

@endsection
