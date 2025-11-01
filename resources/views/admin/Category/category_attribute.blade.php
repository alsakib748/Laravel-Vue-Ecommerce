@extends("admin.layout")

@section("content")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Category Attribute</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Category Attribute
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

        <h6 class="mb-0 text-uppercase">Category Attribute Table</h6>
        <hr />

        <div class="col pb-3">
            <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="saveData('0','','','')">Add Category Attribute</button>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example2" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Attribute Name</th>
                    <th>Category Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach ($data as $key => $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list?->attribute->name }}</td>
                        <td>{{ $list?->category->name }}</td>
                        <td>
                            <button onclick="saveData('{{ $list->id }}','{{ $list->category->id }}','{{ $list->attribute->id }}')" type="button" class="btn btn-outline-success px-4 radius-30" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button>
                            <button onclick="deleteData('{{ $list->id }}','category_attribute')" type="button" class="btn btn-outline-danger px-3 radius-30">Delete</button>
                        </td>
                      </tr>
                    @endforeach
                @endif
                </tbody >
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Attribute Name</th>
                    <th>Category Name</th>
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
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Category Attribute</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

    <form id="formSubmit" action="{{ route('category.attribute.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="modal-body">

            <div class="border p-4 rounded">

                <div class="row mb-3">
                    <label for="text" class="col-sm-3 col-form-label">Attribute</label>
                    <div class="col-sm-9">
                        {{-- <input type="text" class="form-control" name="name" id="enter_name" placeholder="Name"> --}}
                        <select name="attribute_id" id="attribute_id" class="form-control" id="">
                            <option selected value="">Select Attribute</option>
                            @if($attributes->isNotEmpty())
                                @foreach ($attributes as $key => $attribute)
                                   <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="text" class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                        {{-- <input type="text" class="form-control" name="name" id="enter_name" placeholder="Name"> --}}
                        <select name="category_id" id="category_id" class="form-control" id="">
                            <option selected value="">Select Category</option>
                            @if($categories->isNotEmpty())
                                @foreach ($categories as $key => $category)
                                   <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
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

      let checkAttributeId = 0;
      let checkCategoryId = 0;

      function saveData(id, category_id,attribute_id){

        if(checkAttributeId != 0){
            $("#attribute_id option[value='"+checkAttributeId+"']").show();
        }

        if(checkCategoryId != 0){
            $("#category_id option[value='"+checkCategoryId+"']").show();
        }

        checkAttributeId = attribute_id;
        checkCategoryId = category_id;

        $("#enter_id").val(id);
        $("#category_id").val(category_id);
        $("#attribute_id").val(attribute_id);
        $("#category_id option[value='"+category_id+"']").hide();
        $("#attribute_id option[value='"+attribute_id+"']").hide();

      }

  </script>

@endsection
