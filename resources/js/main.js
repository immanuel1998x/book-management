import Swal from "sweetalert2";
import Toastr from "toastr";

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let bookmark = window.location.origin + '/bookmark';
    let bookmarkCreate = window.location.origin + '/bookmark/create';
    let bookmarkShow = window.location.origin + '/bookmark/show';

    if (window.location.href === bookmark) {
        $('#book').attr('class', 'nav-link dropdown-toggle');
    } else if (window.location.href === bookmarkCreate) {
        $('#book').attr('class', 'nav-link dropdown-toggle');
    } else if (window.location.href === bookmarkShow) {
        $('#book').attr('class', 'nav-link dropdown-toggle');
    }

    /* Category */

    // datatables
    $('#categories').DataTable({
        "columnDefs": [
            { "width": "10px", "targets": 0 },
            { "width": "30px", "targets": 1 },
            { "width": "100px", "targets": 2 },
            { "width": "70px", "targets": 3 },
            { "width": "70px", "targets": 4 },
        ]
    });

    // update category
    $(document).on('click', '.update-category', function() {
        let tr = $(this).closest('tr');
        let id = tr.find('.category-id').val();

        $.ajax({
            type: 'post',
            url: '/category/fetch/',
            data: { id: id },
            dataType: "text",
            success: function(response) {
                let jsonResponse = JSON.parse(response);
                $('#categoryId').val(id);
                $('#updateCategoryName').val(jsonResponse[0]);
                $('#updateCategoryModal').modal('toggle');
            }
        });
    });

    $('#btnUpdateCategory').on('click', function() {
        let id = $('#categoryId').val();
        let name = $('#categoryName' + id).text();
        let updateName = $('#updateCategoryName').val();

        if (name !== updateName) {
            $.ajax({
                type: 'put',
                url: '/category/' + id,
                data: { name: updateName },
                dataType: 'text',
                success: function(response) {
                    let jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        $('#categoryName' + id).text(updateName);
                        $('#updateCategoryModal').modal('toggle');
                        Swal.fire({
                            title: 'Updated!',
                            text: "Category was successfully updated.",
                            type: 'success',
                        }).then((result) => {
                            if (result.value) {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#updateCategoryModal').modal('toggle');
                    Swal.fire({
                        title: 'Update Failed!',
                        text: "Unable to update your category.",
                        type: 'error',
                    }).then((result) => {
                        if (result.value) {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    // delete category
    $(document).on('click', '.delete-category', function() {
        let tr = $(this).closest('tr');
        let id = tr.find('.category-id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'delete',
                    url: '/category/' + id,
                    dataType: 'text',
                    success: function(response) {
                        let jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            tr.remove();
                            Swal.fire({
                                title: 'Deleted!',
                                text: "Your category has been deleted.",
                                type: 'success',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            }
        })
    });

    /* Category */

    // update book
    $(document).on('click', '.update-book', function() {
        let div = $(this).closest('div');
        let id = div.find('.book-id').val();

        $.ajax({
            type: 'post',
            url: '/book/fetch/',
            data: { id: id },
            dataType: 'text',
            success: function(response) {
                let jsonResponse = JSON.parse(response);
                $('#bookId').val(id);
                $("#bookCategory option").each(function() {
                    if ($(this).val() == jsonResponse[0].category_id) {
                        $(this).attr("selected", "selected");
                    }
                });

                $('#title').val(jsonResponse[0].title);
                $('#author').val(jsonResponse[0].author);
                $('#description').val(jsonResponse[0].description);
                $('#updateBookModal').modal('toggle');
            }
        });
    });

    $('#updateBookModal').on('hidden.bs.modal', function() {
        $('#bookCategory option').attr("selected", false);
        $('#image').val('');
    });

    $('#btnUpdateBook').on('click', function() {
        let id = $('#bookId').val();
        let property = document.getElementById('image').files[0];

        if (property !== undefined) {
            $.ajax({
                type: "post",
                url: "/book/fetch",
                data: { id: id },
                dataType: "text",
                success: function(response) {
                    let jsonResponse = JSON.parse(response);

                    let category = $('#bookCategory').val();
                    let title = $('#title').val();
                    let author = $('#author').val();
                    let description = $('#description').val();

                    if (category != jsonResponse[0].category_id ||
                        title != jsonResponse[0].title ||
                        author != jsonResponse[0].author ||
                        description != jsonResponse[0].description) {

                        let formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('key', 'updateBookWithImage');
                        formData.append('id', id);
                        formData.append('category', category);
                        formData.append('title', title);
                        formData.append('author', author);
                        formData.append('description', description);
                        formData.append('image', property);

                        $.ajax({
                            type: 'post',
                            url: '/book/' + id,
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "text",
                            success: function(response) {
                                let jsonResponse = JSON.parse(response);

                                if (jsonResponse.success) {
                                    $('#updateBookModal').modal('toggle');
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: "Book image was successfully updated.",
                                        type: 'success',
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    $('#updateBookModal').modal('toggle');
                                    Swal.fire({
                                        title: 'Update Failed!',
                                        text: "Unable to update your book image.",
                                        type: 'error',
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            }
                        });
                    } else {
                        let formData = new FormData();
                        formData.append('_method', 'PUT');
                        formData.append('key', 'updateImage');
                        formData.append('id', id);
                        formData.append('image', property);

                        $.ajax({
                            type: 'post',
                            url: '/book/' + id,
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: "text",
                            success: function(response) {
                                let jsonResponse = JSON.parse(response);
                                if (jsonResponse.success) {
                                    $('#updateBookModal').modal('toggle');
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: "Book image was successfully updated.",
                                        type: 'success',
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    $('#updateBookModal').modal('toggle');
                                    Swal.fire({
                                        title: 'Update Failed!',
                                        text: "Unable to update your book image.",
                                        type: 'error',
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "/book/fetch",
                data: { id: id },
                dataType: "text",
                success: function(response) {
                    let jsonResponse = JSON.parse(response);
                    let category = $('#bookCategory').val();
                    let title = $('#title').val();
                    let author = $('#author').val();
                    let description = $('#description').val();

                    if (category != jsonResponse[0].category_id ||
                        title != jsonResponse[0].title ||
                        author != jsonResponse[0].author ||
                        description != jsonResponse[0].description) {
                        $.ajax({
                            type: 'put',
                            url: 'book/' + id,
                            data: { key: 'updateBookInfo', category: category, title: title, author: author, description: description },
                            dataType: "text",
                            success: function(response) {
                                let jsonResponse = JSON.parse(response);
                                if (jsonResponse.success) {
                                    setBookCategoryName(id, category);
                                    $('.title-' + id).text(title);
                                    $('.author-' + id).text(author);
                                    $('.description-' + id).text(description);

                                    $('#updateBookModal').modal('toggle');
                                    Swal.fire({
                                        title: 'Updated!',
                                        text: "Book was successfully updated.",
                                        type: 'success',
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    // delete book
    $(document).on('click', '.delete-book', function() {
        let div = $(this).closest('div');
        let id = div.find('.book-id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "delete",
                    url: "/book/" + id,
                    dataType: "json",
                    success: function(deleted) {
                        if (deleted) {
                            $('.book' + id).remove();
                            Swal.fire({
                                title: 'Deleted!',
                                text: "Your book has been deleted.",
                                type: 'success',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            });
                        }
                    }
                });
            }
        })
    });

    function setBookCategoryName(id, category_id) {
        $.ajax({
            type: "post",
            url: "/category/fetch/",
            data: { id: category_id },
            dataType: "json",
            success: function(response) {
                $('.category-' + id).text(response[0]);
            }
        });
    }

    // messages
    let errorMessage = $('.alert.alert-danger').length;
    if (errorMessage) {
        $('#app').scrollTop();
    }

    let book = window.location.origin + '/book';

    if (window.location.href === book) {
        $('#app').scrollTop();
    }

    // total books
    $('#countBooks').on('click', function() {
        $.post('/book/total', function(data) {
            if (parseInt(data) > 0) {
                Toastr.info('Total Books: ' + data);
            }
        });
    });

    Toastr.options = {
        tapToDismiss: true,
        preventDuplicates: true,
        toastClass: 'toast',
        containerId: 'toast-container',
        debug: false,
        fadeIn: 300,
        fadeOut: 1000,
        extendedTimeOut: 1000,
        iconClass: 'toast-info',
        positionClass: 'toast-top-right',
        timeOut: 2000,
        titleClass: 'toast-title',
        messageClass: 'toast-message'
    }
});