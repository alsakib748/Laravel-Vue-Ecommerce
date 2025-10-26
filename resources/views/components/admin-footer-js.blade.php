<!-- Bootstrap JS -->
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

    function showAlert(status, message)
    {
        SnackBar({
            status: status,
            message: message,
            position: "br"
        });
    }

</script>

<script>

    $(document).ready(function(f){

        $("#formSubmit").on("submit", function(e){
        // alert("working");
        if($(this).parsley().validate()){

            e.preventDefault();
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
                success: function(result){
                //    console.log(result);

                   if(result.status == "Success"){
                    //    SnackBar({
                    //       status: result.status,
                    //       message: result.message,
                    //       position: "br"
                    //    });
                    showAlert(result.status, result.message);
                       $("#submitButton").html(html1);
                    if(result.data.reload != undefined){
                        window.location.href = window.location.href;
                    }
                    //    alert('Profile updated successfully!');
                   }else{
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
                error: function(xhr, status, error){
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


    function deleteData(id, table){

        let text = "Are you sure want to delete";

        if(confirm(text) == true){

    //   let str = '/'+id+'/'+table;

    //    let actionUrl = "{{ url('deleteData"+str+"') }}";

           $.ajax({
                type: "GET",
                url: "{{ url('/admin/deleteData') }}/" + id + "/" + table,
                data: '',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(result){
                //    console.log(result);

                   if(result.status == "Success"){
                    //    SnackBar({
                    //       status: result.status,
                    //       message: result.message,
                    //       position: "br"
                    //    });
                    showAlert(result.status, result.message);

                    if(result.data.reload != undefined){
                        window.location.href = window.location.href;
                    }
                    //    alert('Profile updated successfully!');
                   }else{
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
                error: function(xhr, status, error){
                    showAlert(xhr.responseText.status, xhr.responseText.message);

                },
            });

        }

    }

</script>

<script>
    $(document).ready(function () {
      $("#example").DataTable();
    });
  </script>
  <script>
    $(document).ready(function () {
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
