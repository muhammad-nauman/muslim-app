function onDelete(form) {
    swal({
        title: "Are you sure?",
        text: "This action will delete the user!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
        form.submit();
    });
}