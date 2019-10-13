@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="content-right">
                        <a href="{{ route('category.create') }}" class="btn btn-info">Add Category</a>
                    </div>
                    <table id="categories" class="text-center table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($categories) > 0)
                            <?php $counter = 1; ?>
                            @foreach ($categories as $category)
                            <tr>
                                <input type="hidden" class="category-id" value="{{$category->id}}">
                                <td>{{$counter}}</td>
                                <td id="categoryName{{$category->id}}">{{$category->name}}</td>
                                <td>{{dateTimeToString($category->created_at)}}</td>
                                <td>{{timeElapsedString($category->updated_at)}}</td>
                                <td>
                                    <button class="btn btn-warning update-category"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger delete-category"><i
                                            class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade bd-example-modal-lg" id="updateCategoryModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="hidden" id="categoryId">
                    <input type="test" class="form-control" id="updateCategoryName" required="" autofocus="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnUpdateCategory">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection