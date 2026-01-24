<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
<script src="{{ asset('snackbar/dist/js-snackbar.js') }}"></script>
<script src="{{ asset('assets/js/index.js') }}"></script>
<script src="{{ asset('./ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('./ckfinder/ckfinder.js') }}"></script>
<script src="{{ asset('./multi-select/jquery.multi-select.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(function() {
        $('#attribute_id').multiSelect();
        $('#ice-cream').multiSelect();
        $('#line-wrap-example').multiSelect({
            positionMenuWithin: $('.position-menu-within')
        });
        $('#categories').multiSelect({
            noneText: 'All categories',
            presets: [{
                    name: 'All categories',
                    all: true
                },
                {
                    name: 'My categories',
                    options: ['a', 'c']
                }
            ]
        });
        $('#modal-example').multiSelect({
            'modalHTML': '<div class="multi-select-modal">'
        });
    });
</script>

<script>
    // Enable CKEditor for product description only if the element exists
    if (window.CKEDITOR && document.getElementById('desc')) {
        var editor = CKEDITOR.replace('desc');
        CKFinder.setupCKEditor(editor);
    }
</script>

{{-- <script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#mytextarea'
    });
</script> --}}


<!--app JS-->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://developercodez.com/developerCorner/parsley/parsley.min.js"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on("click", function(event) {
            event.preventDefault();
            if ($("#show_hide_password input").attr("type") == "text") {
                $("#show_hide_password input").attr("type", "password");
                $("#show_hide_password i").addClass("bx-hide");
                $("#show_hide_password i").removeClass("bx-show");
            } else if (
                $("#show_hide_password input").attr("type") == "password"
            ) {
                $("#show_hide_password input").attr("type", "text");
                $("#show_hide_password i").removeClass("bx-hide");
                $("#show_hide_password i").addClass("bx-show");
            }
        });
    });
</script>

<script>
    function showAlert(status, message) {
        SnackBar({
            status: status,
            message: message,
            position: "br"
        });
    }
</script>

<script>
    $(document).ready(function(f) {

        $("#formSubmit").on("submit", function(e) {
            // alert("working");
            if ($(this).parsley().validate()) {

                e.preventDefault();

                // Ensure CKEditor content syncs back to the textarea before submitting
                if (window.CKEDITOR && CKEDITOR.instances.desc) {
                    CKEDITOR.instances.desc.updateElement();
                }

                var formData = new FormData(this);

                var html = `<button class="btn btn-primary" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									Loading...</button>`;

                var html1 = `<input type="submit" name="submit" class="btn btn-primary px-4"
                                                    value="Save Changes" />`;
                $("#submitButton").html(html);

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(result) {
                        //    console.log(result);

                        if (result.status == "Success") {
                            //    SnackBar({
                            //       status: result.status,
                            //       message: result.message,
                            //       position: "br"
                            //    });
                            showAlert(result.status, result.message);
                            $("#submitButton").html(html1);

                            // Handle reload or redirect
                            if (result.data && result.data.reload) {
                                if (result.data.redirect) {
                                    // Redirect to the specified URL
                                    setTimeout(function() {
                                        window.location.href = result.data.redirect;
                                    }, 1000);
                                } else {
                                    // Reload current page if no redirect URL provided
                                    setTimeout(function() {
                                        window.location.href = window.location.href;
                                    }, 1000);
                                }
                            }
                            //    alert('Profile updated successfully!');
                        } else {
                            //     SnackBar({
                            //       status: result.status,
                            //       message: result.message,
                            //       position: "br"
                            //    });
                            showAlert(result.status, result.message);
                            $("#submitButton").html(html1);
                            //    alert('Error: ' + result.message);
                        }

                    },
                    error: function(xhr, status, error) {
                        showAlert(xhr.responseText.status, xhr.responseText.message);
                        $("#submitButton").html(html1);
                        // console.log(xhr.responseText);
                    },
                    // complete: function(xhr, status){
                    //     console.log(xhr.responseText);
                    // }

                    // $("#submitButton").html(html1);
                });
            }

        });

    });


    function deleteData(id, table) {
        Swal.fire({
            title: 'Delete?',
            text: 'Are you sure you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Use product-specific delete endpoint when deleting products
                const url = table === 'products' ?
                    "{{ url('/admin/product/delete') }}/" + id :
                    "{{ url('/admin/deleteData') }}/" + id + "/" + table;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: '',
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(result) {
                        if (result.status === "Success") {
                            showAlert(result.status, result.message);
                            if (result.data && result.data.reload !== undefined) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 800);
                            }
                        } else {
                            showAlert(result.status, result.message);
                        }
                    },
                    error: function(xhr) {
                        showAlert('Error', xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'Request failed');
                    },
                });
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $("#example").DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        var table = $("#example2").DataTable({
            lengthChange: false,
            buttons: ["copy", "excel", "pdf", "print"]
        });

        table
            .buttons()
            .container()
            .appendTo("#example2_wrapper .col-md-6:eq(0)");
    });
</script>
