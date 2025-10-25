<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class createViewFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:adminTableView {view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewname = $this->argument('view');

        $viewname = $viewname . '.blade.php';

        $pathname = "resources/views/{$viewname}";

        if (File::exists($pathname)) {
            $this->error("file {$pathname} is already exist ");
            return Command::FAILURE;
        }

        $dir = dirname($pathname);

        if (!file_exists($dir)) {
            File::makeDirectory($dir, 0755, true);
            $this->info("Created directory: {$dir}");
        }

        // Generate dynamic content based on view name
        $viewPath = str_replace('.blade.php', '', $viewname);
        $segments = explode('/', $viewPath);
        $lastSegment = end($segments);
        $title = ucwords(str_replace('_', ' ', $lastSegment));

        $content = $this->generateViewContent($title, $viewPath);

        // Write the file
        File::put($pathname, $content);

        $this->info("Admin view created successfully: {$pathname}");

        return Command::SUCCESS;

    }

    private function generateViewContent($title, $viewPath)
    {
        return '@extends("admin.layout")

@section("content")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Home Banners</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Home Banners
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

        <h6 class="mb-0 text-uppercase">Home Banner Table</h6>
        <hr />

        <div class="col">
            <button type="button" class="btn btn-outline-info px-5 radius-30">Add Home Banner</button>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example2" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                  </tr>
                </thead>
                <tbody>
                @if($data->isNotEmpty())
                    @foreach ($data as $key => $list)
                    <tr>
                        <td>{{ $list->id }}</td>
                        <td>{{ $list->text }}</td>
                        <td>{{ $list->link }}</td>
                        <td>
                            <img src="{{ asset($list->image) }}" alt="" class="img-fluid" />
                        </td>
                        <td>{{ $list->created_at }}</td>
                        <td>{{ $list->updated_at }}</td>
                      </tr>
                    @endforeach
                @endif
                </tbody >
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>

    </div>
</div>
@endsection
';
    }


}