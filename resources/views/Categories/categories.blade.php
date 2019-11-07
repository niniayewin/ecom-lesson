@extends('layouts.app')
@section('title') Category @stop
@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-sm-3">
            @include('partical.menu')
        </div>
        <div class="col-sm-9">
            <div><i class="fas fa-clipboard-list"></i></div>
            <div class="dropdown-divider"></div>
            <div class="row">
            <div class="col-sm-3">
                <form method="post" action="{{route('new.post')}}">
                    @csrf
                   <div class="form-group">
                     <label for="cat_name">Category Name</label>
                       <input type="text" name="cat_name" id="cat_name" class="form-control @if($errors->has('cat_name')) is-invalid  @endif">
                       @if($errors->has('cat_name'))<span class="invalid-feedback"> {{$errors->first('cat_name')}}</span> @endif
                   </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary">Save</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-9">
            <table class="table table-hover table-borderless">
                <tr>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
                @foreach($cats as $c)
                    <tr>
                        <td>{{$c->cat_name}}</td>
                        <td>

                            <a data-toggle="modal" data-target="#e{{$c->id}}" href="#" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <div  id="e{{$c->id}}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                             <div class="modal-content">
                                        <form method="post" action="{{route('update.category')}}">
                                            @csrf
                                            <input type="hidden" name="cat_id" value="{{$c->id}}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                              <div class="form-group">
                                                 <label for="cat_name">Category Name</label>
                                                <input type="text" name="cat_name" id="cat_name" class="form-control" value="{{$c->cat_name}}">
                                            </div>
                                         </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-outline-primary">Save Changed</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a  data-toggle="modal" data-target="#d{{$c->id}}" href="#" class="btn btn-outline-danger"><i class="fas fa-times-circle"></i></a>
                            <!-- delete Modal-->
                            <div  id="d{{$c->id}}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center text-warning">
                                            <i class="fas fa-exclamation-triangle fa-3x"></i>
                                            <p>Are you sure?the category <b>"{{$c->cat_name}}"</b> will be delected</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{route('delete.category',['id'=>$c->id])}}"> Agree</a>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            </div>
            </div>
        </div>
        </div>
    </div>
    @if (Session('info'))
        <div  class="alert alert-success my-alert"> {{Session('info')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
               </button></div>
    @endif
@stop






